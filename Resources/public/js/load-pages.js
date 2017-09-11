$( document ).ready(function() {
    $('#menu_item_link').devbridgeAutocomplete({
        serviceUrl: Routing.generate('mssimi_menu_item_ajax'),
        type: 'POST'
    });

    toggleAutocomplete();
    $('#menu_item_linkType').change(function () {
        toggleAutocomplete();
    });
});

function toggleAutocomplete(){
    if ($('#menu_item_linkType').val() == 'page') {
        $('#menu_item_link').devbridgeAutocomplete().enable();
    } else {
        $('#menu_item_link').devbridgeAutocomplete().disable();
    }
}