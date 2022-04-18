<?php
class User_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }
    
    function get_login($email,$password,$terms=null) {

    	if(is_null($terms)){
			$sql = "select a.id_user,b.id_employee,b.nik,b.jenis_kelamin,a.nama,b.nama_karyawan,a.id_perusahaan,b.email,a.usergroup,a.userstatus,b.foto from t_user a inner join t_employee b on a.id_employee = b.id_employee where b.email = ? and a.password = ?";
			$query = $this->db->query($sql,array($email,$password));

		}else{
			$sql = "SELECT a.id_user,a.nama,a.id_candidate,b.nama_lengkap nama_karyawan,b.email,a.usergroup,a.password,b.jk,a.userstatus,b.foto FROM t_user a LEFT JOIN t_candidate_employee b ON a.`id_candidate` = b.`id_candidate` WHERE b.`email` = ? AND a.`password` = ?";
			$query = $this->db->query($sql,array($email,$password));
		}
		return $query->result_array();
    }  
	
	
	function get_data_perusahaan() {
		$sql = "SELECT id_perusahaan, nama_perusahaan,domain, icon, logo, logodepan FROM t_perusahaan";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_data_kandidat() {
		$sql = "SELECT id_candidate, nama_lengkap FROM t_candidate_employee";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	// function get_data_pegawai() {
	// 	$sql = "SELECT id_employee, nama_karyawan FROM t_employee";
	// 	$query = $this->db->query($sql);
	// 	return $query->result_array();
	// }
	
	function upd_login_date($id_emp) {
		$sql = "UPDATE t_user SET lastlogin = now() WHERE id_employee = ? ";
		$this->db->query($sql,array($id_emp));
	}

	function get_perusahaan($id=null){
		$query = $this->db->get('t_perusahaan',array('id_perusahaan' => $id));
		return $query->result_array();
	}
	
	function dataakun_insert($kode,$keterangan) {
		$sql = "select id from t_akun where kode = ? ";
		$query = $this->db->query($sql,array($kode));
		$hasil = $query->result_array();
		if (sizeof($hasil)==0) {
			$sql = "insert into t_akun (kode,nama,deskripsi) values (?,?,?) ";
			$this->db->query($sql,array($kode,$keterangan,$keterangan));
		}
	}
	
	function datalap_insert($jenislap,$periode,$kode,$keterangan,$nilai) {
		$sql = "insert into t_laporan (jenis_lap,periode,akun,keterangan,nilai) values (?,?,?,?,?) ";
		$this->db->query($sql,array($jenislap,$periode,$kode,$keterangan,$nilai));
	}
	
	function get_dataakun() {
		$sql = "select id, pkode, kode, nama, deskripsi from t_akun order by kode";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_datalap($jenislap,$periode) {
		$sql = "select id, akun, keterangan, nilai from t_laporan where jenis_lap = ? and periode = ? ";
		$query = $this->db->query($sql,array($jenislap,$periode));
		return $query->result_array();
	}
	
	function get_datalap_konsol($jenislap,$tahun) {
		$sql = "select id, periode, akun, nilai from t_laporan where jenis_lap = ? and tahun = ? ";
		$query = $this->db->query($sql,array($jenislap,$tahun));
		return $query->result_array();
	}
	
	function upd_login_date_candidate($id) {
		$sql = "UPDATE t_user SET lastlogin = now() WHERE id_candidate = ? ";
		$this->db->query($sql,array($id));
	}
	
	function get_datalap_rekap($jenislap,$periode) {
		$sql = "select a.pakun as akun, b.nama as keterangan, sum(a.nilai) as nilai from t_laporan a left outer join t_akun_kategori b on a.pakun = b.kode where a.jenis_lap = ? and a.periode = ? group by a.pakun, b.nama ";
		$query = $this->db->query($sql,array($jenislap,$periode));
		return $query->result_array();
	}	
	
	function get_datalap_rekaptw($jenislap,$tahun) {
		$sql = "select pakun as akun, periode, sum(nilai) as nilai from t_laporan where jenis_lap = ? and tahun = ? group by pakun, periode ";
		$query = $this->db->query($sql,array($jenislap,$tahun));
		return $query->result_array();
	}	
	
	function get_readabsentoday($id_employee = null){
		$sql = "SELECT b.id_absen,a.`id_employee`,a.`nama_karyawan`,a.foto,b.*,c.`nama_pola`,d.nama_ref FROM t_employee a INNER JOIN t_absen b 
				ON a.`id_employee`=b.`id_employee` INNER JOIN t_pola_kerja c ON b.id_pola_kerja=c.`id_pola` INNER JOIN t_referensi_data d 
				ON b.id_ref_absensi = d.id_referensi WHERE b.id_employee = ? AND SUBSTR(b.tanggal,1,10) = SUBSTR(NOW(),1,10)";
		$query = $this->db->query($sql,$id_employee);
		return $query->result_array();
	}
	
	function get_pulang($id_employee = null){
		$sql = "SELECT count(*) employee FROM t_employee a INNER JOIN t_absen b 
				ON a.`id_employee`=b.`id_employee` INNER JOIN t_pola_kerja c ON b.id_pola_kerja=c.`id_pola` INNER JOIN t_referensi_data d 
				ON b.id_ref_absensi = d.id_referensi WHERE b.id_employee = ? AND SUBSTR(b.tanggal,1,10) = SUBSTR(NOW(),1,10)";
		$query = $this->db->query($sql,$id_employee);
		return $query->result_array();
	}
	
	function get_notifikasi($id_approve=null){
		// $sql 	= "SELECT b.id_izin,a.nik,a.foto,a.id_employee,a.`nama_karyawan`,a.`id_approve1`,a.`id_approve2`,b.start_time,b.end_time,b.lama_izin,b.ket,b.tgl_pengajuan,b.status_pengajuan 
				  // FROM t_employee a INNER JOIN t_izin b ON a.id_employee=b.id_employee WHERE a.`id_approve1` = ".$id_approve." AND b.`status_pengajuan` = 2
				  // UNION
				  // SELECT b.id_izin,a.nik,a.foto,a.id_employee,a.`nama_karyawan`,a.`id_approve1`,a.`id_approve2`,b.start_time,b.end_time,b.lama_izin,b.ket,b.tgl_pengajuan,b.status_pengajuan 
				  // FROM t_employee a INNER JOIN t_izin b ON a.id_employee=b.id_employee WHERE a.`id_approve2` = ".$id_approve." AND b.`status_pengajuan` IN (0,1,3)";
		$sql 	= "SELECT b.id_izin,'IZIN' tipe_ajuan,a.nik,a.foto,a.id_employee,a.`nama_karyawan`,a.`id_approve1`,a.`id_approve2`,b.start_time,b.end_time,b.lama_izin,b.ket,b.tgl_pengajuan,b.status_pengajuan 
					FROM t_employee a INNER JOIN t_izin b ON a.id_employee=b.id_employee WHERE a.`id_approve1` = ".$id_approve." AND b.`status_pengajuan` = 2
					UNION
					SELECT b.id_izin,'IZIN' tipe_ajuan,a.nik,a.foto,a.id_employee,a.`nama_karyawan`,a.`id_approve1`,a.`id_approve2`,b.start_time,b.end_time,b.lama_izin,b.ket,b.tgl_pengajuan,b.status_pengajuan 
					FROM t_employee a INNER JOIN t_izin b ON a.id_employee=b.id_employee WHERE a.`id_approve2` = ".$id_approve." AND b.`status_pengajuan` IN (0,1,3)
					UNION 
					SELECT b.id_cuti_p,'CUTI' tipe_ajuan,a.nik,a.foto,a.id_employee,a.`nama_karyawan`,a.`id_approve1`,a.`id_approve2`,b.start_date,b.end_date,b.jumlahhari,b.keperluan,b.tgl_diajukan,b.status_cuti 
					FROM t_employee a INNER JOIN t_cuti_pemakaian b ON a.id_employee=b.id_employee WHERE a.`id_approve1` = ".$id_approve." AND b.`status_cuti` IN (2)
					UNION
					SELECT b.id_cuti_p,'CUTI' tipe_ajuan,a.nik,a.foto,a.id_employee,a.`nama_karyawan`,a.`id_approve1`,a.`id_approve2`,b.start_date,b.end_date,b.jumlahhari,b.keperluan,b.tgl_diajukan,b.status_cuti 
					FROM t_employee a INNER JOIN t_cuti_pemakaian b ON a.id_employee=b.id_employee WHERE a.`id_approve2` = ".$id_approve." AND b.`status_cuti` IN (0,1,3)
					UNION
					SELECT b.id_unpaid_leave,'UNPAID LEAVE' tipe_ajuan,a.nik,a.foto,a.id_employee,a.`nama_karyawan`,a.`id_approve1`,a.`id_approve2`,b.tgl_start_ul,b.tgl_end_ul,b.jumlahcuti,b.keterangan,b.tgl_pengajuan_leave,b.status_approved 
					FROM t_employee a INNER JOIN t_unpaid_leave b ON a.id_employee=b.id_emp WHERE a.`id_approve1` = ".$id_approve." AND b.`status_approved` IN (2)
					UNION
					SELECT b.id_unpaid_leave,'UNPAID LEAVE' tipe_ajuan,a.nik,a.foto,a.id_employee,a.`nama_karyawan`,a.`id_approve1`,a.`id_approve2`,b.tgl_start_ul,b.tgl_end_ul,b.jumlahcuti,b.keterangan,b.tgl_pengajuan_leave,b.status_approved 
					FROM t_employee a INNER JOIN t_unpaid_leave b ON a.id_employee=b.id_emp WHERE a.`id_approve2` = ".$id_approve." AND b.`status_approved` IN (0,1,3)";
		$query = $this->db->query($sql, array($id_approve));
		return $query->result_array();
	}
	
	function get_notifikasi_approve1($id_approve){
		$sql = "SELECT b.id_izin,a.id_employee,a.`nama_karyawan`,a.`id_approve1`,b.start_time,b.end_time,b.lama_izin,b.ket,b.tgl_pengajuan,b.status_pengajuan 
				FROM t_employee a INNER JOIN t_izin b ON a.id_employee=b.id_employee WHERE a.`id_approve1` = ?";
		$query = $this->db->query($sql, array($id_approve));
		return $query->result_array();
	}
	
	function get_notifikasi_approve2($id_approve){
		$sql = "SELECT b.id_izin,a.id_employee,a.`nama_karyawan`,a.`id_approve2`,b.start_time,b.end_time,b.lama_izin,b.ket,b.tgl_pengajuan,b.status_pengajuan 
				FROM t_employee a INNER JOIN t_izin b ON a.id_employee=b.id_employee WHERE a.`id_approve2` = ?";
		$query = $this->db->query($sql, array($id_approve));
		return $query->result_array();
	}
	
	function get_nik_unemployee(){
		return $this->db->select_max('nik')->get_where('t_employee',array('status_employee'=>0))->result_array();
	}

	function insertuser($id_candidate,$hashing,$id_perusahaan){

		$input = array('id_candidate' => $id_candidate, 
						'password' => $hashing,
						'usergroup'=>0,
						'userstatus'=>1,
						'id_perusahaan'=> $id_perusahaan);

		return $this->db->insert('t_user',$input);
	}

	function insertcandidate($nama,$telepon,$email){
		$input  = array('nama_lengkap'=>$nama,
						'hp'=>$telepon,
						'email'=>$email);
		return $this->db->insert('t_candidate_employee',$input);
	}

	function get_id_candidate($email,$telepon){
		$sql = "select id_candidate from t_candidate_employee where email= ? and hp = ?";
		$query = $this->db->query($sql,array($email,$telepon));
		return $query->result_array();

	}

	function cekdata($id_candidate){
		$this->db->select('resume');
		return $this->db->get_where('t_candidate_employee',array('id_candidate' => $id_candidate))->result_array();
	}

	// get job id 
	function get_data_job($id){
		$this->db->where('id',$id);
		return $this->db->get('groups')->row()->job_id;
	}
}
