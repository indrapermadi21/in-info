const flashmessage = $('.flash-message').data('flashdata');
const flashstatus = $('.flash-status').data('flashstatus');

if (flashstatus) {
    // Swal.fire('Date cannot empty', '', 'error');
    if (flashstatus == 'success') {
        Swal.fire({
            icon: 'success',
            title: 'Data',
            text: flashmessage,
        })
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Data',
            text: flashmessage,
        })
    }

}
