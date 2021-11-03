$(function () {
    $('#my-table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
            "url": APP_URL+'/items/get-all',
            "dataType": "json",
            "type": "get",
        },
        "columns": [
            { "data": "id" },
            { "data": "item_code" },
            { "data": "item_name" },
            { "data": "item_type" },
            { "data": "is_active" },
            { "data": "action" }
        ]
    });
});
