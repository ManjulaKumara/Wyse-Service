@extends('layouts.wyse')
@section('optional_css')
<link href="{{url('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
<form id="supplier-voucher-form" action="{{url('/supplier-vouchers/store')}}" method="POST">
    @csrf
<div class="d-flex flex-column flex-lg-row">
    <!--begin::Content-->
    <div class="flex-lg-row-fluid mb-10 mb-lg-0 me-lg-7 me-xl-10">
        <div class="card">
            <!--begin::Card body-->
            <div class="card-body p-12">
                <div class="row">
                    <div class="col-md-6">
                        <h3>Voucher No : {{$voucher_number}}</h3>
                    </div>
                    <div class="col-md-6">
                        <h3 style="text-align: right">Voucher Date : {{$today}}</h3>
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
                                        <label for="supplier" class="required form-label">Supplier</label>
                                        <select required class="form-select" name="supplier" id="supplier" data-control="select2" data-placeholder="Select an option">
                                            <option value="">Please select a supplier</option>
                                            @foreach($suppliers as $supplier)
                                                <option data-current="{{$supplier->current_balance}}" data-credit="{{$supplier->credit_limit}}" data-address="{{$supplier->address}}" data-tel="{{$supplier->telephone}}" data-email="{{$supplier->email}}" value="{{$supplier->id}}">{{$supplier->supplier_name}}</option>
                                            @endforeach
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
                                        <label for="credit_limit" class="required form-label">Credit Limit</label>
                                        <input type="text" class="form-control" name="credit_limit" id="credit_limit"/>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="current_balance" class="required form-label">Current Balance</label>
                                        <input type="text" class="form-control" name="current_balance" id="current_balance"/>
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--end::Top-->
                                <!--begin::Separator-->
                                <div class="separator separator-dashed my-10"></div>

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
                    <label for="total" class="required form-label">Total:</label>
                    <input type="text" required class="form-control" name="total" id="total"/>
                </div>
                <div class="row mb-3">
                    <label for="inv_no" class="required form-label">Pay Method:</label>
                    <select name="pay_method" required id="pay_method" class="form-control">
                        <option value="">Please select a payment method</option>
                        <option value="cash">CASH</option>
                        <option value="cheque">CHEQUE</option>
                    </select>
                </div>
                <!--end::Input group-->
                <!--begin::Separator-->
                <div class="separator separator-dashed mb-8"></div>
                <!--end::Separator-->
                <!--begin::Input group-->
                <div class="mb-0">

                    <button type="submit" class="btn btn-primary w-100" id="btn-submit">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen016.svg-->
                    <span class="svg-icon svg-icon-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M15.43 8.56949L10.744 15.1395C10.6422 15.282 10.5804 15.4492 10.5651 15.6236C10.5498 15.7981 10.5815 15.9734 10.657 16.1315L13.194 21.4425C13.2737 21.6097 13.3991 21.751 13.5557 21.8499C13.7123 21.9488 13.8938 22.0014 14.079 22.0015H14.117C14.3087 21.9941 14.4941 21.9307 14.6502 21.8191C14.8062 21.7075 14.9261 21.5526 14.995 21.3735L21.933 3.33649C22.0011 3.15918 22.0164 2.96594 21.977 2.78013C21.9376 2.59432 21.8452 2.4239 21.711 2.28949L15.43 8.56949Z" fill="black" />
                            <path opacity="0.3" d="M20.664 2.06648L2.62602 9.00148C2.44768 9.07085 2.29348 9.19082 2.1824 9.34663C2.07131 9.50244 2.00818 9.68731 2.00074 9.87853C1.99331 10.0697 2.04189 10.259 2.14054 10.4229C2.23919 10.5869 2.38359 10.7185 2.55601 10.8015L7.86601 13.3365C8.02383 13.4126 8.19925 13.4448 8.37382 13.4297C8.54839 13.4145 8.71565 13.3526 8.85801 13.2505L15.43 8.56548L21.711 2.28448C21.5762 2.15096 21.4055 2.05932 21.2198 2.02064C21.034 1.98196 20.8409 1.99788 20.664 2.06648Z" fill="black" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->SAVE</button>
                </div>
                <!--end::Actions-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
