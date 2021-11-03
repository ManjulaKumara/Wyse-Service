$(document).ready(function () {
    $('#table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
            "url": APP_URL+'/customer-receipts/get-all',
            "dataType": "json",
            "type": "get",
        },
        "columns": [
            { "data": "recept_no" },
            { "data": "customer" },
            { "data": "recept_amount" },
            { "data": "payment_type" },
            { "data": "action" }
        ]
    });
});
