$( document ).ready(function() {
    var tree = $('.table-tree');

    tree.treetable({
        expandable: true,
        onNodeCollapse: function () {
            var node = this;
            tree.treetable("unloadBranch", node);
        },
        onNodeExpand: function () {
            var node = this;

            $.ajax({
                async: false,
                url: Routing.generate('_mssimi_menu_load', {"id": node.id})
            }).done(function (html) {
                var rows = $(html).filter("tr");

                tree.treetable("loadBranch", node, rows);
            });
        }
    });
});