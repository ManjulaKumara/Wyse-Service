@extends('layouts.wyse')
@section('optional_css')
<link href="{{url('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
<form action="{{url('/item-conversion/store')}}" method="POST">
    @csrf
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
                                    <!--begin::Col-->
                                    <div class="col-lg-4">
                                        <label class="form-label fs-6 fw-bolder text-gray-700 mb-3">From Item</label>
                                        <!--begin::Input group-->
                                        <div class="mb-5">
                                            <select required class="form-select" name="from_item" id="from_item" data-control="select2" data-placeholder="Select an option">
                                                <option value="">Select an Item</option>
                                                @foreach ($parent_items as $item)
                                                <option value="{{$item->id}}">{{$item->item_name || $item->item_code}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <label class="form-label fs-6 fw-bolder text-gray-700 mb-3">From Quantity</label>
                                        <!--begin::Input group-->
                                        <div class="mb-5">
                                            <input type="number" id="from_quantity" name="from_quantity" required class="form-control" />
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
                                            <input type="number" id="to_quantity" readonly name="to_quantity" required class="form-control" />
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
    $('#from_item').change(function(){
        if($('#from_item').val()!="" && $('#from_item').val!=null){
            let dropdown = $('#to_item');
            dropdown.empty();
            dropdown.append('<option selected="selected" value="">Choose Value</option>');
            dropdown.select2();
            // Populate dropdown with list of provinces
            let _dop_url=APP_URL+'/ajax/child-items/'+$('#from_item').val();
            $.getJSON( _dop_url, function ( data ) {
                $.each(data, function ( key, entry ) {
                    dropdown.append($('<option></option>').attr('value', entry.id).attr('data-upp',entry.units_per_parent).text(entry.item_name+' || '+entry.item_code));
                })
            });
        }
    });
    $('#to_item').change(function(){
        if($('#from_quantity').val()=="" || $('#from_quantity').val()==null){
            alert('Please provide parent item quantity that you want to convert into child items.');
            $('#from_quantity').focus();
        }else{
            let upp=$('#to_item').find(':selected').data('upp');
            let coverted_quantity=$('#from_quantity').val()*upp;
            $('#to_quantity').val(converted_quantity);
        }
    });
    $('#from_quantity').keyup(function(){
        if($('#to_item').val()!="" && $('#to_item').val()!=null){
            let upp=$('#to_item').find(':selected').data('upp');
            let coverted_quantity=$('#from_quantity').val()*upp;
            $('#to_quantity').val(converted_quantity);
        }
    });
</script>
@endsection
