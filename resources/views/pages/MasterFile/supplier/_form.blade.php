@extends('layouts.wyse')
@section('content')
<div class="card">
    <div class="card-header border-0 pt-6">
        <!--begin::Card title-->
        <div class="card-title">
            <h4>New Supplier</h4>
        </div>
        <!--begin::Card title-->
        <!--begin::Card toolbar-->
        <div class="card-toolbar">
            <!--begin::Toolbar-->
            <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                <!--begin::Add new-->
                <a href="{{url('/suppliers/all')}}"><button type="button" class="btn btn-success" >Back<i class="fa fa-angle-left"></i></button></a>
                <!--end::Add new-->
            </div>
            <!--end::Toolbar-->
        </div>
        <!--end::Card toolbar-->
    </div>
    <form class="form" method="POST" action="{{url('/suppliers/store')}}">
        @csrf
        <input type="hidden" name="lead_id" id="cust_lead_id">
        <div class="card-body">
            <div class="form-group row">
                <div class="col-lg-6">
                    <label class="required">Supplier Name</label>
                    <input type="text"  id="supplier_name" name="supplier_name" class="form-control" required/>
                </div>
                <div class="col-lg-6">
                    <label class="required">Email</label>
                    <input type="email" id="email" name="email" required class="form-control"/>
                    {{-- <input type="hidden" id="cust_id" name="id" class="cus_lead_id form-control"/> --}}
                </div>
            </div><br>
            <div class="form-group row">
                <div class="col-lg-12">
                    <label class="required">Address</label>
                    <input type="text"  id="address" name="address" class="form-control" required/>
                </div>
            </div><br>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label class="required">Telephone</label>
                    <input type="tel"  id="telephone" name="telephone" class="form-control" required/>
                </div>
                <div class="col-lg-6">
                    <label>Mobile</label>
                    <input type="tel" id="mobile" name="mobile" class="form-control"/>
                    {{-- <input type="hidden" id="cust_id" name="id" class="cus_lead_id form-control"/> --}}
                </div>
            </div><br>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label class="required">Credit Limit</label>
                    <input type="text"  id="credit_limit" name="credit_limit" class="form-control" required/>
                </div>
                <div class="col-lg-6">
                    <label class="required">Open Balance</label>
                    <input type="text" id="open_balance" name="open_balance" class="form-control" required/>
                    {{-- <input type="hidden" id="cust_id" name="id" class="cus_lead_id form-control"/> --}}
                </div>
            </div><br>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label class="required">Current Balance</label>
                    <input type="text"  id="current_balance" name="current_balance" class="form-control" required/>
                </div>
            </div><br>
            <div class="form-group row">
                <div class="col-lg-6"></div>
                <div class="col-lg-6" style="text-align-last: right" id="create_button">
                    <button type="reset" type="reset" id="resetBtn" class="btn btn-secondary btn-lg mr-3">
                        <i class="fas fa-redo"></i> Reset
                    </button>
                    <button type="submit" class="btn btn-primary btn-lg mr-3">
                        <i class="fas fa-save"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
