@extends('layouts.wyse')
@section('optional_css')
<link href="{{url('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
<div class="card">
    <div class="card-header border-0 pt-6">
        <!--begin::Card title-->
        <div class="card-title">
            <h4>@if (Request::segment(2)=='view') View @elseif (Request::segment(2)=='edit') Update @else New @endif Module</h4>
        </div>
        <!--begin::Card title-->
        <!--begin::Card toolbar-->
        <div class="card-toolbar">
            <!--begin::Toolbar-->
            <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                <!--begin::Add new-->
                <a href="{{url('/module/all')}}"><button type="button" class="btn btn-success" >Back<i class="fa fa-angle-left"></i></button></a>
                <!--end::Add new-->
            </div>
            <!--end::Toolbar-->
        </div>
        <!--end::Card toolbar-->
    </div>
    <form class="form" method="POST" @if (Request::segment(2)=='view') action="{{url('#')}}" @elseif (Request::segment(2)=='edit') action="{{url('/module/update/'.$module->id)}}" @else action="{{url('/module/store')}}" @endif>
        @csrf
        <input type="hidden" name="lead_id" id="cust_lead_id">
        <div class="card-body">
            <div class="form-group row">
                <div class="col-lg-6">
                    <label class="required">Module Code</label>
                    <input type="text"  id="md_code" name="md_code" class="form-control" required @if (Request::segment(2)=='view') value="{{$module->md_code}}" readonly @elseif (Request::segment(2)=='edit') value="{{$module->md_code}}" @else value="" @endif/>
                </div>
                <div class="col-lg-6">
                    <label class="required">Module Name</label>
                    <input type="text" id="md_name" name="md_name" required class="form-control" @if (Request::segment(2)=='view') value="{{$module->md_name}}" readonly @elseif (Request::segment(2)=='edit') value="{{$module->md_name}}" @else value="" @endif/>
                    {{-- <input type="hidden" id="cust_id" name="id" class="cus_lead_id form-control"/> --}}
                </div>
            </div><br>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label class="required">Module Group</label>
                    <input type="number"  id="md_group" name="md_group" class="form-control" required @if (Request::segment(2)=='view') value="{{$module->md_group}}" readonly @elseif (Request::segment(2)=='edit') value="{{$module->md_group}}" @else value="" @endif/>
                </div>
                <div class="col-lg-6">
                    <label class="required">Url Slug</label>
                    <input type="text"  id="url" name="url" class="form-control" required @if (Request::segment(2)=='view') value="{{$module->url}}" readonly @elseif (Request::segment(2)=='edit') value="{{$module->url}}" @else value="" @endif/>
                </div>
            </div><br>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label class="required">Status</label>
                    <div class="radio-inline">
                        <label class="radio radio-solid">
                            <input type="radio" id="status" name="is_active" checked="checked" value="1" @if (Request::segment(2)=='view') disabled @if ($module->is_active==1) checked="checked" @endif @elseif (Request::segment(2)=='edit') @if ($module->is_active==1) checked="checked" @endif @else  checked="checked"  @endif/>
                            <span></span>
                            Active
                            </label>
                        <label class="radio radio-solid">
                            <input type="radio" id="status" name="is_active" value="0" @if (Request::segment(2)=='view') disabled @if ($module->is_active==0) checked="checked" @endif @elseif (Request::segment(2)=='edit') @if ($module->is_active==0) checked="checked" @endif @endif/>
                            <span></span>
                            InActive
                        </label>
                    </div>
                    <span class="form-text text-muted">Please select status</span>
                </div>
            </div><br>
            <div class="separator separator-dashed my-5"></div>
            <div class="form-group row">
                <div class="col-lg-2">
                    <label>Can Read</label>
                    <div class="input-group">
                        <span class="switch switch-sm switch-icon">
                                <input type="checkbox" name="can_read" id="can_read" value="1" @if (Request::segment(2)=='view') disabled @if ($module->can_read=='on') checked="checked" @endif @elseif (Request::segment(2)=='edit') @if ($module->can_read=='on') checked="checked" @endif @endif/>
                        </span>
                    </div>
                </div>
                <div class="col-lg-2">
                    <label>Can Create</label>
                    <div class="input-group">
                        <span class="switch switch-sm switch-icon">
                            <label>
                                <input type="checkbox" name="can_create" id="can_create" value="1" @if (Request::segment(2)=='view') disabled @if ($module->can_create=='on') checked="checked" @endif @elseif (Request::segment(2)=='edit') @if ($module->can_create=='on') checked="checked" @endif @endif/>
                                <span></span>
                            </label>
                        </span>
                    </div>
                </div>
                <div class="col-lg-2">
                    <label>Can Update</label>
                    <div class="input-group">
                        <span class="switch switch-sm switch-icon">
                            <label>
                                <input type="checkbox" name="can_update" id="can_update" value="1" @if (Request::segment(2)=='view') disabled @if ($module->can_update=='on') checked="checked" @endif @elseif (Request::segment(2)=='edit') @if ($module->can_update=='on') checked="checked" @endif @endif/>
                                <span></span>
                            </label>
                        </span>
                    </div>
                </div>
                <div class="col-lg-2">
                    <label>Can Delete</label>
                    <div class="input-group">
                        <span class="switch switch-sm switch-icon">
                            <label>
                                <input type="checkbox" name="can_delete" id="can_delete" value="1" @if (Request::segment(2)=='view') disabled @if ($module->can_delete=='on') checked="checked" @endif @elseif (Request::segment(2)=='edit') @if ($module->can_delete=='on') checked="checked" @endif @endif/>
                                <span></span>
                            </label>
                        </span>
                    </div>
                </div>
            </div>
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
