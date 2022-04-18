<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//API
//per id 
$route['api/documentbyid'] = 'restapi/get_dokument_by_id';
//per user dan all
$route['api/document'] = 'restapi/get_dokument_all';
//per role dan status
$route['api/documentbyrole'] = 'restapi/dokumen_by_role';
//update document 
$route['api/updatedocument'] = 'restapi/dokumen_update_approve';
//jumlah data per dokument
$route['api/countdocument'] = 'restapi/get_count_per_dokument';


// Recruitment
$route['detailjob'] = 'calon_pegawai/detaillistjob';
$route['search'] = 'calon_pegawai/seacrh_job';
$route['recruitment'] = 'calon_pegawai';

// ION AUTH to HMVC modules
$route['auth/(.*)'] = 'auth/auth/$1';
$route['signin'] = 'auth/login';
$route['register'] = 'auth/registrasi';
$route['forgotpass'] = 'auth/forgot_password';
$route['signup'] = 'auth/reg_demo';


// personalia
$route['datapribadi'] = 'personalia/datapribadi';
$route['create'] = 'personalia/create';
$route['detail'] = 'personalia/detail_karyawan';
$route['detail/(:num)'] = 'personalia/detail_karyawan?id=$1';
$route['editemployee'] = 'personalia/editkaryawan'; 
$route['addaddress'] = 'personalia/addaddress'; 
$route['editaddress'] = 'personalia/editalamatkaryawan'; 
$route['editbank'] = 'personalia/edit_bank'; 
$route['addbank'] = 'personalia/tambah_bank'; 
$route['addeducattion'] = 'personalia/tambah_pendidikan'; 
$route['editeducation'] = 'personalia/edit_pendidikan';
$route['deleteeducation'] = 'personalia/hapuspendidikan';
$route['addfamily'] = 'personalia/tambah_keluarga';
$route['editfamily'] = 'personalia/edit_detail_keluarga';
$route['deletefamily'] = 'personalia/hapus_keluarga'; 
$route['uploadf'] = 'personalia/uploadfile'; 
$route['uploadi'] = 'personalia/uploadfileazajah'; 
$route['uploadl'] = 'personalia/uploadfilelain';
$route['sanksi'] = 'personalia/sanksi';
$route['addsanksi'] = 'personalia/addsanksi';
$route['editsanksi'] = 'personalia/editsanksi';
$route['deletesanksi'] = 'personalia/deletesanksi'; 
$route['mutasi'] = 'personalia/mutasipegawai'; 
$route['career'] = 'personalia/karir';
$route['detailcareer'] = 'personalia/karir_detail';
$route['changecareer'] = 'personalia/ubah_data'; 
$route['emptycareer'] = 'personalia/karir_null';
$route['mastercompt'] = 'manajemen_struktur_organisasi/kompetensi';
$route['addcompt'] = 'manajemen_struktur_organisasi/addkompetensi';
$route['editcompt'] = 'manajemen_struktur_organisasi/editkompetensi';
$route['addcompkpi'] = 'personalia/addkomponenkpi';
$route['editcomkpi'] = 'personalia/editmasterkpi';
$route['evaluation'] = 'personalia/penilaiankerja'; 
$route['process'] = 'personalia/prosespenilaian';
$route['reqpromotion'] = 'personalia/syaratkenaikanpangkat';
$route['considerations'] = 'personalia/usulankp'; 
$route['listconsiderations'] = 'personalia/daftarpertimbangan'; 
$route['uploadn'] = 'personalia/uploadnpwp';
// riwayat 
$route['histrank'] = 'personalia/historypangkat';
$route['addhistrank'] = 'personalia/addpangkat';
$route['edithistrank'] = 'personalia/editdatapangkat'; 
$route['delhistrank'] = 'personalia/deletedatapangkat'; 
$route['posihistory'] = 'personalia/historyjabatan';
$route['addposition'] = 'personalia/addjabatan'; 
$route['editposition'] = 'personalia/editdatajabatan';
$route['delposition'] = 'personalia/deletedatajabatan'; 

// absensi
$route['absen'] = 'absensi/absen'; 

//sakit dan ijin
$route['permit'] = 'sakit/pengajuanizin'; 
$route['addpermit'] = 'sakit/tambahizin';
$route['editpermit'] = 'sakit/edit_izin';
$route['sick'] = 'sakit/pengajuansakit';
$route['addsick'] = 'sakit/tambahpengajuansakit';
$route['delpermit'] = 'sakit/hapus_izin';
$route['editsick'] = 'sakit/edit_sakit';
$route['detailsick'] = 'sakit/detail_sakit';
$route['delsick'] = 'sakit/hapus_sakit'; 
