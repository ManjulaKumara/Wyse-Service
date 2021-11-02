@extends('layouts.wyse')
@section('optional_css')
<link href="{{url('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
<form action="{{url('/stock-returns/store')}}" method="POST">
    @csrf
<div class="d-flex flex-column flex-lg-row">
    <!--begin::Content-->
    <div class="flex-lg-row-fluid mb-10 mb-lg-0 me-lg-7 me-xl-10">
        <div class="card">
            <!--begin::Card body-->
            <div class="card-body p-12">
                <div class="row">
                    <div class="col-md-6">
                        <h3>Stock Returns</h3>
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
                                    <div class="col-md-3">
                                        <label for="vehicle_no" class="required form-label">Vehicle No:</label>
                                        <input type="text" required class="form-control" name="vehicle_no" id="vehicle_no" autofocus/>
                                    </div>
                                    <!--begin::Col-->
                                    <div class="col-lg-6">
                                        <label class="form-label fs-6 fw-bolder text-gray-700 mb-3">Item</label>
                                        <!--begin::Input group-->
                                        <div class="mb-5">
                                            <select required class="form-select" name="item" id="item" data-control="select2" data-placeholder="Select an option">
                                                <option value="">Select an Item</option>
                                            </select>
                                        </div>

                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col-lg-2">
                                        <label class="form-label fs-6 fw-bolder text-gray-700 mb-3">Quantity</label>
                                        <!--begin::Input group-->
                                        <div class="mb-5">
                                            <input type="number" id="quantity" name="quantity" required class="form-control form-control-solid" />
                                            <input type="hidden" name="stock_issue" id="stock_issue">
                                        </div>
                                    </div>
                                    <div class="col-lg-1">
                                        <button type="submit" style="margin-top:25px;" class="btn btn-success">SAVE</button>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Table-->
                            </div>
                        </div>

                {{-- </form>
                <!--end::Form--> --}}
            </div>
            <!--end::Card body-->
        </div>
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
    $('#vehicle_no').focusout(function(){
        let dropdown = $('#item');
        dropdown.empty();
        dropdown.append('<option selected="selected" value="">Choose Value</option>');
        dropdown.select2();
        // Populate dropdown with list of provinces
        let _dop_url=APP_URL+'/ajax/stock-issues-by-vehicle/'+$('#vehicle_no').val();
        $.getJSON( _dop_url, function ( data ) {
            $.each(data, function ( key, entry ) {
                dropdown.append($('<option></option>').attr('value', entry.id).attr('data-stock',entry.stock_no).attr('data-qty',entry.quantity).text(entry.name+' || '+entry.code+' || '+entry.barcode));
            })
        });
    });
    $('#item').change(function(){
        if($('#item').val()!="" && $('#item').val!=null){
            let quantity=$('#item').find(":selected").data('qty');
            let stock=$('#item').find(":selected").data('stock');
            $('#quantity').val(quantity).attr('max',quantity).attr('min',quantity);
            $('#stock_issue').val(stock);
        }
    });
</script>
@endsection
