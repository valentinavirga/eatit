$(function () {

    var tabRecipes = $('#recipe-index');
    var tabRecipesDetail = $('#recipe-detail');
    var modalRecipeDetail = $('#modalRecipe');
    var lastSel;
    var buttonNames = {};
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
        initFormRecipes(rowid);
    };
    tabRecipes.jqGrid({

        url: '../api',
        editurl: '../api/save',
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
                    return "<button type='button' class='btn btn-default btn-xs' aria-label='Show'><span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span></button>"
                }},
            {name: 'del', width: 35, sortable: false, search: false,
                formatter: function () {
                    return "<button type='button' class='btn btn-default btn-xs' aria-label='Delete'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></button>"
                }}
        ],
        viewrecords: true,
        height: 250,
        rowNum: 20,
        pager: "#jqGridPager",
        ondblClickRow: function (id) {
            if (id && id !== lastSel) {
                tabRecipes.restoreRow(lastSel);
                lastSel = id;
            }
            $('#recipe-index').jqGrid('editRow', id, {
                keys: true,
                beforeSaveRow: function (o, id) {
                    tabRecipes.saveRow(id, false);
                    return false;
                }
            });
        },
    });
    firstButtonColumnIndex = getColumnIndexByName(tabRecipes, 'edit');
    buttonNames[firstButtonColumnIndex] = 'Edit';
    buttonNames[firstButtonColumnIndex + 2] = 'Remove';
    buttonNames[firstButtonColumnIndex + 3] = 'Details';

    initFormRecipes = function (id) {
        modalRecipeDetail.modal({show: true});
        //tabRecipesDetail.jqGrid("GridUnload");
        tabRecipesDetail.jqGrid({

        url: '../api/edit/'+id,
        editurl: '../api/save',
        datatype: "json",
        styleUI: 'Bootstrap',
        colModel: [
            {label: 'Id', name: 'id', key: true, width: 75, editable: false},
            {label: 'Title', name: 'title', width: 150, editable: false},
            {label: 'Ingredients', name: 'ingredients', width: 150, editable: false},
            {label: 'Directions', name: 'directions', width: 150, editable: false},
            
        ],
        viewrecords: true,
        height: 250,
        rowNum: 20,
        pager: "#jqGridPager",
    });
    }

});