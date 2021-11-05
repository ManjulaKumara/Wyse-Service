@extends('layouts.wyse')
@section('content')
<div class="row gx-5 gx-xl-8 mb-5 mb-xl-8">
    <!--begin::Col-->
    <div class="col-xl-4">
        <div class="card h-175px bgi-no-repeat bgi-size-cover card-xl-stretch mb-5 mb-xl-8 " style="background-color: #663259;background-position: calc(100% + 0.5rem) 100%;background-size: 100% auto;background-image:url('assets/media/svg/misc/taieri.svg')">
            <!--begin::Body-->
            <div class="card-body d-flex flex-column justify-content-between">
                <!--begin::Title-->
                <span class="svg-icon svg-icon-white svg-icon-2hx ms-n1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <rect x="2" y="2" width="9" height="9" rx="2" fill="black" />
                        <rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="black" />
                        <rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="black" />
                        <rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="black" />
                    </svg>
                </span>
                @php
                    $items=App\Models\Item::count();
                @endphp
                <!--end::Svg Icon-->
                <div class="text-inverse-primary fw-bolder fs-1 mb-2 mt-5">{{$items}}</div>
                <div class="fw-bold text-inverse-primary fs-2">Items Available</div>
                <!--begin::Action-->
            </div>
            <!--end::Body-->
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card h-175px bgi-no-repeat bgi-size-cover card-xl-stretch mb-5 mb-xl-8 " style="background-color: #746a71;background-position: calc(100% + 0.5rem) 100%;background-size: 100% auto;background-image:url('assets/media/svg/misc/taieri.svg')">
            <!--begin::Body-->
            <div class="card-body d-flex flex-column justify-content-between">
                <!--begin::Title-->
                <span class="svg-icon svg-icon-white svg-icon-2hx ms-n1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <rect x="2" y="2" width="9" height="9" rx="2" fill="black" />
                        <rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="black" />
                        <rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="black" />
                        <rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="black" />
                    </svg>
                </span>
                @php
                    $customers=App\Models\Customer::count();
                @endphp
                <!--end::Svg Icon-->
                <div class="text-inverse-primary fw-bolder fs-1 mb-2 mt-5">{{$customers}}</div>
                <div class="fw-bold text-inverse-primary fs-2">Registered Customers</div>
                <!--begin::Action-->
            </div>
            <!--end::Body-->
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card h-175px bgi-no-repeat bgi-size-cover card-xl-stretch mb-5 mb-xl-8 " style="background-color: #4399d3;background-position: calc(100% + 0.5rem) 100%;background-size: 100% auto;background-image:url('assets/media/svg/misc/taieri.svg')">
            <!--begin::Body-->
            <div class="card-body d-flex flex-column justify-content-between">
                <!--begin::Title-->
                <span class="svg-icon svg-icon-white svg-icon-2hx ms-n1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <rect x="2" y="2" width="9" height="9" rx="2" fill="black" />
                        <rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="black" />
                        <rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="black" />
                        <rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="black" />
                    </svg>
                </span>
                @php
                    $suppliers=App\Models\Supplier::count();
                @endphp
                <!--end::Svg Icon-->
                <div class="text-inverse-primary fw-bolder fs-1 mb-2 mt-5">{{$suppliers}}</div>
                <div class="fw-bold text-inverse-primary fs-2">Registered Suppliers</div>
                <!--begin::Action-->
            </div>
            <!--end::Body-->
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card h-175px bgi-no-repeat bgi-size-cover card-xl-stretch mb-5 mb-xl-8 " style="background-color: #3bd495;background-position: calc(100% + 0.5rem) 100%;background-size: 100% auto;background-image:url('assets/media/svg/misc/taieri.svg')">
            <!--begin::Body-->
            <div class="card-body d-flex flex-column justify-content-between">
                <!--begin::Title-->
                <span class="svg-icon svg-icon-white svg-icon-2hx ms-n1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <rect x="2" y="2" width="9" height="9" rx="2" fill="black" />
                        <rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="black" />
                        <rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="black" />
                        <rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="black" />
                    </svg>
                </span>
                @php
                    $date=new DateTime();
                    $date=$date->format('Y-m-d');
                    $invoices=App\Models\InvoiceHeader::where('created_at','like',$date.'%')->sum('net_amount');
                @endphp
                <!--end::Svg Icon-->
                <div class="text-inverse-primary fw-bolder fs-1 mb-2 mt-5">{{number_format($invoices,2)}}</div>
                <div class="fw-bold text-inverse-primary fs-2">Today's Sales</div>
                <!--begin::Action-->
            </div>
            <!--end::Body-->
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card h-175px bgi-no-repeat bgi-size-cover card-xl-stretch mb-5 mb-xl-8 " style="background-color: #d4a33b;background-position: calc(100% + 0.5rem) 100%;background-size: 100% auto;background-image:url('assets/media/svg/misc/taieri.svg')">
            <!--begin::Body-->
            <div class="card-body d-flex flex-column justify-content-between">
                <!--begin::Title-->
                <span class="svg-icon svg-icon-white svg-icon-2hx ms-n1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <rect x="2" y="2" width="9" height="9" rx="2" fill="black" />
                        <rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="black" />
                        <rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="black" />
                        <rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="black" />
                    </svg>
                </span>
                @php
                    $date=new DateTime();
                    $date=$date->format('Y-m-d');
                    $cheques=App\Models\CustomerCheque::where('banked_date','like',$date.'%')->count();
                @endphp
                <!--end::Svg Icon-->
                <div class="text-inverse-primary fw-bolder fs-1 mb-2 mt-5">{{$cheques}}</div>
                <div class="fw-bold text-inverse-primary fs-2">Cheques to be deposited</div>
                <!--begin::Action-->
            </div>
            <!--end::Body-->
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card h-175px bgi-no-repeat bgi-size-cover card-xl-stretch mb-5 mb-xl-8 " style="background-color: #a93bd4;background-position: calc(100% + 0.5rem) 100%;background-size: 100% auto;background-image:url('assets/media/svg/misc/taieri.svg')">
            <!--begin::Body-->
            <div class="card-body d-flex flex-column justify-content-between">
                <!--begin::Title-->
                <span class="svg-icon svg-icon-white svg-icon-2hx ms-n1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <rect x="2" y="2" width="9" height="9" rx="2" fill="black" />
                        <rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="black" />
                        <rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="black" />
                        <rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="black" />
                    </svg>
                </span>
                @php
                    $date=new DateTime();
                    $date=$date->format('Y-m-d');
                    $cheques=App\Models\SupplierCheque::where('cheque_date','like',$date.'%')->count();
                @endphp
                <!--end::Svg Icon-->
                <div class="text-inverse-primary fw-bolder fs-1 mb-2 mt-5">{{$cheques}}</div>
                <div class="fw-bold text-inverse-primary fs-2">Cheques issued for today in vouchers</div>
                <!--begin::Action-->
            </div>
            <!--end::Body-->
        </div>
    </div>
</div>
@endsection
