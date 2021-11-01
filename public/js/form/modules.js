$(document).ready(function () {
    $('#table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
            "url": APP_URL+'module/get-all',
            "dataType": "json",
            "type": "get",
        },
        "columns": [
            { "data": "id" },
            { "data": "md_code" },
            { "data": "md_name" },
            { "data": "is_active" },
            { "data": "action" }
        ]
    });
});
