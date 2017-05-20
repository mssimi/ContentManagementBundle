$( document ).ready(function() {
    $('[data-toggle=confirmation]').confirmation({
        rootSelector: '[data-toggle=confirmation]',
    });

    $( document ).ready(function() {
        $('form').on('change', '.vich-image input[type="file"]', handleImage);
    });
});

function handleImage(e) {
    var reader = new FileReader();
    reader.onload = function (event) {
        $(e.target).parent('.vich-image').find('img').attr('src',event.target.result);
    }
    reader.readAsDataURL(e.target.files[0]);
}