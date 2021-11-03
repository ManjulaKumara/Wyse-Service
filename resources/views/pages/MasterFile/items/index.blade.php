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
<div class="modal fade" id="price_change" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2>Update Item Price</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <!--begin::Form-->
                {{-- <form id="kt_modal_new_card_form" class="form" action="#"> --}}
                    <!--begin::Input group-->
                    <div class="d-flex flex-column mb-7 fv-row">
                        <!--begin::Label-->
                        <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                            <span class="required">Item Name</span>
                        </label>
                        <!--end::Label-->
                        <input type="text" class="form-control" readonly placeholder="" name="item_name" id="item_name" />
                        <input type="hidden" name="item" id="item">
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="d-flex flex-column mb-7 fv-row">
                        <!--begin::Label-->
                        <label class="required fs-6 fw-bold form-label mb-2">Current Selling Price</label>
                        <!--end::Label-->
                        <!--begin::Input wrapper-->
                        <div class="position-relative">
                            <!--begin::Input-->
                            <input type="text" readonly class="form-control" name="current_price" id="current_price" />
                            <!--end::Input-->

                        </div>
                        <!--end::Input wrapper-->
                    </div>
                    <div class="d-flex flex-column mb-7 fv-row">
                        <!--begin::Label-->
                        <label class="required fs-6 fw-bold form-label mb-2">Current Cost Price</label>
                        <!--end::Label-->
                        <!--begin::Input wrapper-->
                        <div class="position-relative">
                            <!--begin::Input-->
                            <input type="text" readonly class="form-control" name="current_cost" id="current_cost" />
                            <!--end::Input-->

                        </div>
                        <!--end::Input wrapper-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-10">
                        <!--begin::Col-->
                        <div class="col-md-6 fv-row">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-bold form-label mb-2">New Selling Price</label>
                            <!--end::Label-->
                            <!--begin::Row-->
                            <div class="row fv-row">
                                <!--begin::Col-->
                                <input type="text" required name="new_price" id="new_price" class="form-control">
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="button" data-bs-dismiss="modal" id="kt_modal_new_card_cancel" class="btn btn-light me-3">Discard</button>
                        <button type="submit" id="kt_modal_new_card_submit" class="btn btn-primary" >
                            <span class="indicator-label">Submit</span>
                        </button>
                    </div>
                    <!--end::Actions-->
                {{-- </form> --}}
                <!--end::Form-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
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
$(document).on('click','.update-price',function(){
    let id=$(this).data('id');
    $('#price_change').modal('show');
});
</script>
@endsection
