$(document).ready(function () {
    $('#table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
            "url": APP_URL+'/grns/get_all',
            "dataType": "json",
            "type": "get",
        },
        "columns": [
            { "data": "grn_code" },
            { "data": "supplier" },
            { "data": "amount" },
            { "data": "paid_amount" },
            { "data": "return_amount" },
            { "data": "balance" },
            { "data": "action" }
        ]
    });
});
