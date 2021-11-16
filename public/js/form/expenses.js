$(function () {
    $('#table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
            "url": APP_URL+'/expense/get-all',
            "dataType": "json",
            "type": "get",
        },
        "columns": [
            { "data": "expense_name" },
            { "data": "expense_amount" },
            { "data": "created_at" },
            { "data": "cashier" },
        ]
    });
});
