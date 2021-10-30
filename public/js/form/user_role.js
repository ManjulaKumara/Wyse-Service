$(document).ready(function () {
    $('#table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
            "url": APP_URL+'user-role/get-all',
            "dataType": "json",
            "type": "get",
        },
        "columns": [
            { "data": "id" },
            { "data": "role_code" },
            { "data": "role_name" },
            { "data": "is_active" },
            { "data": "action" }
        ]
    });
});
