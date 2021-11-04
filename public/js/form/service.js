$(document).ready(function () {
    $('#table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
            "url": APP_URL+'/services/get-all',
            "dataType": "json",
            "type": "get",
        },
        "columns": [
            { "data": "id" },
            { "data": "service_name" },
            { "data": "service_rate" },
            { "data": "discount_rate" },
            { "data": "action" }
        ]
    });
});
