const flashData = $('.flash-message').data('flashdata');
const flashStatus = $('.flash-status').data('flashstatus');

alert(flashStatus);
if(flashStatus=='Added'){
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: ''+flashData+'',
      })
} else if(flashStatus=='Error'){
    Swal.fire({
        icon: 'error',
        title: 'Tidak Berhasil',
        text: ''+flashData+'',
      })
} else if(flashStatus=='Edited'){
  Swal.fire({
      icon: 'info',
      title: 'Berhasil',
      text: ''+flashData+'',
    })
}