$(function () {
    $('#table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
            "url": APP_URL+'/customer-cheque/get-all',
            "dataType": "json",
            "type": "get",
        },
        "columns": [
            { "data": "receipt_id" },
            { "data": "customer" },
            { "data": "cheque_number" },
            { "data": "bank_name" },
            { "data": "banked_date" },
            { "data": "cheque_amount" },
        ]
    });
});
