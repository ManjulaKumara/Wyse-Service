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
                        <h3>Item Convertion</h3>
                    </div>
                    <div class="col-md-6">
                        <h3 style="text-align: right">Date : </h3>
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
                                    <!--begin::Col-->
                                    <div class="col-lg-4">
                                        <label class="form-label fs-6 fw-bolder text-gray-700 mb-3">From Item</label>
                                        <!--begin::Input group-->
                                        <div class="mb-5">
                                            <select required class="form-select" name="from_item" id="from_item" data-control="select2" data-placeholder="Select an option">
                                                <option value="">Select an Item</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <label class="form-label fs-6 fw-bolder text-gray-700 mb-3">From Quantity</label>
                                        <!--begin::Input group-->
                                        <div class="mb-5">
                                            <input type="number" id="quantity" name="quantity" required class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="form-label fs-6 fw-bolder text-gray-700 mb-3">To Item</label>
                                        <!--begin::Input group-->
                                        <div class="mb-5">
                                            <select required class="form-select" name="to_item" id="to_item" data-control="select2" data-placeholder="Select an option">
                                                <option value="">Select an Item</option>
                                            </select>
                                        </div>

                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->

                                    <div class="col-lg-2">
                                        <label class="form-label fs-6 fw-bolder text-gray-700 mb-3">To Quantity</label>
                                        <!--begin::Input group-->
                                        <div class="mb-5">
                                            <input type="number" id="quantity" readonly name="quantity" required class="form-control" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" style="margin-top:25px;float: right;" class="btn btn-success">SAVE</button>
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
