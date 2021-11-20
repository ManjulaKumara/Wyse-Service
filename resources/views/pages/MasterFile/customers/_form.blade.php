@extends('layouts.wyse')
@section('content')
<div class="card">
    <div class="card-header border-0 pt-6">
        <!--begin::Card title-->
        <div class="card-title">
            <h4>@if (Request::segment(2)=='view') View @elseif (Request::segment(2)=='edit') Update @else New @endif Customer</h4>
        </div>
        <!--begin::Card title-->
        <!--begin::Card toolbar-->
        <div class="card-toolbar">
            <!--begin::Toolbar-->
            <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                <!--begin::Add new-->
                <a href="{{url('/customers/all')}}"><button type="button" class="btn btn-success" >Back<i class="fa fa-angle-left"></i></button></a>
                <!--end::Add new-->
            </div>
            <!--end::Toolbar-->
        </div>
        <!--end::Card toolbar-->
    </div>
    <form class="form" method="POST" @if (Request::segment(2)=='view') action="{{url('#')}}" @elseif (Request::segment(2)=='edit') action="{{url('/customers/update/'.$customer->id)}}" @else action="{{url('/customers/store')}}" @endif>
        @csrf
        <input type="hidden" name="lead_id" id="cust_lead_id">
        <div class="card-body">
            <div class="form-group row">
                <div class="col-lg-6">
                    <label class="required">Customer Name</label>
                    <input type="text"  id="customer_name" name="customer_name" class="form-control" required @if (Request::segment(2)=='view') value="{{$customer->customer_name}}" readonly @elseif (Request::segment(2)=='edit') value="{{$customer->customer_name}}" @else value="" @endif/>
                </div>
                <div class="col-lg-6">
                    <label>Email</label>
                    <input type="email" id="email" name="email" class="form-control" @if (Request::segment(2)=='view') value="{{$customer->email}}" readonly @elseif (Request::segment(2)=='edit') value="{{$customer->email}}" @else value="" @endif/>
                    {{-- <input type="hidden" id="cust_id" name="id" class="cus_lead_id form-control"/> --}}
                </div>
            </div><br>
            <div class="form-group row">
                <div class="col-lg-12">
                    <label class="required">Address</label>
                    <input type="text"  id="address" name="address" class="form-control" required @if (Request::segment(2)=='view') value="{{$customer->address}}" readonly @elseif (Request::segment(2)=='edit') value="{{$customer->address}}" @else value="" @endif/>
                </div>
            </div><br>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Telephone</label>
                    <input type="tel"  id="telephone" name="telephone" class="form-control" pattern="0[1,2,3,4,5,6,7,8,9][0,1,2,5,6,7,8][0-9]{7}"  maxlength="10" @if (Request::segment(2)=='view') value="{{$customer->telephone}}" readonly @elseif (Request::segment(2)=='edit') value="{{$customer->telephone}}" @else value="" @endif/>
                </div>
                <div class="col-lg-6">
                    <label>Mobile</label>
                    <input type="tel" id="mobile" name="mobile" class="form-control" pattern="0[1,2,3,4,5,6,7,8,9][0,1,2,5,6,7,8][0-9]{7}"  maxlength="10" @if (Request::segment(2)=='view') value="{{$customer->mobile}}" readonly @elseif (Request::segment(2)=='edit') value="{{$customer->mobile}}" @else value="" @endif/>
                    {{-- <input type="hidden" id="cust_id" name="id" class="cus_lead_id form-control"/> --}}
                </div>
            </div><br>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label class="required">Credit Limit</label>
                    <input type="text"  id="credit_limit" name="credit_limit" class="form-control" required @if (Request::segment(2)=='view') value="{{$customer->credit_limit}}" readonly @elseif (Request::segment(2)=='edit') value="{{$customer->credit_limit}}" @else value="" @endif/>
                </div>
                <div class="col-lg-6">
                    <label class="required">Open Balance</label>
                    <input type="text" id="open_balance" name="open_balance" class="form-control" required @if (Request::segment(2)=='view') value="{{$customer->open_balance}}" readonly @elseif (Request::segment(2)=='edit') value="{{$customer->open_balance}}" @else value="" @endif/>
                    {{-- <input type="hidden" id="cust_id" name="id" class="cus_lead_id form-control"/> --}}
                </div>
            </div><br>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label class="required">Current Balance</label>
                    <input type="text"  id="current_balance" name="current_balance" class="form-control" required @if (Request::segment(2)=='view') value="{{$customer->current_balance}}" readonly @elseif (Request::segment(2)=='edit') value="{{$customer->current_balance}}" @else value="" @endif/>
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
