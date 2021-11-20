@extends('layouts.wyse')
@section('optional_css')
<link href="{{url('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
<form id="form-invoice" action="{{url('/sales/store')}}" method="POST">
    @csrf
<div class="d-flex flex-column flex-lg-row">
    <!--begin::Content-->
    <div class="flex-lg-row-fluid mb-10 mb-lg-0 me-lg-7 me-xl-10">
        <div class="card">
            <!--begin::Card body-->
            <div class="card-body p-12">
                <div class="row">
                    <div class="col-md-6">
                        <h3>Sales Invoice : {{$invoice_number}}</h3>
                    </div>
                    <div class="col-md-6">
                        <h3 style="text-align: right">Invoice Date : {{$today}}</h3>
                    </div>
                </div>

                <div class="separator separator-dashed my-10"></div>
                <!--begin::Form-->
                {{-- <form action="" id="kt_invoice_form"> --}}
                    <div class="mb-0">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="vehicle_no" class="required form-label">Vehicle No:</label>
                                        <input type="text" class="form-control" required name="vehicle_no" id="vehicle_no" autofocus/>
                                    </div>
                                    <!--begin::Input group-->
                                    <div class="col-md-6">
                                        <label for="customer" class="required form-label">Customer</label>
                                        <select class="form-select" name="customer" id="customer" data-control="select2" data-placeholder="Select an option">
                                            <option value="">Please select Customer</option>
                                            @foreach($customers as $customer)
                                                <option value="{{$customer->id}}">{{$customer->customer_name}}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="col-md-6">
                                        <label for="inv_type" class="required form-label">Invoice Type:</label>
                                        <select required class="form-control" name="inv_type" id="inv_type">
                                            <option value="">Please select invoice type</option>
                                            <option value="1">Items and Services(Private Vehicles)</option>
                                            <option value="2">Items Only(Government Vehicles)</option>
                                            <option value="3">Services/Repairs Only(Government Vehicles)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="vehicle_type" class="required form-label">Vehicle Type:</label>
                                        <input type="text" class="form-control" required name="vehicle_type" id="vehicle_type" autofocus/>
                                    </div>
                                    <!--end::Input group-->

                                </div>
                                <!--end::Top-->
                                <!--begin::Separator-->
                                <div class="separator separator-dashed my-10"></div>
                                <div class="row gx-10 mb-5">
                                    <!--begin::Col-->
                                    <div class="col-lg-9">
                                        <label class="form-label fs-6 fw-bolder text-gray-700 mb-3">Item</label>
                                        <!--begin::Input group-->
                                        <div class="mb-5">
                                            <select class="form-select" name="item" id="item" data-control="select2" data-placeholder="Select an option">
                                                <option value=""></option>

                                            </select>
                                        </div>

                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col-lg-3">
                                        <label class="form-label fs-6 fw-bolder mb-3">Quantity</label>
                                        <!--begin::Input group-->
                                        <div class="mb-5">
                                            <input type="text" id="quantity" name="qty" class="form-control form-control-solid" />
                                        </div>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <div class="row gx-10 mb-5">
                                    <div class="col-lg-3">
                                        <label for="unit_price" class="required form-label">Unit Price(LKR):</label>
                                        <input type="text" class="form-control" disabled name="unit_price" id="unit_price"/>
                                    </div>
                                    <div class="col-lg-2">
                                        <label for="discount" class="required form-label">Discount(LKR):</label>
                                        <input type="text" disabled class="form-control"  name="discount" id="discount"/>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="amount" class="required form-label">Total(LKR):</label>
                                        <input type="text" class="form-control" disabled name="amount" id="amount"/>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="amount" class="required form-label">Item Type?:</label>
                                        <select name="is_return" class="required form-control" id="is_return">
                                            <option value="display-stock">Display and Stock</option>
                                            <option value="hide-stock">Hide and Stock</option>
                                            <option value="display">Display Only</option>
                                            <option value="yes">Return Item</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-1">
                                        <button type="button" style="margin-top:25px;" id="btn-add" class="btn btn-success">ADD</button>
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
                    <label for="total" class="required form-label">Total:</label>
                    <input type="text" readonly required class="form-control" name="total" id="total"/>
                </div>
                <div class="row mb-3">
                    <label for="bill_discount" class="required form-label">Bill Discount:</label>
                    <input type="text" required  class="form-control" name="bill_discount" id="bill_discount"/>
                </div>
                <div class="row mb-3">
                    <label for="final_total" class="required form-label">Net Total:</label>
                    <input type="text" readonly required class="form-control" name="final_total" id="final_total"/>
                </div>
                <div class="row mb-3">
                    <label for="pay_method" class="required form-label">Pay Method:</label>
                    <select name="pay_method" required id="pay_method" class="form-control">
                        <option value="">Select Payment Method</option>
                        <option value="cash">CASH</option>
                        <option value="cheque">CHEQUE</option>
                        <option value="credit">CREDIT</option>
                    </select>
                </div>
                <div class="row mb-3">
                    <label for="pay_amount" class="required form-label">Pay Amount:</label>
                    <input type="text" class="form-control" name="pay_amount" id="pay_amount"/>
                </div>
                <div class="row mb-3">
                    <label for="balance_amount" class="required form-label">Customer Balance:</label>
                    <input type="text" class="form-control" name="balance_amount" id="balance_amount"/>
                </div>
                <!--end::Input group-->
                <!--begin::Separator-->
                <div class="separator separator-dashed mb-8"></div>
                <!--end::Separator-->
                <!--begin::Input group-->
                <div class="mb-0">
                    <button type="submit" href="#" class="btn btn-primary w-100" id="kt_invoice_submit_button" onsubmit="return validateOnSubmit()">
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
<div class="row" style="margin-top:20px;">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive mb-10">
                    <!--begin::Table-->
                    <table class="table g-5 gs-0 mb-0 fw-bolder text-gray-700" id="tbl-items">
                        <!--begin::Table head-->
                        <thead>
                            <tr class="border-bottom fs-7 fw-bolder text-gray-700 text-uppercase">
                                <th class="min-w-300px w-475px">Item</th>
                                <th class="min-w-150px w-150px">Unit Price</th>
                                <th class="min-w-150px w-150px">Discount</th>
                                <th class="min-w-100px w-100px">QTY</th>
                                <th class="min-w-100px w-150px text-end">Total</th>
                                <th class="min-w-75px w-75px text-end">Action</th>
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
                <h2>Customer Cheque Payment</h2>
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
                        <label class="required fs-6 fw-bold form-label mb-2">Branch Name</label>
                        <!--end::Label-->
                        <!--begin::Input wrapper-->
                        <div class="position-relative">
                            <!--begin::Input-->
                            <input type="text" class="form-control" name="branch_name" />
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
                        <button type="submit" id="kt_modal_new_card_submit" class="btn btn-primary" onsubmit="return validateOnSubmit()">
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
    var itemsInTable=[];
    var count=0;
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });

    $(function(){
        $('#tbl-items tbody').empty();

        $('#btnSubmit').prop('disabled',true);

        let dropdown = $('#item');
        dropdown.empty();
        dropdown.append('<option selected="selected" value="">Choose Value</option>');
        dropdown.select2();
        // Populate dropdown with list of provinces
        let _dop_url=APP_URL+'/ajax/items-n-services';
        $.getJSON( _dop_url, function ( data ) {
            $.each(data, function ( key, entry ) {
                dropdown.append($('<option></option>').attr('value', entry.id).attr('data-stock',entry.stock_no).attr('data-uprice',entry.unit_price).attr('data-discount',entry.discount).attr('data-type',entry.type).attr('data-name',entry.name).text(entry.name+' || '+entry.category+' || '+entry.item_code+' || '+entry.barcode));
            })
        });
    });
    $('#inv_type').change(function(){
        if($('#inv_type').val()!="" && $('#inv_type').val()!=null){
            if($('#inv_type').val()=='1' || $('#inv_type').val()=='2'){
                if($('#vehicle_no').val()=="" || $('#vehicle_no').val()==null){
                    alert('Please provide the vehicle number..');
                    $('#vehicle_no').focus();
                }else{
                    $('#tbl-items tbody').empty();
                    let _url=APP_URL+'/ajax/stock-issues-by-vehicle/'+$('#vehicle_no').val();
                    $.getJSON( _url, function ( data ) {
                        $.each(data, function ( key, entry ) {
                            itemsInTable.push(entry.stock_no+" "+entry.id);
                            let markup=`
                                <tr class="border-bottom border-bottom-dashed item-row" id="tr${count}" data-item-id="${entry.id}" data-kt-element="item">
                                    <td class="pe-7">
                                        <p>${entry.name}</p>
                                        <input type="hidden" name="details[${count}][item]" value="${entry.id}" />
                                        <input type="hidden" name="details[${count}][stock_no]" value="${entry.stock_no}" />
                                        <input type="hidden" name="details[${count}][item_type]" value="item" />
                                        <input type="hidden" name="details[${count}][is_return]" value="display-stock" />
                                    </td>
                                    <td>
                                        <input type="text" class="form-control text-end" name="details[${count}][unit_price]" readonly placeholder="0.00" value="${entry.unit_price}" />
                                    </td>
                                    <td>
                                        <input type="text" class="form-control text-end" name="details[${count}][discount]" readonly placeholder="0.00" value="${entry.discount}" />
                                    </td>
                                    <td class="ps-0">
                                        <input class="form-control " type="number" min="1" name="details[${count}][qty]" readonly placeholder="1" value="${entry.quantity}"/>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control text-end amount" name="details[${count}][amount]" readonly placeholder="0.00" value="${entry.quantity*(entry.unit_price-entry.discount)}" />
                                    </td>
                                    <td class="pt-5 text-end">
                                        <button type="button" disabled class="btn btn-sm btn-icon btn-active-color-primary" data-kt-element="remove-item">
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
                            `;
                            $("#tbl-items tbody").append(markup);
                            count=count*1+1;
                            calInvoiceTotal();
                        })
                    });
                    let dropdown = $('#item');
                    dropdown.empty();
                    dropdown.append('<option selected="selected" value="">Choose Value</option>');
                    dropdown.select2();
                    // Populate dropdown with list of provinces
                    let _dop_url=APP_URL+'/ajax/items-n-services';
                    if($('#inv_type').val()=='1'){
                        _dop_url=APP_URL+'/ajax/items-n-services';
                    }else{
                        _dop_url=APP_URL+'/ajax/items';
                    }
                    $.getJSON( _dop_url, function ( data ) {
                        $.each(data, function ( key, entry ) {
                            dropdown.append($('<option></option>').attr('value', entry.id).attr('data-stock',entry.stock_no).attr('data-uprice',entry.unit_price).attr('data-discount',entry.discount).attr('data-type',entry.type).attr('data-name',entry.name).text(entry.name+' || '+entry.category+' || '+entry.item_code+' || '+entry.barcode));
                        })
                    });
                }
            }else{
                let dropdown = $('#item');
                    dropdown.empty();
                    dropdown.append('<option selected="selected" value="">Choose Value</option>');
                    dropdown.select2();
                    // Populate dropdown with list of provinces
                    let _dop_url=APP_URL+'/ajax/services';
                    $.getJSON( _dop_url, function ( data ) {
                        $.each(data, function ( key, entry ) {
                            console.log(entry);
                            dropdown.append($('<option></option>').attr('value', entry.id).attr('data-qih',entry.qih).attr('data-stock',entry.stock_no).attr('data-uprice',entry.unit_price).attr('data-discount',entry.discount).attr('data-type',entry.type).attr('data-name',entry.name).text(entry.name+' || '+entry.category+' || '+entry.barcode));
                        })
                    });
            }
        }
    });
    $('#item').change(function(){
        if($('#item').val()!="" && $('#item').val()!=null){
            let unit_price=$('#item').find(":selected").data('uprice');
            let discount=$('#item').find(":selected").data('discount');
            $('#unit_price').val(Number(unit_price).toFixed(2));
            $('#discount').val(Number(discount).toFixed(2));
            let type = $('#item').find(":selected").data('type');
            if(type=='service'){
                $('#quantity').val('1');
                $('#quantity').trigger('keyup');
                $('#btn-add').focus();
            }
            if(type=='material'){
                $('#quantity').val('1');
                $('#quantity').trigger('keyup');
                $('#unit_price').prop('disabled',false);
                $('#unit_price').focus();
            }else{
                $('#unit_price').prop('disabled',true);
            }
        }
    });
    $('#unit_price').keyup(function(){
        let total=$('#unit_price').val()*$('#quantity').val();
        $('#amount').val(Number(total).toFixed(2));
    });
    $('#quantity').keyup(function(){
        if($('#item').val()!="" && $('#item').val()!=null){
            let qih=$('#item').find(":selected").data('qih');
            if($('#quantity').val()!="" && $('#quantity').val()!=null){
                if($('#quantity').val()>qih){
                    alert('Maximum available quantity exceeded. Available only '+qih+'.');
                    $('#quantity').focus();
                }else{
                    let unit_price=$('#item').find(":selected").data('uprice');
                    let discount=$('#item').find(":selected").data('discount');
                    let total=(unit_price-discount)*$('#quantity').val();
                    $('#amount').val(Number(total).toFixed(2));
                }
            }
        }
    })
    $('#btn-add').click(function(){
        if($('#item').val()=="" || $('#item').val()==null){
            alert('Please select an Item or a Service');
            $('#item').focus();
        }else if($('#quantity').val()=="" || $('#quantity').val()==null){
            alert('Please provide item quantity..');
            $('#quantity').focus();
        }else{
            let unit_price=$('#unit_price').val();
            let discount=$('#item').find(":selected").data('discount');
            let stock_no=$('#item').find(":selected").data('stock');
            let item_id=$('#item').val();
            let item_name=$('#item').find(":selected").data('name');
            let item_type=$('#item').find(":selected").data('type');
            let quantity=$('#quantity').val();
            let is_returned=$('#is_return').val();

            if(itemsInTable.includes(stock_no+" "+item_id)){
                alert('Item Already Inserted');
            }else{
                itemsInTable.push(stock_no+" "+item_id);
                let background_color="background-color:yellow;"
                let markup=`
                    <tr style="${(is_returned=='hide-stock')?background_color:''}" class="border-bottom border-bottom-dashed item-row" id="tr${count}" data-item-id="${item_id}" data-stock-no="${stock_no}" data-kt-element="item">
                        <td class="pe-7">
                            <p>${item_name}</p>
                            <input type="hidden" name="details[${count}][item]" value="${item_id}" />
                            <input type="hidden" name="details[${count}][stock_no]" value="${stock_no}" />
                            <input type="hidden" name="details[${count}][item_type]" value="${item_type}" />
                            <input type="hidden" class="bill_type" name="details[${count}][is_return]" value="${is_returned}" />
                        </td>
                        <td>
                            <input type="text" class="form-control text-end" name="details[${count}][unit_price]" readonly placeholder="0.00" value="${Number(unit_price).toFixed(2)}" />
                        </td>
                        <td>
                            <input type="text" class="form-control text-end" name="details[${count}][discount]" readonly placeholder="0.00" value="${Number(discount).toFixed(2)}" />
                        </td>
                        <td class="ps-0">
                            <input class="form-control " type="number" min="1" name="details[${count}][qty]" readonly placeholder="1" value="${quantity}"/>
                        </td>
                        <td>
                            <input type="text" class="form-control text-end amount" name="details[${count}][amount]" readonly placeholder="0.00" value="${Number(quantity*(unit_price-discount)).toFixed(2)}" />
                        </td>
                        <td class="pt-5 text-end">
                            <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-kt-element="remove-item" onclick="deleteItem(${count})">
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
                `;
                $("#tbl-items tbody").append(markup);
                count=count*1+1;
                calInvoiceTotal();
                $('#item').val("");
                $('#item').trigger('change');
                $('#quantity').val("");
                $('#unit_price').val("");
                $('#discount').val("");
                $('#amount').val("");
                $('#item').focus();
            }

        }
    });
    function calInvoiceTotal(){
        total=0;
        $("#tbl-items .item-row").each(function(){
            let billing_type=$(this).find('.bill_type').val();
            if(billing_type!='hide-stock'){
                total=total+$(this).find('.amount').val()*1;
            }
        });
        $('#total').val(Number(total).toFixed(2));
    }
    $(document).on('keydown', function(event) {
       if (event.key == "Escape") {
           if($('#total').val()=="" || $('#total').val()==null){
               alert('Please Complete Invoice Before Saving it..');
           }else{
               $('#bill_discount').focus();
           }
       }
    });
    $('#bill_discount').keyup(function(){
        if($('#bill_discount').val()!="" && $('#bill_discount').val()!=null){
            let final_total=$('#total').val()-$('#bill_discount').val();
            $('#final_total').val(Number(final_total).toFixed(2));
        }
    });
    $('#pay_method').change(function(){
        if($('#pay_method').val()=='cash' || $('#pay_method').val()=='credit'){
            $('#pay_amount').focus();
        }else if($('#pay_method').val()=='cheque'){
            if($('#customer').val()=="" || $('#customer').val()==null){
                alert('Please Select a Customer if you want to save invoice as credit.You may want to create a customer if the customer is not available in the system.');
                $('#customer').focus();
            }else{
                $('#cheque_modal').modal('show');
            }

        }
    });
    $('#pay_amount').focusout(function(){
        if($('#pay_method').val()=='credit' || $('#pay_amount').val()<$('#final_total').val()){
            if($('#customer').val()=="" || $('#customer').val()==null){
                alert('Please Select a Customer if you want to save invoice as credit.You may want to create a customer if the customer is not available in the system.');
                $('#customer').focus();
            }
        }
        let customer_balance=$('#pay_amount').val()-$('#final_total').val();
        $('#balance_amount').val(Number(customer_balance).toFixed(2));
    });
    function deleteItem(index){
        let item_id=$('#tr'+index).data('item-id');
        let stock_number=$('#tr'+index).data('stock-no');
        $('#tr'+index).remove();
        let search=""+stock_number+" "+item_id;
        let i = itemsInTable.indexOf(search+"");
        console.log(i);
        if ( i >= 0 ) itemsInTable.splice( i , 1 );
        if(itemsInTable.length>0){
            $('#btnSubmit').prop('disabled',false);
        }else{
            $('#btnSubmit').prop('disabled',true);
        }
    }

    function validateOnSubmit(){
        if($('#inv_type').val()=="" || $('#inv_type').val()==null){
            alert('Please select a Invoice Type to continue');
            $('#inv_type').focus();
            return false;
        }else if($('#pay_method').val()=="" || $('#pay_method').val()==null){
            alert('Please select a payment method');
            $('#pay_method').focus();
            return false;
        }else if($('#pay_method').val()=='credit' || $('#pay_amount').val()<$('#final_total').val()){
            if($('#customer').val()=="" || $('#customer').val()==null){
                alert('Please Select a Customer if you want to save invoice as credit.You may want to create a customer if the customer is not available in the system.');
                $('#customer').focus();
                return false;
            }
        }else if(itemsInTable.length<=0){
            alert('Please select the items and services for the invoice');
            $('#item').focus();
            return false;
        }else{
            return true;
        }
    }
</script>
@endsection
