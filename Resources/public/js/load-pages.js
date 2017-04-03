$( document ).ready(function() {
    $('#menu_link').autocomplete({
        serviceUrl: Routing.generate('_mssimi_menu_ajax'),
        type: 'POST'
    });

    toggleAutocomplete();
    $('#menu_linkType').change(function () {
        toggleAutocomplete();
    });
});

function toggleAutocomplete(){
    if ($('#menu_linkType').val() == 'path') {
        $('#menu_link').autocomplete().enable();
    } else {
        $('#menu_link').autocomplete().disable();
    }
}