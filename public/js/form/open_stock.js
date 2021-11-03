$(document).ready(function () {
    $('#table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
            "url": APP_URL+'/open-stock/get-all',
            "dataType": "json",
            "type": "get",
        },
        "columns": [
            { "data": "id" },
            { "data": "item" },
            { "data": "purchase_qty" },
            { "data": "cost_price" },
            { "data": "sales_price" },
            { "data": "action" }
        ]
    });
});
