@extends('layouts.wyse')
@section('content')
<div class="card">
    <div class="card-header border-0 pt-6">
        <!--begin::Card title-->
        <div class="card-title">
            <h4>Sales Return</h4>
        </div>
        <!--begin::Card title-->
        <!--begin::Card toolbar-->
        <div class="card-toolbar">
            <!--begin::Toolbar-->
            <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                <!--begin::Add new-->
                <a href="{{url('/sales-return/all')}}"><button type="button" class="btn btn-success" >Back<i class="fa fa-angle-left"></i></button></a>
                <!--end::Add new-->
            </div>
            <!--end::Toolbar-->
        </div>
        <!--end::Card toolbar-->
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
            </div>
            <div class="col-md-6">
                <h3 style="text-align: right">Return Date : {{$return_header->created_at->format('Y-m-d')}}</h3>
            </div>
        </div>
        <div class="separator separator-dashed my-10"></div>
        <div class="form-group row">
            <div class="col-lg-6">
                <label>Sales Return No</label>
                <input type="text"  id="return_number" name="return_number" value="{{$return_header->return_number}}" class="form-control" required readonly/>
            </div>
            <div class="col-lg-6">
                <label>Invoice No</label>
                <input type="text" id="invoice_no" name="invoice_no" value="{{$return_header->invoice_number}}" class="form-control" readonly/>
            </div>
        </div><br>
        <div class="form-group row">
            <div class="col-lg-6">
                <label>Sales Return Amount</label>
                <input type="text"  id="return_amount" name="return_amount" value="{{$return_header->return_amount}}" class="form-control" required readonly/>
            </div>
            <div class="col-lg-6">
                <label>Cashier</label>
                <input type="text" id="cashier" name="cashier" value="{{$user->name}}" class="form-control" readonly/>
            </div>
        </div>
        <div class="separator separator-dashed my-10"></div>
        <div class="table-responsive mb-10">
            <!--begin::Table-->
            <table class="table g-5 gs-0 mb-0 fw-bolder text-gray-700" id="tbl-items">
                <!--begin::Table head-->
                <thead>
                    <tr class="border-bottom fs-7 fw-bolder text-gray-700 text-uppercase">
                        <th class="min-w-300px w-475px">Item</th>
                        <th class="min-w-150px w-150px">Unit Price</th>
                        <th class="min-w-100px w-100px">QTY</th>
                        <th class="min-w-100px w-150px text-end">Total</th>
                    </tr>
                </thead>
                <!--end::Table head-->
                <!--begin::Table body-->
                <tbody>
                    @foreach ($return_details as $item)
                    <tr class="border-bottom fs-7 fw-bolder text-gray-700 text-uppercase">
                        <td>{{$item->item_name}}</td>
                        <td>{{$item->unit_price}}</td>
                        <td>{{$item->qty}}</td>
                        <td class="min-w-100px w-150px text-end">{{$item->amount}}</td>
                    </tr>
                    @endforeach
                </tbody>
                <!--end::Table body-->
            </table>
        </div>
    </div>
</div>
@endsection
