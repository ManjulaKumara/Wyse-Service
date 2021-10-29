@extends('layouts.wyse')
@section('optional_css')
<link href="{{url('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
<form>
<div class="d-flex flex-column flex-lg-row">
    <!--begin::Content-->
    <div class="flex-lg-row-fluid mb-10 mb-lg-0 me-lg-7 me-xl-10">
        <div class="card">
            <!--begin::Card body-->
            <div class="card-body p-12">
                <div class="row">
                    <div class="col-md-6">
                        <h3>Voucher No : SUP-V-00000001</h3>
                    </div>
                    <div class="col-md-6">
                        <h3 style="text-align: right">Voucher Date : 30/10/2021</h3>
                    </div>
                </div>

                <div class="separator separator-dashed my-10"></div>
                <!--begin::Form-->
                {{-- <form action="" id="kt_invoice_form"> --}}
                    <div class="mb-0">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-5">
                                    <div class="col-md-6">
                                        <label for="customer" class="required form-label">Supplier</label>
                                        <select class="form-select" name="customer" id="customer" data-control="select2" data-placeholder="Select an option">
                                            <option></option>
                                            <option value="1">Option 1</option>
                                            <option value="2">Option 2</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="email" class="required form-label">E-mail</label>
                                        <input type="text" class="form-control" name="email" id="email"/>
                                    </div>
                                    <!--begin::Input group-->

                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="col-md-3">
                                        <label for="telephone" class="required form-label">Telephone</label>
                                        <input type="text" class="form-control" name="telephone" id="telephone"/>
                                    </div>


                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="address" class="required form-label">Address</label>
                                        <input type="text" class="form-control" name="address" id="address"/>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="email" class="required form-label">Credit Limit</label>
                                        <input type="text" class="form-control" name="email" id="email"/>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="vehicle_no" class="required form-label">Current Balance</label>
                                        <input type="text" class="form-control" name="vehicle_no" id="vehicle_no"/>
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--end::Top-->
                                <!--begin::Separator-->
                                <div class="separator separator-dashed my-10"></div>
                                <div class="table-responsive mb-10">
                                    <!--begin::Table-->
                                    <table class="table g-5 gs-0 mb-0 fw-bolder text-gray-700" data-kt-element="items">
                                        <!--begin::Table head-->
                                        <thead>
                                            <tr class="border-bottom fs-7 fw-bolder text-gray-700 text-uppercase">
                                                <th class="min-w-175px w-350px">GRN No</th>
                                                <th class="min-w-175px w-175px">Total Amount</th>
                                                <th class="min-w-175px w-175px">Paid Amount</th>
                                                <th class="min-w-175px w-175px">Balance after</th>
                                                <th class="min-w-75px w-75px text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody>
                                            <tr class="border-bottom border-bottom-dashed" data-kt-element="item">
                                                <td class="pe-7">
                                                    <p>GRN-000000001</p>
                                                </td>

                                                <td>
                                                    <input type="text" class="form-control form-control-solid text-end" name="price[]" placeholder="0.00" value="0.00" data-kt-element="price" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-solid text-end" name="price[]" placeholder="0.00" value="0.00" data-kt-element="price" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-solid text-end" name="price[]" placeholder="0.00" value="0.00" data-kt-element="price" />
                                                </td>
                                                <td class="pt-5 text-end">
                                                    <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-kt-element="remove-item">
                                                        <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                                        <span class="svg-icon svg-icon-3">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black" />
                                                                <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black" />
                                                                <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black" />
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <div class="mb-0">
                                        <label class="form-label fs-6 fw-bolder text-gray-700">Notes</label>
                                        <textarea name="notes" class="form-control form-control-solid" rows="3" placeholder="Thanks for your business"></textarea>
                                    </div>
                                </div>
                                <!--end::Table-->
                            </div>
                        </div>
                    </div>
                    <!--end::Wrapper-->
                {{-- </form>
                <!--end::Form--> --}}
            </div>
            <!--end::Card body-->
        </div>
    </div>
    <div class="flex-lg-auto min-w-lg-300px">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card body-->
            <div class="card-body p-10">
                <!--begin::Input group-->
                <div class="row mb-3">
                    <label for="inv_no" class="required form-label">Total:</label>
                    <input type="text" class="form-control" name="inv_no" id="inv_no"/>
                </div>
                <div class="row mb-3">
                    <label for="inv_no" class="required form-label">Pay Method:</label>
                    <input type="text" class="form-control" name="inv_no" id="inv_no"/>
                </div>
                <!--end::Input group-->
                <!--begin::Separator-->
                <div class="separator separator-dashed mb-8"></div>
                <!--end::Separator-->
                <!--begin::Input group-->
                <div class="mb-0">
                    <!--begin::Row-->
                    <div class="row mb-5">
                        <!--begin::Col-->
                        <div class="col">
                            <a href="#" class="btn btn-light btn-active-light-primary w-100">Preview</a>
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col">
                            <a href="#" class="btn btn-light btn-active-light-primary w-100">Download</a>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->
                    <button type="submit" href="#" class="btn btn-primary w-100" id="kt_invoice_submit_button">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen016.svg-->
                    <span class="svg-icon svg-icon-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M15.43 8.56949L10.744 15.1395C10.6422 15.282 10.5804 15.4492 10.5651 15.6236C10.5498 15.7981 10.5815 15.9734 10.657 16.1315L13.194 21.4425C13.2737 21.6097 13.3991 21.751 13.5557 21.8499C13.7123 21.9488 13.8938 22.0014 14.079 22.0015H14.117C14.3087 21.9941 14.4941 21.9307 14.6502 21.8191C14.8062 21.7075 14.9261 21.5526 14.995 21.3735L21.933 3.33649C22.0011 3.15918 22.0164 2.96594 21.977 2.78013C21.9376 2.59432 21.8452 2.4239 21.711 2.28949L15.43 8.56949Z" fill="black" />
                            <path opacity="0.3" d="M20.664 2.06648L2.62602 9.00148C2.44768 9.07085 2.29348 9.19082 2.1824 9.34663C2.07131 9.50244 2.00818 9.68731 2.00074 9.87853C1.99331 10.0697 2.04189 10.259 2.14054 10.4229C2.23919 10.5869 2.38359 10.7185 2.55601 10.8015L7.86601 13.3365C8.02383 13.4126 8.19925 13.4448 8.37382 13.4297C8.54839 13.4145 8.71565 13.3526 8.85801 13.2505L15.43 8.56548L21.711 2.28448C21.5762 2.15096 21.4055 2.05932 21.2198 2.02064C21.034 1.98196 20.8409 1.99788 20.664 2.06648Z" fill="black" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->Send Invoice</button>
                </div>
                <!--end::Actions-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
</div>
</form>
@endsection
@section('opyional_js')
<script src="{{url('assets/plugins/global/plugins.bundle.js')}}"></script>
<script>
     $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
</script>
@endsection
