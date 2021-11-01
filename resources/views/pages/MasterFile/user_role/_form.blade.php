@extends('layouts.wyse')
@section('content')
@php
    if (Request::segment(2)=='view'||Request::segment(2)=='edit') {
        $elements=DB::table('user_role_permissions')->join('modules','user_role_permissions.md_code','=','modules.md_code')
            ->select('user_role_permissions.*','modules.md_name as module_name','modules.can_create as can_createM','modules.can_read as can_readM','modules.can_update as can_updateM','modules.can_delete as can_deleteM')
            ->where('user_role_permissions.role_id',$user_role->id)
            ->get();
    } else {
        $elements =DB::table('modules')->where('md_code','<>','modules')->orderBy('id')->get();
    }

@endphp
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
            <div class="separator separator-dashed my-5"></div>
            <div class="col-lg-12" >
                <table class="table" id="user_permission" style="overflow: scroll !important;display: block;">
                    <thead>
                        <tr>
                            <th scope="col">Module</th>
                            <th scope="col">Is Enable</th>
                            <th scope="col">Can Read</th>
                            <th scope="col">Can Create</th>
                            <th scope="col">Can Update</th>
                            <th scope="col">Can Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($elements as $key => $element)
                            <tr>
                                <td scope="row" style="width: 30%">
                                    @if (Request::segment(2)=='view'||Request::segment(2)=='edit')
                                    {{$element->module_name}}
                                    @else
                                    {{$element->md_name}}
                                    @endif
                                    <input type="hidden" name="{{'element['.$element->id.'][0][]'}}" value="{{$element->md_code}}">
                                    <input type="hidden" name="{{'element['.$element->id.'][1][]'}}" value="{{$element->md_group}}">
                                </td>
                                <td>
                                    <span class="switch switch-sm switch-icon">
                                        <label>
                                            <input id="enable{{$element->id}}" name="{{'element['.$element->id.'][2][]'}}" type="checkbox"  @if (Request::segment(2)=='view') @if(isset($element))  @if($element->is_enable=='1') checked @endif @endif disabled @elseif (Request::segment(2)=='edit') @if(isset($element))  @if($element->is_enable=='1') checked @endif @endif @else @if(isset($element))  @if($element->is_active=='1') checked @endif @endif @endif/>
                                            <span></span>
                                        </label>
                                    </span>
                                </td>
                                <td>
                                    <span class="switch switch-sm switch-icon">
                                        <label>
                                            <input type="checkbox" id="read{{$element->id}}" name="{{'element['.$element->id.'][3][]'}}" @if (Request::segment(2)=='view') @if(isset($element)) @if($element->can_readM=='off') disabled @endif @if($element->can_read=='1') checked @endif @endif  disabled @elseif (Request::segment(2)=='edit') @if(isset($element)) @if($element->can_readM=='off') disabled @endif @if($element->can_read=='1') checked @endif @endif @else @if(isset($element))  @if($element->can_read=='off') disabled @endif @endif @endif/>
                                            <span></span>
                                        </label>
                                    </span>
                                </td>
                                <td>
                                    <span class="switch switch-sm switch-icon">
                                        <label>
                                            <input type="checkbox" id="create{{$element->id}}" name="{{'element['.$element->id.'][4][]'}}" @if (Request::segment(2)=='view') @if(isset($element)) @if($element->can_createM=='off') disabled @endif @if($element->can_create=='1') checked @endif @endif disabled @elseif (Request::segment(2)=='edit') @if(isset($element)) @if($element->can_createM=='off') disabled @endif @if($element->can_create=='1') checked @endif @endif @else @if(isset($element))  @if($element->can_create=='off') disabled @endif @endif @endif/>
                                            <span></span>
                                        </label>
                                    </span>
                                </td>
                                <td>
                                    <span class="switch switch-sm switch-icon">
                                        <label>
                                            <input type="checkbox" id="update{{$element->id}}" name="{{'element['.$element->id.'][5][]'}}" @if (Request::segment(2)=='view') @if(isset($element)) @if($element->can_updateM=='off') disabled @endif  @if($element->can_update=='1') checked @endif @endif disabled @elseif (Request::segment(2)=='edit') @if(isset($element)) @if($element->can_updateM=='off') disabled @endif  @if($element->can_update=='1') checked @endif @endif @else @if(isset($element))  @if($element->can_update=='off') disabled @endif @endif @endif/>
                                            <span></span>
                                        </label>
                                    </span>
                                </td>
                                <td>
                                    <span class="switch switch-sm switch-icon">
                                        <label>
                                            <input type="checkbox" id="delete{{$element->id}}" name="{{'element['.$element->id.'][6][]'}}" @if (Request::segment(2)=='view') @if(isset($element))  @if($element->can_deleteM=='off') disabled @endif @if($element->can_delete=='1') checked @endif @endif disabled @elseif (Request::segment(2)=='edit') @if(isset($element))  @if($element->can_deleteM=='off') disabled @endif @if($element->can_delete=='1') checked @endif @endif @else @if(isset($element))  @if($element->can_delete=='off') disabled @endif @endif @endif/>
                                            <span></span>
                                        </label>
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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
