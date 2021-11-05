@extends('layouts.wyse')
@section('optional_css')
<link href="{{url('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
<div class="card">
    <div class="card-header border-0 pt-6">
        <!--begin::Card title-->
        <div class="card-title">
            <h4>@if (Request::segment(2)=='view') View @elseif (Request::segment(2)=='edit') Update @else New @endif Service</h4>
        </div>
        <!--begin::Card title-->
        <!--begin::Card toolbar-->
        <div class="card-toolbar">
            <!--begin::Toolbar-->
            <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                <!--begin::Add new-->
                <a href="{{url('/sevices/all')}}"><button type="button" class="btn btn-success" >Back<i class="fa fa-angle-left"></i></button></a>
                <!--end::Add new-->
            </div>
            <!--end::Toolbar-->
        </div>
        <!--end::Card toolbar-->
    </div>
    <form class="form" method="POST" @if (Request::segment(2)=='view') action="{{url('#')}}" @elseif (Request::segment(2)=='edit') action="{{url('/sevices/update/'.$service->id)}}" @else action="{{url('/open-stock/store')}}" @endif>
        @csrf
        <input type="hidden" name="lead_id" id="cust_lead_id">
        <div class="card-body">
            <div class="form-group row">
                <div class="col-lg-6">
                    <label class="required">Item</label>
                    <select class="form-select" name="item" id="item" data-control="select2" data-placeholder="Select an option" required>
                        <option value=""></option>
                        @foreach ($items as $item)
                        <option value="{{$item->id}}">{{$item->item_code}} || {{$item->item_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-6">
                    <label class="required">Purchase Quantity</label>
                    <input type="number" id="purchase_qty" name="purchase_qty" required class="form-control" @if (Request::segment(2)=='view') value="{{$service->service_rate}}" readonly @elseif (Request::segment(2)=='edit') value="{{$service->service_rate}}" @else value="" @endif/>
                    {{-- <input type="hidden" id="cust_id" name="id" class="cus_lead_id form-control"/> --}}
                </div>
            </div><br>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label class="required">Cost Price</label>
                    <input type="text"  id="cost_price" name="cost_price" class="form-control" required @if (Request::segment(2)=='view') value="{{$service->discount_rate}}" readonly @elseif (Request::segment(2)=='edit') value="{{$service->discount_rate}}" @else value="" @endif/>
                </div>
                <div class="col-lg-6">
                    <label class="required">Sales Price</label>
                    <input type="text"  id="sales_price" name="sales_price" class="form-control" required @if (Request::segment(2)=='view') value="{{$service->service_description}}" readonly @elseif (Request::segment(2)=='edit') value="{{$service->service_description}}" @else value="" @endif/>
                </div>
            </div><br>
            <div class="form-group row">
                <div class="col-lg-6"></div>
                <div class="col-lg-6" style="text-align-last: right" >
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
@section('opyional_js')
<script src="{{url('assets/plugins/global/plugins.bundle.js')}}"></script>
@endsection
