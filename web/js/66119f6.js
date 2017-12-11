$(function () {

    var tabRecipes = $('#recipe-index');
    var modalEditRecipe = $('#modalEditRecipe');
    var modalShowRecipe = $('#modalShowRecipe');

    $('#saveRecipe').click(function () {
        $("form[name='appbundle_recipe']").submit();
    });
    getColumnIndexByName = function (grid, columnName) {
        var cm = grid.jqGrid('getGridParam', 'colModel');
        for (var i = 0, l = cm.length; i < l; i++) {
            if (cm[i].name === columnName) {
                return i; // return the index
            }
        }
        return -1;
    };
    edit = function () {
        rowid = tabRecipes.getGridParam('selrow');
        if (rowid) {
            editRecipe(rowid);
        }
        tabRecipes.trigger("reloadGrid");
    };
    show = function () {
        rowid = tabRecipes.getGridParam('selrow');
        if (rowid) {
            viewRecipe(rowid);
        }
    };
    del = function () {
        rowid = tabRecipes.getGridParam('selrow');
        if (rowid) {
            delRecipe(rowid);
        }
        tabRecipes.trigger("reloadGrid");
    };
    tabRecipes.jqGrid({

        url: '../api',
        datatype: "json",
        styleUI: 'Bootstrap',
        colModel: [
            {label: 'Id', name: 'id', key: true, width: 75, editable: false},
            {label: 'Title', name: 'title', width: 150, editable: false},
            {label: 'Ingredients', name: 'ingredients', width: 150, editable: false},
            {label: 'Directions', name: 'directions', width: 150, editable: false},
            {name: 'edit', width: 35, sortable: false, search: false,
                formatter: function () {
                    return "<button type='button' class='btn btn-default btn-xs' aria-label='Edit' onclick=\"edit()\"><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></button>"
                }
            },
            {name: 'show', width: 35, sortable: false, search: false,
                formatter: function () {
                    return "<button type='button' class='btn btn-default btn-xs' aria-label='Show' onclick=\"show()\"><span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span></button>"
                }},
            {name: 'del', width: 35, sortable: false, search: false,
                formatter: function () {
                    return "<button type='button' class='btn btn-default btn-xs' aria-label='Delete' onclick=\"del()\"><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></button>"
                }}
        ],
        viewrecords: true,
        height: 250,
        rowNum: 20,
        pager: "#jqGridPager"

    });
    tabRecipes.jqGrid('navGrid', '#jqGridPager',
            {
                edit: false,
                add: true,
                addfunc: function (id) {
                    newRecipe(id);
                },
                del: false,
                search: false,
                view: false,
                refresh: false,
            },
            {"drag": true, "resize": true, "closeOnEscape": true, "dataheight": 150},
            {"drag": true, "resize": true, "closeOnEscape": true, "dataheight": 150}
    );

    editRecipe = function (id) {
        $.ajax({
            url: '../api/edit/' + id,
            dataType: 'json',
            type: "GET",
            success: function (json) {
                if (json.err && json.err.trim().length) {
                    showMessage(__("Errore"), json.err);
                    return;
                }
                var fields = (Object.keys(json));
                for (var i in fields) {
                    var field = fields[i];
                    var $item = $('#appbundle_recipe_' + field);
                    if ($item.is('select')) {
                        id = json[field].id;
                        $('#appbundle_recipe_' + field + ' option').each(function () {
                            if ($(this).val() === id.toString()) {
                                $(this).prop('selected', true);
                            }
                        });
                    } else {
                        $item.val(json[field]);
                    }
                    $item.prop('disabled', false);
                }

                modalEditRecipe.modal({show: true});
            }
        });
    };

    newRecipe = function () {
        modalEditRecipe.modal({show: true});
    };
    viewRecipe = function (id) {
        $.ajax({
            url: '../api/edit/' + id,
            dataType: 'json',
            type: "GET",
            success: function (json) {
                if (json.err && json.err.trim().length) {
                    showMessage(__("Errore"), json.err);
                    return;
                }
                var descrizione = '';
                var fields = (Object.keys(json));
                for (var i in fields) {
                    var field = fields[i];

                    switch (field) {
                        case 'user':
                            descrizione += '<p><b>' + field + '</b>: ' + json[field].nickname + '</p>';
                            break;
                        case 'category':
                            descrizione += '<p><b>' + field + '</b>: ' + json[field].name + '</p>';
                            break;
                        default:
                            descrizione += '<p><b>' + field + '</b>: ' + json[field] + '</p>';
                    }
                }

                $('#showRecipeBody').html(descrizione);
                modalShowRecipe.modal({show: true});
            }
        });

    };
    delRecipe = function (id) {
        $.ajax({
            url: '../api/delete/' + id,
            dataType: 'json',
            type: "DELETE",
            success: function (json) {
                if (json.err && json.err.trim().length) {
                    showMessage(__("Errore"), json.err);
                    return;
                }
            }
        });
    };
});