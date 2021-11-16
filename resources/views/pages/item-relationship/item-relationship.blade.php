@extends('layouts.wyse')
@section('optional_css')
<link href="{{url('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
<form @if (Request::segment(2)=='edit') action="{{url('/item-relationship/update/'.$relation->id)}}" @else action="{{url('/item-relationship/store')}}" @endif method="POST">
    @csrf
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body p-12">
                        <div class="row">
                            <div class="col-md-6">
                                <h3>Parent Item </h3>
                            </div>
                        </div>

                        <div class="separator separator-dashed my-10"></div>
                        <!--begin::Form-->
                        {{-- <form action="" id="kt_invoice_form"> --}}
                            <div class="mb-0">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="item" class="required form-label">Item</label>
                                                <select class="form-select" required name="parent_item" id="parent_item" data-control="select2" data-placeholder="Select an option">
                                                    <option value="">Please select an Item</option>
                                                    @foreach ($items as $item)
                                                        <option value="{{$item->id}}" @if (Request::segment(2)=='edit') @if ($item->id==$relation->parent_item) selected disabled @endif @endif>{{$item->item_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row gx-10 mb-5">

                                            <!--begin::Col-->
                                            <div class="col-lg-12">
                                                <label class="form-label fs-6 fw-bolder mb-3">Quantity</label>
                                                <!--begin::Input group-->
                                                <div class="mb-5">
                                                    <input type="text" value="1" readonly id="quantity" name="quantity" class="form-control" />
                                                </div>
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Table-->
                                    </div>
                                </div>
                            </div>
                            <!--end::Wrapper-->
                        {{-- </form>
                        <!--end::Form--> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body p-12">
                        <div class="row">
                            <div class="col-md-6">
                                <h3>Child Item </h3>
                            </div>
                        </div>

                        <div class="separator separator-dashed my-10"></div>
                        <!--begin::Form-->
                        {{-- <form action="" id="kt_invoice_form"> --}}
                            <div class="mb-0">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="item" class="required form-label">Item</label>
                                                <select class="form-select" required name="child_item" id="child_item" data-control="select2" data-placeholder="Select an option">
                                                    <option value="">Please select an Item</option>
                                                    @foreach ($items as $item)
                                                        <option value="{{$item->id}}" @if (Request::segment(2)=='edit') @if ($item->id==$relation->child_item) selected disabled @endif @endif>{{$item->item_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <br>
                                        @if (Request::segment(2)=='edit')
                                        <input type="hidden" name="parent_item" value="{{$relation->parent_item}}">
                                        <input type="hidden" name="child_item" value="{{$relation->child_item}}">
                                        @endif
                                        <div class="row gx-10 mb-5">

                                            <!--begin::Col-->
                                            <div class="col-lg-12">
                                                <label class="form-label fs-6 fw-bolder mb-3">Quantity</label>
                                                <!--begin::Input group-->
                                                <div class="mb-5">
                                                    <input type="number" required min="1" id="units_per_parent" name="units_per_parent" class="form-control" />
                                                </div>
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <br>
                                        <div class="row ">
                                            <div class="col-lg-8">
                                            </div>
                                            <!--begin::Col-->
                                            <div class="col-lg-2">
                                                <div style="float: right">
                                                    <button type="submit" class="btn btn-primary">SAVE</button>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div style="float: right">
                                                    <button type="reset" class="btn btn-danger">CLEAR</button>
                                                </div>
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Wrapper-->
                        {{-- </form>
                        <!--end::Form--> --}}
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
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
    $('#parent_item').change(function(){
        if($('#child_item').val()!="" && $('#child_item').val()!=null){
            if($('#parent_item').val()!="" && $('#parent_item').val()!=null){
                if($('#parent_item').val()==$('#child_item').val()){
                    alert('Parent Item and Child Item can not be same..');
                    $('#parent_item').focus();
                }
            }
        }
    });
    $('#child_item').change(function(){
        if($('#child_item').val()!="" && $('#child_item').val()!=null){
            if($('#parent_item').val()!="" && $('#parent_item').val()!=null){
                if($('#parent_item').val()==$('#child_item').val()){
                    alert('Parent Item and Child Item can not be same..');
                    $('#child_item').focus();
                }
            }
        }
    });
</script>
@endsection
