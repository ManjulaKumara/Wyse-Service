$(function () {
    $('#table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
            "url": APP_URL+'/item-damages/get-all',
            "dataType": "json",
            "type": "get",
        },
        "columns": [
            { "data": "item" },
            { "data": "qty" },
            { "data": "created_at" },
        ]
    });
});
