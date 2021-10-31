@extends('layouts.wyse')
@section('content')
<div class="card">
    <div class="card-header border-0 pt-6">
        <!--begin::Card title-->
        <div class="card-title">
            <h4>@if (Request::segment(2)=='view') View @elseif (Request::segment(2)=='edit') Update @else New @endif User Role</h4>
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
    <form class="form" method="POST" @if (Request::segment(2)=='view') action="{{url('#')}}" @elseif (Request::segment(2)=='edit') action="{{url('/user-role/update/'.$user_role->id)}}" @else action="{{url('user-role/store')}}" @endif>
        @csrf
        <input type="hidden" name="lead_id" id="cust_lead_id">
        <div class="card-body">
            <div class="form-group row">
                <div class="col-lg-6">
                    <label class="required">Role Code</label>
                    <input type="text"  id="role_code" name="role_code" class="form-control" required @if (Request::segment(2)=='view') value="{{$user_role->role_code}}" readonly @elseif (Request::segment(2)=='edit') value="{{$user_role->role_code}}" @else value="" @endif/>
                </div>
                <div class="col-lg-6">
                    <label class="required">User Role Name</label>
                    <input type="text" id="role_name" name="role_name" required class="form-control" @if (Request::segment(2)=='view') value="{{$user_role->role_name}}" readonly @elseif (Request::segment(2)=='edit') value="{{$user_role->role_name}}" @else value="" @endif/>
                    {{-- <input type="hidden" id="cust_id" name="id" class="cus_lead_id form-control"/> --}}
                </div>
            </div><br>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label class="required">Status</label>
                    <div class="radio-inline">
                        <label class="radio radio-solid">
                            <input type="radio" id="status" name="is_active" value="1" @if (Request::segment(2)=='view') disabled @if ($user_role->is_active==1) checked="checked" @endif @elseif (Request::segment(2)=='edit') @if ($user_role->is_active==1) checked="checked" @endif @else  checked="checked"  @endif/>
                            <span></span>
                            Active
                            </label>
                        <label class="radio radio-solid">
                            <input type="radio" id="status" name="is_active" value="0" @if (Request::segment(2)=='view') disabled @if ($user_role->is_active==0) checked="checked" @endif @elseif (Request::segment(2)=='edit') @if ($user_role->is_active==0) checked="checked" @endif @else value="" @endif/>
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
