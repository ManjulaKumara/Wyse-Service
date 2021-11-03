$(document).ready(function () {
    $('#table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
            "url": APP_URL+'stock-issues/get-all',
            "dataType": "json",
            "type": "get",
        },
        "columns": [
            { "data": "vehicle_number" },
            { "data": "item" },
            { "data": "qty" },
            { "data": "is_invoiced" },
        ]
    });
});
