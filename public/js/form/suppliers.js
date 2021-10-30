$(document).ready(function () {
    $('#table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
            "url": APP_URL+'suppliers/get-all',
            "dataType": "json",
            "type": "get",
        },
        "columns": [
            { "data": "id" },
            { "data": "supplier_name" },
            { "data": "email" },
            { "data": "telephone" },
            { "data": "action" }
        ]
    });
});