</div>
<br>
<div class="row">
    <div class="md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive mb-10">
                    <!--begin::Table-->
                    <table class="table g-5 gs-0 mb-0 fw-bolder text-gray-700" id="tbl-grns">
                        <!--begin::Table head-->
                        <thead>
                            <tr class="border-bottom fs-7 fw-bolder text-gray-700 text-uppercase">
                                <th class="min-w-175px w-175px">GRN No</th>
                                <th class="min-w-175px w-175px">Total Amount</th>
                                <th class="min-w-175px w-175px">Paid Amount</th>
                                <th class="min-w-175px w-175px">Returned Amount</th>
                                <th class="min-w-175px w-175px">Balance</th>
                                <th class="min-w-175px w-175px">Pay Amount</th>
                            </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody>

                        </tbody>
                        <!--end::Table body-->
                    </table>
                    <div class="mb-0">
                        <label class="form-label fs-6 fw-bolder text-gray-700">Notes</label>
                        <textarea name="notes" class="form-control form-control-solid" rows="3" placeholder="Thanks for your business"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="cheque_modal" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2>Supplier Cheque Payment</h2>
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
                            <span class="required">Bank Name</span>
                        </label>
                        <!--end::Label-->
                        <input type="text" class="form-control" placeholder="" name="bank_name" />
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="d-flex flex-column mb-7 fv-row">
                        <!--begin::Label-->
                        <label class="required fs-6 fw-bold form-label mb-2">Account Number</label>
                        <!--end::Label-->
                        <!--begin::Input wrapper-->
                        <div class="position-relative">
                            <!--begin::Input-->
                            <input type="text" class="form-control" name="account_no" />
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
                            <label class="required fs-6 fw-bold form-label mb-2">Cheque Date</label>
                            <!--end::Label-->
                            <!--begin::Row-->
                            <div class="row fv-row">
                                <!--begin::Col-->
                                <input type="date" name="cheque_date" id="cheque_date" class="form-control">
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-md-6 fv-row">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                <span class="required">Cheque Number</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input wrapper-->
                            <div class="position-relative">
                                <!--begin::Input-->
                                <input type="text" class="form-control" placeholder="" name="cheque_number" />
                                <!--end::Input-->
                            </div>
                            <!--end::Input wrapper-->
                        </div>
                        <!--end::Col-->
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
</form>
@endsection
@section('opyional_js')
<script src="{{url('assets/plugins/global/plugins.bundle.js')}}"></script>
<script>
    var count=0;
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
    $('#supplier').change(function(){
        if($('#supplier').val()!="" && $('#supplier').val()!=null){
            let email=$('#supplier').find(":selected").data('email');
            let telephone=$('#supplier').find(":selected").data('tel');
            let address=$('#supplier').find(":selected").data('address');
            let credit_limit=$('#supplier').find(":selected").data('credit');
            let current_balance=$('#supplier').find(":selected").data('current');
            $('#email').val(email);
            $('#telephone').val(telephone);
            $('#address').val(address);
            $('#credit_limit').val(credit_limit);
            $('#current_balance').val(current_balance);

            let _url=APP_URL+'/ajax/unpaid-grns/'+$('#supplier').val();
            $.getJSON( _url, function ( data ) {
                $.each(data, function ( key, entry ) {
                    let markup=`
                    <tr class="border-bottom border-bottom-dashed item-row" data-kt-element="item">
                        <td class="pe-7">
                            <p>${entry.grn_code}</p>
                            <input type="hidden" name="details[${count}][grn]" value="${$entry.id}" />
                        </td>
                        <td>
                            <input type="text" readonly class="form-control form-control-solid text-end" name="details[${count}][total]" placeholder="0.00" value="${entry.amount}" />
                        </td>
                        <td>
                            <input type="text" readonly class="form-control form-control-solid text-end" name="details[${count}][paid]" placeholder="0.00" value="${entry.paid_amount}" />
                        </td>
                        <td>
                            <input type="text" readonly class="form-control form-control-solid text-end" name="details[${count}][returned]" placeholder="0.00" value="${entry.return_amount}" />
                        </td>
                        <td>
                            <input type="text" readonly class="form-control form-control-solid text-end" name="details[${count}][balance]" placeholder="0.00" value="${entry.balance}" />
                        </td>
                        <td class="amount">
                            <input type="text" class="form-control form-control-solid text-end total_amount" name="details[${count}][pay_amount]" placeholder="0.00" value=""  />
                        </td>
                    </tr>
                    `;
                    $("#tbl-grns tbody").append(markup);
                    count++;
                });
            });
        }
    });
    function calTotal(){
        let table ='#tbl-grns tbody';
        let total=0;
        $(table+" .item-row").each(function() {
            total +=  $(this).find('td.amount').find('input.total_amount').val()*1;
        });
        $('#total').val(total);
    }
    $(document).on('keyup input.total-amount', function(){
        calTotal();
    });
    $('#pay_method').change(function(){
        if($('#pay_method').val()=='cheque'){
            if($('#supplier').val()=="" || $('#supplier').val()==null){
                alert('Please Select a supplier if you want to save voucher.You may want to create a supplier if the supplier is not available in the system.');
                $('#supplier').focus();
            }else{
                $('#cheque_modal').modal('show');
            }
        }
    });
</script>
@endsection
