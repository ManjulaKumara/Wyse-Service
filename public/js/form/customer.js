$(document).ready(function () {
    $('#table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
            "url": APP_URL+'/customers/get-all',
            "dataType": "json",
            "type": "get",
        },
        "columns": [
            { "data": "id" },
            { "data": "customer_name" },
            { "data": "email" },
            { "data": "telephone" },
            { "data": "action" }
        ]
    });
});
