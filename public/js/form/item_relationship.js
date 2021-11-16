$(function () {
    $('#table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
            "url": APP_URL+'/item-relationship/get-all',
            "dataType": "json",
            "type": "get",
        },
        "columns": [
            { "data": "parent_item" },
            { "data": "child_item" },
            { "data": "units_per_parent" },
            { "data": "action" },
        ]
    });
});
