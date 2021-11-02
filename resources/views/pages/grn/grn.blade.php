@extends('layouts.wyse')
@section('optional_css')
<link href="{{url('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
<form id="frm-grn" action="{{url('/grns/store')}}" method="POST">
    @csrf
<div class="d-flex flex-column flex-lg-row">
    <!--begin::Content-->
    <div class="flex-lg-row-fluid mb-10 mb-lg-0 me-lg-7 me-xl-10">
        <div class="card">
            <!--begin::Card body-->
            <div class="card-body p-12">
                <div class="row">
                    <div class="col-md-6">
                        <h3>Goods Recieved Note : {{$grn_code}}</h3>
                    </div>
                    <div class="col-md-6">
                        <h3 style="text-align: right">GRN Date : {{$today}}</h3>
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
                                        <label for="supplier" class="required form-label">Supplier</label>
                                        <select class="form-select" name="supplier" required id="supplier" data-control="select2" data-placeholder="Select an option">
                                            <option value="">Please select a Supplier</option>
                                            @foreach($suppliers as $supplier)
                                                <option value="{{$supplier->id}}">{{$supplier->supplier_name}}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="receipt_no" class="required form-label">Receipt No:</label>
                                        <input type="text" class="form-control" required name="receipt_no" id="receipt_no" autofocus/>
                                    </div>
                                    <!--begin::Input group-->

                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="col-md-3">
                                        <label for="grn_date" class="required form-label">Date:</label>
                                        <input type="date" name="grn_date" id="grn_date" required class="form-control">
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
                                                <option value="">Please select an Item</option>
                                                @foreach($items as $item)
                                                <option data-name="{{$item->item_name}}" value="{{$item->id}}">{{$item->item_name}}  || {{$item->barcode}} || {{$item->item_code}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col-lg-3">
                                        <label class="form-label fs-6 fw-bolder text-gray-700 mb-3">Quantity</label>
                                        <!--begin::Input group-->
                                        <div class="mb-5">
                                            <input type="number" min="1" id="quantity" class="form-control" />
                                        </div>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <div class="row gx-10 mb-5">
                                    <div class="col-lg-3">
                                        <label for="label_price" class="required form-label">Label Price(LKR):</label>
                                        <input type="text" class="form-control" name="label_price" id="label_price"/>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="discount" class="required form-label">Discount(LKR):</label>
                                        <input type="text" class="form-control"  name="discount" id="discount"/>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="amount" class="required form-label">Total(LKR):</label>
                                        <input type="text" disabled class="form-control" readonly name="amount" id="amount"/>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <button type="button" style="margin-top:25px;" id="btn-add" class="btn btn-success">ADD</button>
                                            </div>
                                        </div>

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
                    <input type="text" required class="form-control" readonly name="total" id="total"/>
                </div>
                <div class="row mb-3">
                    <label for="total_discount" class="required form-label">Total Discount:</label>
                    <input type="text" required class="form-control" readonly name="total_discount" id="total_discount"/>
                </div>
                <div class="row mb-3">
                    <label for="net_total" class="required form-label">Net Total:</label>
                    <input type="text" required class="form-control" readonly name="net_total" id="net_total"/>
                </div>
                <!--end::Input group-->
                <!--begin::Separator-->
                <div class="separator separator-dashed mb-8"></div>
                <!--end::Separator-->
                <!--begin::Input group-->
                <div class="mb-0">
                    <!--begin::Row-->
                    <!--end::Row-->
                    <button type="submit" class="btn btn-primary w-100" id="btn-submit">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen016.svg-->
                    <span class="svg-icon svg-icon-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M15.43 8.56949L10.744 15.1395C10.6422 15.282 10.5804 15.4492 10.5651 15.6236C10.5498 15.7981 10.5815 15.9734 10.657 16.1315L13.194 21.4425C13.2737 21.6097 13.3991 21.751 13.5557 21.8499C13.7123 21.9488 13.8938 22.0014 14.079 22.0015H14.117C14.3087 21.9941 14.4941 21.9307 14.6502 21.8191C14.8062 21.7075 14.9261 21.5526 14.995 21.3735L21.933 3.33649C22.0011 3.15918 22.0164 2.96594 21.977 2.78013C21.9376 2.59432 21.8452 2.4239 21.711 2.28949L15.43 8.56949Z" fill="black" />
                            <path opacity="0.3" d="M20.664 2.06648L2.62602 9.00148C2.44768 9.07085 2.29348 9.19082 2.1824 9.34663C2.07131 9.50244 2.00818 9.68731 2.00074 9.87853C1.99331 10.0697 2.04189 10.259 2.14054 10.4229C2.23919 10.5869 2.38359 10.7185 2.55601 10.8015L7.86601 13.3365C8.02383 13.4126 8.19925 13.4448 8.37382 13.4297C8.54839 13.4145 8.71565 13.3526 8.85801 13.2505L15.43 8.56548L21.711 2.28448C21.5762 2.15096 21.4055 2.05932 21.2198 2.02064C21.034 1.98196 20.8409 1.99788 20.664 2.06648Z" fill="black" />
                        </svg>
                    </span>
                    Save</button>
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
                                <th class="min-w-150px w-150px">Label Price</th>
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
<div class="row" style="margin-top:20px;">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h3>Free Issues</h3>
                <div class="row gx-10 mb-5">
                    <!--begin::Col-->
                    <div class="col-lg-6">
                        <label class="form-label fs-6 fw-bolder text-gray-700 mb-3">Item</label>
                        <!--begin::Input group-->
                        <div class="mb-5">
                            <select class="form-select" name="free_item" id="free_item" data-control="select2" data-placeholder="Select an option">
                                <option value="">Please select an Item</option>
                                @foreach($items as $item)
                                <option data-name="{{$item->item_name}}" value="{{$item->id}}">{{$item->item_name}}  || {{$item->barcode}} || {{$item->item_code}}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-lg-3">
                        <label class="form-label fs-6 fw-bolder text-gray-700 mb-3">Quantity</label>
                        <!--begin::Input group-->
                        <div class="mb-5">
                            <input type="number" min="1" id="free_quantity" class="form-control" />
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="button" style="margin-top:25px;" id="btn-add-free" class="btn btn-success">ADD</button>
                            </div>
                        </div>

                    </div>
                    <!--end::Col-->
                </div>
                <div class="table-responsive mb-10">
                    <!--begin::Table-->
                    <table class="table g-5 gs-0 mb-0 fw-bolder text-gray-700" id="tbl-free-items">
                        <!--begin::Table head-->
                        <thead>
                            <tr class="border-bottom fs-7 fw-bolder text-gray-700 text-uppercase">
                                <th class="min-w-300px w-475px">Item</th>
                                <th class="min-w-100px w-100px">QTY</th>
                                <th class="min-w-75px w-75px text-end">Action</th>
                            </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody>

                        </tbody>
                        <!--end::Table body-->
                    </table>
                </div>
            </div>
        </div>
    </div>
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
        $('#supplier').focus();
    });
    $('#item').change(function(){
        if($('#item').val()!="" && $('#item').val()!=null){
            $('#discount').val("0.00");
            $('#quantity').focus();
        }
    });
    $('#label_price').keyup(function(){
        if(($('#item').val()!="" && $('#item').val()!=null) && ($('#quantity').val()!="" && $('#quantity').val()!=null)){
            let amount=($('#label_price').val()-$('#discount').val())*$('#quantity').val();
            $('#amount').val(amount);
        }
    });
    $('#discount').keyup(function(){
        if(($('#item').val()!="" && $('#item').val()!=null) && ($('#quantity').val()!="" && $('#quantity').val()!=null) && ($('#discount').val()!="" && $('#discount').val()!=null)){
            let amount=($('#label_price').val()-$('#discount').val())*$('#quantity').val();
            $('#amount').val(amount);
        }
    });
    $('#discount').focusout(function(){
        $('#have_free').focus();
    });
    $('#btn-add').click(function(){
        if($('#item').val()=="" || $('#item').val()==null){
            alert('Please select an Item to continue');
            $('#item').focus();
        }else if($('#quantity').val()=="" || $('#quantity').val()==null){
            alert('Please input the quantity');
            $('#quantity').focus();
        }else if($('#label_price').val()=="" || $('#label_price').val()==null){
            alert('Label price can not be empty');
            $('#label_price').focus();
        }else if($('#discount').val()=="" || $('#discount').val()==null){
            alert('Enter the discount for one unit..');
            $('#discount').focus();
        }else{
            let item_id=$('#item').val();
            let item_name=$('#item').find(":selected").data('name');
            let label_price=$('#label_price').val();
            let quantity=$('#quantity').val();
            let discount=$('#discount').val();
            let amount=$('#amount').val();
            if(itemsInTable.includes(item_id+"")){
                alert('Item Already Inserted');
            }else{
                itemsInTable.push(item_id+"");
                let markup=`
                <tr class="border-bottom border-bottom-dashed item-row" data-kt-element="item" id="tr${count}" data-item="${item_id}">
                    <td class="pe-7">
                        <p>${item_name}</p>
                        <input type="hidden" name="details[${count}][item]" value="${item_id}"/>
                    </td>

                    <td>
                        <input type="text" class="form-control form-control-solid text-end label_price" readonly name="details[${count}][label_price]" value="${label_price}" placeholder="0.00" value="0.00" />
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-solid text-end discount" readonly name="details[${count}][discount]" value="${discount}" placeholder="0.00" value="0.00" />
                    </td>
                    <td class="ps-0">
                        <input class="form-control form-control-solid qty" type="number" min="1" readonly name="details[${count}][quantity]" value="${quantity}" placeholder="1" value="1" />
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-solid text-end amount" readonly name="details[${count}][amount]" value="${amount}" placeholder="0.00" value="0.00" />
                    </td>
                    <td class="pt-5 text-end">
                        <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" onclick="deleteItem(${count})">
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
                $('#label_price').val("");
                $('#discount').val("");
                $('#amount').val("");
                $('#item').focus();
            }
        }
    });
    function calInvoiceTotal(){
        total=0;
        $("#tbl-items .item-row").each(function(){
            total=total+($(this).find('.qty').val()*$(this).find('.label_price').val())*1;
        });
        $('#total').val(total);
        discount=0;
        $('#tbl-items .item-row').each(function(){
            discount=discount+($(this).find('.qty').val()*$(this).find('.discount').val())*1;
        });
        $('#total_discount').val(discount);
        $('#net_total').val(total-discount);
    }
    function deleteItem(index){
        let item_id=$('#tr'+index).data('item-id');
        $('#tr'+index).remove();
        console.log(itemsInTable);
        let search=item_id+"";
        let i = itemsInTable.indexOf(search+"");
        console.log(i);
        if ( i >= 0 ) itemsInTable.splice( i , 1 );
    }
    var itemsInFreeTable=[];
    var free_count=0;
    $('#btn-add-free').click(function(){
        if($('#free_item').val()=="" || $('#free_item').val()==null){
            alert('Please select an Free issue Item to continue');
            $('#free_item').focus();
        }else if($('#free_quantity').val()=="" || $('#free_quantity').val()==null){
            alert('Please input free issued quantity');
            $('#free_quantity').focus();
        }else{
            let free_item_id=$('#free_item').val();
            let free_item_name=$('#free_item').find(":selected").data('name');
            let free_qty=$('#free_quantity').val();
            if(itemsInFreeTable.includes(free_item_id+"")){
                alert('Item already Inserted');
                $('#free_item').focus();
            }else{
                itemsInFreeTable.push(free_item_id+"");
                let free_markup=`
                <tr class="border-bottom border-bottom-dashed item-row" data-free-item="${free_item_id}" id="row${free_count}">
                    <td class="pe-7">
                        <p>${free_item_name}</p>
                        <input type="hidden" name="free_details[${free_count}][item]" value="${free_item_id}"/>
                    </td>
                    <td class="ps-0">
                        <input class="form-control form-control-solid" type="number" min="1" name="free_details[${free_count}][quantity]" placeholder="1" value="${free_qty}" data-kt-element="quantity" />
                    </td>
                    <td class="pt-5 text-end">
                        <button type="button" onclick="deleteFreeItem(${free_count})" class="btn btn-sm btn-icon btn-active-color-primary" data-kt-element="remove-item">
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
                $("#tbl-free-items tbody").append(free_markup);
                free_count=free_count*1+1;
                $('#free_item').val("");
                $('#free_item').trigger('change');
                $('#free_quantity').val("");
                $('#free_item').focus();
            }
        }
    });
    function deleteFreeItem(index){
        let item_id=$('#row'+index).data('free-item');
        $('#row'+index).remove();
        let search=item_id+"";
        let i = itemsInFreeTable.indexOf(search+"");
        console.log(i);
        if ( i >= 0 ) itemsInFreeTable.splice( i , 1 );
    }
    $(document).on('keydown', function(event) {
       if (event.key == "Escape") {
           $('#btn-submit').focus();
       }
    });
</script>
@endsection
