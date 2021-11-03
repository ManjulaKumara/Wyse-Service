@extends('layouts.wyse')
@section('optional_css')
<link href="{{url('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
<form action="{{url('/item-damages/store')}}" method="POST">
    @csrf
<div class="d-flex flex-column flex-lg-row">
    <!--begin::Content-->
    <div class="flex-lg-row-fluid mb-10 mb-lg-0 me-lg-7 me-xl-10">
        <div class="card">
            <!--begin::Card body-->
            <div class="card-body p-12">
                <div class="row">
                    <div class="col-md-6">
                        <h3>Item Damages</h3>
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
                                    <div class="col-lg-7">
                                        <label class="form-label fs-6 fw-bolder text-gray-700 mb-3">Item</label>
                                        <!--begin::Input group-->
                                        <div class="mb-5">
                                            <select required class="form-select" name="item" id="item" data-control="select2" data-placeholder="Select an option">
                                                <option value="">Select an Item</option>
                                                @foreach($item_list as $item)
                                                <option data-qih="{{$item->qih}}" value="{{$item->id}}">{{$item->name}} || {{$item->code}}</option>
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
                                            <input type="number" id="damage_quantity" min="1" name="damage_quantity" required class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
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
    $('#damage_quantity').keyup(function(){
        if($('#item').val()!="" && $('#item').val()!=null){
            let qih=$('#item').find(':selected').data('qih');
            if($('#damage_quantity').val()>qih){
                alert('Damage quantity can not be higher than quantity in hand.');
                $('#damage_quantity').val("");
            }
        }
    });
    $('#item').change(function(){
        if($('#item').val()!="" && $('#item').val()!=null){
            let qih=$('#item').find(':selected').data('qih');
            if($('#damage_quantity').val()>qih){
                alert('Damage quantity can not be higher than quantity in hand.');
                $('#damage_quantity').val("");
            }
        }
    });
</script>
@endsection
