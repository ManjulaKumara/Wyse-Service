$(function () {
    $('#table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
            "url": APP_URL+'/supplier-cheque/get-all',
            "dataType": "json",
            "type": "get",
        },
        "columns": [
            { "data": "voucher_id" },
            { "data": "supplier" },
            { "data": "cheque_no" },
            { "data": "account" },
            { "data": "bank" },
            { "data": "cheque_date" },
            { "data": "amount" },
        ]
    });
});
