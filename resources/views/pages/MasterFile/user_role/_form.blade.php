@extends('layouts.wyse')
@section('content')
<div class="card">
    <div class="card-header border-0 pt-6">
        <!--begin::Card title-->
        <div class="card-title">
            <h4>New User Role</h4>
        </div>
        <!--begin::Card title-->
        <!--begin::Card toolbar-->
        <div class="card-toolbar">
            <!--begin::Toolbar-->
            <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                <!--begin::Add new-->
                <a href="{{url('user-role/all')}}"><button type="button" class="btn btn-success" >Back<i class="fa fa-angle-left"></i></button></a>
                <!--end::Add new-->
            </div>
            <!--end::Toolbar-->
        </div>
        <!--end::Card toolbar-->
    </div>
    <form class="form" id="customer_info" method="POST" action="{{url('user-role/store')}}">
        @csrf
        <input type="hidden" name="lead_id" id="cust_lead_id">
        <div class="card-body">
            <div class="form-group row">
                <div class="col-lg-6">
                    <label class="required">Role Code</label>
                    <input type="text"  id="role_code" name="role_code" class="form-control" required/>
                </div>
                <div class="col-lg-6">
                    <label class="required">User Role Name</label>
                    <input type="text" id="role_name" name="role_name" required class="form-control"/>
                    {{-- <input type="hidden" id="cust_id" name="id" class="cus_lead_id form-control"/> --}}
                </div>
            </div><br>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label class="required">Status</label>
                    <div class="radio-inline">
                        <label class="radio radio-solid">
                            <input type="radio" id="status" name="is_active" checked="checked" value="1"/>
                            <span></span>
                            Active
                            </label>
                        <label class="radio radio-solid">
                            <input type="radio" id="status" name="is_active" value="0"/>
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
