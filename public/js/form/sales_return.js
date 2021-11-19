$(document).ready(function () {
    $('#table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
            "url": APP_URL+'/sales-return/get-all',
            "dataType": "json",
            "type": "get",
        },
        "columns": [
            { "data": "return_number" },
            { "data": "invoice_no" },
            { "data": "return_amount" },
            { "data": "action" }
        ]
    });
});
