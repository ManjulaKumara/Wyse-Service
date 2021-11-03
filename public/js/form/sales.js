$(document).ready(function () {
    $('#table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
            "url": APP_URL+'/sales/get-all',
            "dataType": "json",
            "type": "get",
        },
        "columns": [
            { "data": "invoice_number" },
            { "data": "customer" },
            { "data": "vehicle_number" },
            { "data": "net_amount" },
            { "data": "paid_amount" },
            { "data": "balance" },
            { "data": "action" }
        ]
    });
});
