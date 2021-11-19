@extends('layouts.wyse')
@section('optional_css')
<link href="{{url('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
<form id="issue-form" action="{{url('/material-issues/store')}}" method="POST">
    @csrf
<div class="d-flex flex-column flex-lg-row">
    <!--begin::Content-->
    <div class="flex-lg-row-fluid mb-10 mb-lg-0 me-lg-7 me-xl-10">
        <div class="card">
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    <h4>Material Issue</h4>
                </div>
                <!--begin::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                        <!--begin::Add new-->
                        <a href="{{url('/material-issues/all')}}"><button type="button" class="btn btn-success" >Back<i class="fa fa-angle-left"></i></button></a>
                        <!--end::Add new-->
                    </div>
                    <!--end::Toolbar-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--begin::Card body-->
            <div class="card-body p-12">
                <div class="row">
                    <div class="col-md-6">
                        <h3>Material Issue No : {{$issue_number}}</h3>
                    </div>
                    <div class="col-md-6">
                        <h3 style="text-align: right">Date : {{$today}}</h3>
                    </div>
                </div>
                <div class="separator separator-dashed my-10"></div>
                <!--begin::Form-->
                {{-- <form action="" id="kt_invoice_form"> --}}
                    <div class="mb-0">
                        <div class="row">
                            <div class="col-md-12">
                                <!--end::Top-->

                                <div class="row gx-10 mb-5">

                                    <div class="col-lg-6">
                                        <label class="form-label fs-6 fw-bolder text-gray-700 mb-3">Item</label>
                                        <!--begin::Input group-->
                                        <div class="mb-5">
                                            <select class="form-select" name="item" id="item" data-control="select2" data-placeholder="Select an option">
                                                <option></option>
                                                @foreach($item_list as $item)
                                                <option data-qih="{{$item->qih}}" value="{{$item->id}}">{{$item->name}} || {{$item->category}} || {{$item->barcode}} || {{$item->qih}} </option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col-lg-2">
                                        <label class="form-label fs-6 fw-bolder text-gray-700 mb-3">Quantity</label>
                                        <!--begin::Input group-->
                                        <div class="mb-5">
                                            <input type="text" class="form-control form-control-solid" id="qty" name="qty" />
                                        </div>
                                    </div>
                                    <div class="col-lg-1">
                                        <button type="button" style="margin-top:25px;" class="btn btn-success" id="btn-add">ADD</button>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Table-->
                            </div>
                        </div>
                        <!--begin::Separator-->
                        <div class="separator separator-dashed my-10"></div>
                        <div class="table-responsive mb-10">
                            <!--begin::Table-->
                            <table class="table g-5 gs-0 mb-0 fw-bolder text-gray-700" id="tbl-items">
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
                    <!--end::Wrapper-->
                {{-- </form>
                <!--end::Form--> --}}
            </div>
            <!--end::Card body-->
            <div class="card-footer">

                <Button style="float: right;margin:5px;" id="btnSubmit" type="Submit" class="btn btn-primary" onclick="return checkData();">Save</Button>
                <a style="float: right;margin:5px;" id="refershBtn" href="{{url('/stock-issues/create')}}" class="btn btn-danger">Reset</a>
            </div>
        </div>
    </div>
</div>
</form>
@endsection
@section('opyional_js')
<script src="{{url('assets/plugins/global/plugins.bundle.js')}}"></script>
<script>
    var issue_no='{{$issue_number}}';
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
    let itemsInTable=new Array();
    let count=0;
    $(function(){
        $('#tbl-items tbody').empty();

        $('#btnSubmit').prop('disabled',true);
    });
    $('#btn-add').click(function(){
        if($('#item').val()==''||$('#item').val()==null){
            $('#item').focus();
            alert('Please select an item!!');
        }else if($('#qty').val()==''||$('#qty').val()==null){
            $('#qty').focus();
            alert('Quantity select an item!!');
        }else{
            let vehicle_no=$('#vehicle_no').val();
            let item=$('#item').val();
            let item_name=$('#item').find(":selected").text();
            let item_name_arr=item_name.split("||");
            item_name=item_name_arr[0];
            let qty=$('#qty').val();
            if(itemsInTable.includes(issue_no+" "+item)){
                $('#item').focus();
                alert('Item is already inserted!');
            }else{
                itemsInTable.push(issue_no+" "+item);
                let markup=`
                    <tr class="border-bottom border-bottom-dashed" id="tr${count}" data-item-id="${item}" data-vehicle-number="${issue_no}">
                        <td class="pe-7">
                            <p>${item_name}</p>
                            <input type="hidden" name="details[${count}][item]" value="${item}" />
                            <input type="hidden" class="form-control" readonly name="details[${count}][issue_no]" value="${issue_no}" />
                        </td>
                        <td class="ps-0">
                            <input class="form-control form-control-solid" type="number" min="1" name="details[${count}][qty]" readonly value="${qty}" />
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
                $('#qty').val("");
                $('#item').val("");
                $('#item').trigger('change');
                $('#item').focus();
            }
        }
        if(itemsInTable.length>0){
            $('#btnSubmit').prop('disabled',false);
        }else{
            $('#btnSubmit').prop('disabled',true);
        }
    });
    $('#qty').keydown(function(){
        let qih=$('#item').find(":selected").data('qih');
        if(qih<$('#qty').val()){
            alert('Not enough quantity in hand...');
        }
    });

    function deleteItem(index){
        let item_id=$('#tr'+index).data('item-id');
        let vehicle_number=$('#tr'+index).data('vehicle-number');
        $('#tr'+index).remove();
        console.log(itemsInTable);
        let search=""+vehicle_number+" "+item_id;
        let i = itemsInTable.indexOf(search+"");
        console.log(i);
        if ( i >= 0 ) itemsInTable.splice( i , 1 );
        if(itemsInTable.length>0){
            $('#btnSubmit').prop('disabled',false);
        }else{
            $('#btnSubmit').prop('disabled',true);
        }
    }
    function checkData(){
        if(itemsInTable.length>0){
            return true;
        }else{
            return false;
        }
    }
</script>
@endsection
