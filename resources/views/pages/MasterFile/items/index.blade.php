@extends('layouts.wyse')
@section('optional_css')
<link href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="card">
    <!--begin::Card header-->
    <div class="card-header border-0 pt-6">
        <!--begin::Card title-->
        <div class="card-title">
            <!--begin::Search-->
            <h4>Items</h4>
        </div>
        <!--begin::Card title-->
        <!--begin::Card toolbar-->
        <div class="card-toolbar">
            <!--begin::Toolbar-->
            <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                <!--begin::Add new-->
                <a href="{{url('/items/create')}}"><button type="button" class="btn btn-primary" >Add Item</button></a>
                <!--end::Add new-->
            </div>
            <!--end::Toolbar-->
        </div>
        <!--end::Card toolbar-->
    </div>
    <!--end::Card header-->
    <!--begin::Card body-->
    <div class="card-body pt-0">
        <!--begin::Table-->
        <table class="table align-middle table-row-dashed fs-6 gy-5" id="my-table" data-order='[[ 1, "asc" ]]' data-page-length='25'>
            <!--begin::Table head-->
            <thead>
                <!--begin::Table row-->
                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                    <th class="min-w-40px">ID</th>
                    <th class="min-w-70px">Item Code</th>
                    <th class="min-w-125px">Item Name</th>
                    <th class="min-w-125px">Item Type</th>
                    <th class="min-w-125px">Status</th>
                    <th class="min-w-70px">Actions</th>
                </tr>
                <!--end::Table row-->
            </thead>
            <!--end::Table head-->
            <!--begin::Table body-->
            <tbody class=" text-gray-600 text-uppercase">

            </tbody>
            <!--end::Table body-->
        </table>
        <!--end::Table-->
    </div>
    <!--end::Card body-->
</div>

@endsection
@section('opyional_js')

<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
$(function() {
    $('#my-table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
                 "url": APP_URL+'/items/get-all',
                 "dataType": "json",
                 "type": "GET",
               },
        "columns": [
            { "data": "id" },
            { "data": "item_code" },
            { "data": "item_name" },
            { "data": "item_type" },
            { "data": "is_active" },
            { "data": "action" }
        ]
    });
});
</script>
@endsection
