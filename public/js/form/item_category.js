$(document).ready(function () {
    $('#table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
            "url": APP_URL+'/item-category/get-all',
            "dataType": "json",
            "type": "get",
        },
        "columns": [
            { "data": "id" },
            { "data": "category_code" },
            { "data": "category_name" },
            { "data": "is_active" },
            { "data": "action" }
        ]
    });
});
