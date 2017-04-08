$( document ).ready(function() {
    $('#menu_link').devbridgeAutocomplete({
        serviceUrl: Routing.generate('mssimi_menu_ajax'),
        type: 'POST'
    });

    toggleAutocomplete();
    $('#menu_linkType').change(function () {
        toggleAutocomplete();
    });
});

function toggleAutocomplete(){
    if ($('#menu_linkType').val() == 'path') {
        $('#menu_link').devbridgeAutocomplete().enable();
    } else {
        $('#menu_link').devbridgeAutocomplete().disable();
    }
}