@extends('layouts.wyse')
@section('optional_css')
<link href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<!--begin::Entry-->
<div class="d-flex flex-column-fluid">

    <!--begin::Container-->
    <div class="container-fluid">
        <div class="d-lg-flex flex-row-fluid">
            <div class="content-wrapper flex-row-fluid">
                <div class="card " style="width: 1320px;">
                    <div class="card-header">
                        <div class="card-title">
                            <span class="card-icon">
                                <img src="https://www.water.lk/assets/img/logo.png" style="max-height: 55px;">
                            </span>
                        </div>
                        <div class="card-toolbar">

                            {{-- @include('buttons.add_new') --}}

                        </div>
                    </div>
                    <div class="card-body">
                        <div data-scroll="true" data-height="200">
                            <div class="card-scroll">
                                <table id="table" class="table table-separate table-head-custom table-checkable display compact" style="width:100%" data-order='[[ 1, "asc" ]]' data-page-length='25'>
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Customer Name</th>
                                            <th>Contact Person</th>
                                            <th>Telephone</th>
                                            <th>Email</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        {{-- <a href="#" class="btn btn-light-primary font-weight-bold">Manage</a> --}}
                        {{-- <a href="#" class="btn btn-outline-secondary font-weight-bold">Learn more</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--end::Container-->
    </div>

    <!--end::Entry-->
@endsection
