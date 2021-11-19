$(function () {
    $('#table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
            "url": APP_URL+'/material-issues/get-all',
            "dataType": "json",
            "type": "get",
        },
        "columns": [
            { "data": "issue_no" },
            { "data": "item" },
            { "data": "quantity" },
            { "data": "date" },
        ]
    });
});
