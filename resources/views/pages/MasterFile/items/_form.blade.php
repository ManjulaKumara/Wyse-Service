@extends('layouts.wyse')
@section('content')
<div class="card">
    <div class="card-header border-0 pt-6">
        <!--begin::Card title-->
        <div class="card-title">
            <h4>@if (Request::segment(2)=='view') View @elseif (Request::segment(2)=='edit') Update @else New @endif Item</h4>
        </div>
        <!--begin::Card title-->
        <!--begin::Card toolbar-->
        <div class="card-toolbar">
            <!--begin::Toolbar-->
            <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                <!--begin::Add new-->
                <a href="{{url('/items/all')}}"><button type="button" class="btn btn-success" >Back<i class="fa fa-angle-left"></i></button></a>
                <!--end::Add new-->
            </div>
            <!--end::Toolbar-->
        </div>
        <!--end::Card toolbar-->
    </div>
    <form class="form" method="POST" @if (Request::segment(2)=='view') action="{{url('#')}}" @elseif (Request::segment(2)=='edit') action="{{url('/items/update/'.$item->id)}}" @else action="{{url('/items/store')}}" @endif>
        @csrf
        <input type="hidden" name="lead_id" id="cust_lead_id">
        <div class="card-body">
            <div class="form-group row">
                <div class="col-lg-6">
                    <label class="required">Item Code</label>
                    <input type="text"  id="item_code" name="item_code" class="form-control" required @if (Request::segment(2)=='view') value="{{$item->item_code}}" readonly @elseif (Request::segment(2)=='edit') value="{{$item->item_code}}" @else value="" @endif/>
                </div>
                <div class="col-lg-6">
                    <label class="required">Item Name</label>
                    <input type="text" id="item_name" name="item_name" required class="form-control" @if (Request::segment(2)=='view') value="{{$item->item_name}}" readonly @elseif (Request::segment(2)=='edit') value="{{$item->item_name}}" @else value="" @endif/>
                    {{-- <input type="hidden" id="cust_id" name="id" class="cus_lead_id form-control"/> --}}
                </div>
            </div><br>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label class="required">Item Category</label>
                    <select class="form-control js-example-basic-single compulsory" id="category" name="category" required>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}" @if (Request::segment(2)=='view') disabled @if ($category->id==$item->category) selected @endif @elseif (Request::segment(2)=='edit') @if ($category->id==$item->category) selected @endif @endif>{{$category->category_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-6">
                    <label class="required">Re Order Level</label>
                    <input type="number" id="re_order_level" name="re_order_level" class="form-control" required @if (Request::segment(2)=='view') value="{{$item->re_order_level}}" readonly @elseif (Request::segment(2)=='edit') value="{{$item->re_order_level}}" @else value="" @endif/>
                </div>
            </div><br>
            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Description</label>
                    <input type="text"  id="item_description" name="item_description" class="form-control" @if (Request::segment(2)=='view') value="{{$item->item_description}}" readonly @elseif (Request::segment(2)=='edit') value="{{$item->item_description}}" @else value="" @endif/>
                </div>
            </div><br>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label class="required">Discount Rate</label>
                    <input type="text"  id="discount_rate" name="discount_rate" class="form-control" required @if (Request::segment(2)=='view') value="{{$item->discount_rate}}" readonly @elseif (Request::segment(2)=='edit') value="{{$item->discount_rate}}" @else value="" @endif/>
                </div>
                <div class="col-lg-6">
                    <label class="required">Item Type</label>
                    <select class="form-control js-example-basic-single compulsory" id="item_type" name="item_type" required>
                        <option value="Label Price" @if (Request::segment(2)=='view') disabled @if ($item->item_type=='Label Price') selected @endif @elseif (Request::segment(2)=='edit') @if ($item->item_type=='Label Price') selected @endif @endif>Label Price</option>
                        <option value="Discount Price" @if (Request::segment(2)=='view') disabled @if ($item->item_type=='Discount Price') selected @endif @elseif (Request::segment(2)=='edit') @if ($item->item_type=='Discount Price') selected @endif @endif>Discount Price</option>
                    </select>
                </div>
            </div><br>
            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Remarks</label>
                    <input type="text"  id="remarks" name="remarks" class="form-control" @if (Request::segment(2)=='view') value="{{$item->remarks}}" readonly @elseif (Request::segment(2)=='edit') value="{{$item->remarks}}" @else value="" @endif/>
                </div>
            </div><br>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Barcode</label>
                    <input type="text"  id="barcode" name="barcode" class="form-control" @if (Request::segment(2)=='view') value="{{$item->barcode}}" readonly @elseif (Request::segment(2)=='edit') value="{{$item->barcode}}" @else value="" @endif/>
                </div>
                <div class="col-lg-6">
                    <label class="required">Status</label>
                    <div class="radio-inline">
                        <label class="radio radio-solid">
                            <input type="radio" id="status" name="is_active" checked="checked" value="1" @if (Request::segment(2)=='view') disabled @if ($item->is_active==1) checked="checked" @endif @elseif (Request::segment(2)=='edit') @if ($item->is_active==1) checked="checked" @endif @else  checked="checked"  @endif/>
                            <span></span>
                            Active
                            </label>
                        <label class="radio radio-solid">
                            <input type="radio" id="status" name="is_active" value="0" @if (Request::segment(2)=='view') disabled @if ($item->is_active==0) checked="checked" @endif @elseif (Request::segment(2)=='edit') @if ($item->is_active==0) checked="checked" @endif @else value="" @endif/>
                            <span></span>
                            InActive
                        </label>
                    </div>
                    <span class="form-text text-muted">Please select status</span>
                </div>
            </div><br>
            <div class="form-group row">
                <div class="col-lg-6"></div>
                <div class="col-lg-6" style="text-align-last: right" id="create_button">
                    <button type="reset" class="btn btn-secondary btn-lg mr-3" @if (Request::segment(2)=='view') disabled @endif>
                        <i class="fas fa-redo"></i> Reset
                    </button>
                    <button type="submit" class="btn btn-primary btn-lg mr-3" @if (Request::segment(2)=='view') disabled @endif>
                        <i class="fas fa-save"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
