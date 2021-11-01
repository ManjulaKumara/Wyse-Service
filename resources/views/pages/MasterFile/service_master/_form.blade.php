@extends('layouts.wyse')
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
    <form class="form" method="POST" @if (Request::segment(2)=='view') action="{{url('#')}}" @elseif (Request::segment(2)=='edit') action="{{url('/sevices/update/'.$service->id)}}" @else action="{{url('/sevices/store')}}" @endif>
        @csrf
        <input type="hidden" name="lead_id" id="cust_lead_id">
        <div class="card-body">
            <div class="form-group row">
                <div class="col-lg-6">
                    <label class="required">Service Name</label>
                    <input type="text"  id="service_name" name="service_name" class="form-control" required @if (Request::segment(2)=='view') value="{{$service->service_name}}" readonly @elseif (Request::segment(2)=='edit') value="{{$service->service_name}}" @else value="" @endif/>
                </div>
                <div class="col-lg-6">
                    <label class="required">Service Rate</label>
                    <input type="text" id="service_rate" name="service_rate" required class="form-control" @if (Request::segment(2)=='view') value="{{$service->service_rate}}" readonly @elseif (Request::segment(2)=='edit') value="{{$service->service_rate}}" @else value="" @endif/>
                    {{-- <input type="hidden" id="cust_id" name="id" class="cus_lead_id form-control"/> --}}
                </div>
            </div><br>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label class="required">Discount Rate</label>
                    <input type="text"  id="discount_rate" name="discount_rate" class="form-control" required @if (Request::segment(2)=='view') value="{{$service->discount_rate}}" readonly @elseif (Request::segment(2)=='edit') value="{{$service->discount_rate}}" @else value="" @endif/>
                </div>
            </div><br>
            <div class="form-group row">
                <div class="col-lg-12">
                    <label class="required">Service Description</label>
                    <input type="text"  id="service_description" name="service_description" class="form-control" required @if (Request::segment(2)=='view') value="{{$service->service_description}}" readonly @elseif (Request::segment(2)=='edit') value="{{$service->service_description}}" @else value="" @endif/>
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
