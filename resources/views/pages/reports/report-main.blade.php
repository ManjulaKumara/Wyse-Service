@extends('layouts.wyse')
@section('optional_css')
<link href="{{url('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')

<div>
    <!--begin::Content-->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <!--begin::Card body-->
                <div class="card-body p-12">
                    <div class="row">
                        <h3>Daily Summary</h3>
                    </div>
                    <div class="separator separator-dashed my-10"></div>
                    <!--begin::Form-->
                    {{-- <form action="" id="kt_invoice_form"> --}}
                        <div class="mb-0">
                            <div class="row">
                                <form action="{{url('/reports/daily-summary')}}" method="POST">
                                    @csrf
                                <div class="col-md-12">
                                    <!--end::Top-->

                                    <div class="row gx-10 mb-5">

                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-lg-10">
                                            <label class="form-label fs-6 fw-bolder text-gray-700 mb-3">Date</label>
                                            <!--begin::Input group-->
                                            <div class="mb-5">
                                                <input type="date" id="summary_date" name="summary_date" required class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <button type="submit" style="margin-top:25px;" class="btn btn-success">View</button>
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Table-->
                                </div>
                                </form>
                            </div>

                    {{-- </form>
                    <!--end::Form--> --}}
                </div>
                <!--end::Card body-->
            </div>
        </div>
    </div>
        <div class="col-md-6">
            <div class="card">
                <!--begin::Card body-->
                <div class="card-body p-12">
                    <div class="row">
                        <h3>Bin Card</h3>
                    </div>
                    <div class="separator separator-dashed my-10"></div>
                    <!--begin::Form-->
                    {{-- <form action="" id="kt_invoice_form"> --}}
                        <div class="mb-0">
                            <div class="row">
                                <form action="{{url('/reports/bin-card')}}" method="POST">
                                    @csrf
                                <div class="col-md-12">
                                    <!--end::Top-->

                                    <div class="row gx-10 mb-5">

                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-lg-10">
                                            <label class="form-label fs-6 fw-bolder text-gray-700 mb-3">Item</label>
                                            <!--begin::Input group-->
                                            <div class="mb-5">
                                                <select required class="form-select" name="item" id="item" data-control="select2" data-placeholder="Select an option">
                                                    <option value="">Select an Item</option>
                                                    @foreach ($items as $item )
                                                    <option value="{{$item->id}}">{{$item->item_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <button type="submit" style="margin-top:25px;" class="btn btn-success">View</button>
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Table-->
                                </div>
                                </form>
                            </div>

                    {{-- </form>
                    <!--end::Form--> --}}
                </div>
                <!--end::Card body-->
            </div>
        </div>
</div>
    </div>
</div>
</div>


<div class="container mb-15">
    <!--begin::Content-->
    <div class="row">

    </div>
</div>
</div>

<div class="container mb-15">
    <!--begin::Content-->
    <div class="row">
        <div class="card">
            <!--begin::Card body-->
            <div class="card-body p-12">
                <div class="row">
                    <h3>Sales Report</h3>
                </div>
                <div class="separator separator-dashed my-10"></div>
                <!--begin::Form-->
                {{-- <form action="" id="kt_invoice_form"> --}}
                    <div class="mb-0">
                        <div class="row">
                            <form action="{{url('/reports/sales-report')}}" method="POST">
                                @csrf
                            <div class="col-md-12">
                                <!--end::Top-->

                                <div class="row gx-10 mb-5">

                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col-lg-5">
                                        <label class="form-label fs-6 fw-bolder text-gray-700 mb-3">From Date:</label>
                                        <!--begin::Input group-->
                                        <div class="mb-5">
                                            <input type="date" id="from_date" name="from_date" required class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <label class="form-label fs-6 fw-bolder text-gray-700 mb-3">To Date:</label>
                                        <!--begin::Input group-->
                                        <div class="mb-5">
                                            <input type="date" id="to_date" name="to_date" required class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-lg-1">
                                        <button type="submit" style="margin-top:25px;" class="btn btn-success">View</button>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Table-->
                            </div>
                            </form>
                        </div>

                {{-- </form>
                <!--end::Form--> --}}
            </div>
            <!--end::Card body-->
        </div>
    </div>
</div>
</div>
<div class="container mb-15">
    <!--begin::Content-->
    <div class="row">
        <div class="card">
            <!--begin::Card body-->
            <div class="card-body p-12">
                <div class="row">
                    <h3>Sales Summary</h3>
                </div>
                <div class="separator separator-dashed my-10"></div>
                <!--begin::Form-->
                {{-- <form action="" id="kt_invoice_form"> --}}
                    <div class="mb-0">
                        <div class="row">
                            <form action="{{url('/reports/sales-summary')}}" method="POST">
                                @csrf
                            <div class="col-md-12">
                                <!--end::Top-->

                                <div class="row gx-10 mb-5">

                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col-lg-5">
                                        <label class="form-label fs-6 fw-bolder text-gray-700 mb-3">From Date:</label>
                                        <!--begin::Input group-->
                                        <div class="mb-5">
                                            <input type="date" id="from_date" name="from_date" required class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <label class="form-label fs-6 fw-bolder text-gray-700 mb-3">To Date:</label>
                                        <!--begin::Input group-->
                                        <div class="mb-5">
                                            <input type="date" id="to_date" name="to_date" required class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-lg-1">
                                        <button type="submit" style="margin-top:25px;" class="btn btn-success">View</button>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Table-->
                            </div>
                            </form>
                        </div>

                {{-- </form>
                <!--end::Form--> --}}
            </div>
            <!--end::Card body-->
        </div>
    </div>
</div>
</div>

<div class="container mb-15">
    <!--begin::Content-->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <!--begin::Card body-->
                <div class="card-body p-12">

                    <div class="row">
                        <div class="col-md-6">
                            <h3>Price List</h3>
                        </div>
                        <div class="col-md-6">
                            <a class="btn btn-success" style="float: right;" href="{{url('/reports/price-list')}}">View</a>
                        </div>

                    </div>
                    <div class="mb-0">

                    {{-- </form>
                    <!--end::Form--> --}}
                </div>
                <!--end::Card body-->
            </div>
        </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <!--begin::Card body-->
                <div class="card-body p-12">

                    <div class="row">
                        <div class="col-md-6">
                            <h3>Stock Report</h3>
                        </div>
                        <div class="col-md-6">
                            <a class="btn btn-success" style="float: right;" href="{{url('/reports/stock-report')}}">View</a>
                        </div>

                    </div>
                    <div class="mb-0">

                    {{-- </form>
                    <!--end::Form--> --}}
                </div>
                <!--end::Card body-->
            </div>
        </div>
        </div>
    </div>
</div>

@endsection
@section('opyional_js')
<script src="{{url('assets/plugins/global/plugins.bundle.js')}}"></script>
<script>
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
    $('#item').change(function(){
        if($('#item').val()!="" && $('#item').val!=null){

        }
    });
</script>
@endsection
