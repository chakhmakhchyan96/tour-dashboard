$('.j_return_back').click(function () {
    window.history.back();
});

$('div.alert').not('.alert-important').delay(3000).fadeOut(350);


$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

});
