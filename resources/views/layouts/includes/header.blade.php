<!--begin::Header-->
<div id="kt_header" style="" class="header bg-white align-items-stretch">
    <!--begin::Container-->
    <div class="container-fluid d-flex align-items-stretch justify-content-between">
        <!--begin::Aside mobile toggle-->
        <div class="d-flex align-items-center d-lg-none ms-n3 me-1" title="Show aside menu">
            <div class="btn btn-icon btn-active-color-primary w-40px h-40px" id="kt_aside_toggle">
                <!--begin::Svg Icon | path: icons/duotune/abstract/abs015.svg-->
                <span class="svg-icon svg-icon-2x mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z" fill="black" />
                        <path opacity="0.3" d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z" fill="black" />
                    </svg>
                </span>
                <!--end::Svg Icon-->
            </div>
        </div>
        <!--end::Aside mobile toggle-->
        <!--begin::Mobile logo-->
        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
            <a href="{{url('/')}}" class="d-lg-none">
                <img alt="Logo" src="{{url('assets/media/logos/wyse_logo.png')}}" class="h-30px" />
            </a>
        </div>
        <!--end::Mobile logo-->
        <div class="d-flex align-items-center" id="kt_header_wrapper">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-lg-20 pb-2 pb-lg-0" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_wrapper'}">
                <!--begin::Heading-->
                <h1 class="text-dark fw-bolder my-1 fs-3 lh-1">Dashboard</h1>
                <!--end::Heading-->
            </div>
            <!--end::Page title=-->
        </div>
        <!--begin::Wrapper-->
        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
            <!--begin::Navbar-->
            <div class="d-flex align-items-stretch" id="kt_header_nav">
                <!--begin::Menu wrapper-->
                <div class="header-menu align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_header_menu_mobile_toggle" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav'}">
                    <!--begin::Menu-->
                    <div class="menu menu-lg-rounded menu-column menu-lg-row menu-state-bg menu-title-gray-600 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-400 fw-bold fs-6 my-5 my-lg-0 align-items-stretch" id="#kt_header_menu" data-kt-menu="true">
                        <div data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion me-lg-1">
                            <a class="menu-link py-3">
                                <span class="menu-title">Masterfiles</span>
                                <span class="menu-arrow d-lg-none"></span>
                            </a>
                            <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-rounded-0 py-lg-4 w-lg-225px">
                                <div class="menu-item">
                                    <a class="menu-link py-3" href="{{url('/user/all')}}">
                                        <span class="menu-title">Users</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link py-3" href="{{url('/customers/all')}}">
                                        <span class="menu-title">Customers</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link py-3" href="{{url('/suppliers/all')}}">
                                        <span class="menu-title">Suppliers</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link py-3" href="{{url('/items/all')}}">
                                        <span class="menu-title">Item Master</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link py-3" href="{{url('/services/all')}}">
                                        <span class="menu-title">Service Master</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link py-3" href="{{url('/item-category/all')}}">
                                        <span class="menu-title">Item Category</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link py-3" href="{{url('/user-role/all')}}">
                                        <span class="menu-title">User Roles</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion me-lg-1">
                            <a class="menu-link py-3">
                                <span class="menu-title">Sales</span>
                                <span class="menu-arrow d-lg-none"></span>
                            </a>
                            <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-rounded-0 py-lg-4 w-lg-225px">
                                <div class="menu-item">
                                    <a class="menu-link py-3" href="{{url('/sales/create')}}">
                                        <span class="menu-title">Create Invoice</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link py-3" href="{{url('/sales-returns/create')}}">
                                        <span class="menu-title">Sales Return</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link py-3" href="{{url('sales/all')}}">
                                        <span class="menu-title">Invoices Issued</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link py-3" href="{{url('/customer-receipts/create')}}">
                                        <span class="menu-title">Customer Receipt</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion me-lg-1">
                            <a class="menu-link py-3">
                                <span class="menu-title">Purchases</span>
                                <span class="menu-arrow d-lg-none"></span>
                            </a>
                            <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-rounded-0 py-lg-4 w-lg-225px">
                                <div class="menu-item">
                                    <a class="menu-link py-3" href="{{url('grns/create')}}">
                                        <span class="menu-title">Create GRN</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link py-3" href=".{{url('/')}}">
                                        <span class="menu-title">Purchase Return</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link py-3" href="{{url('/grns/all')}}">
                                        <span class="menu-title">Purchase List</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link py-3" href="{{url('/supplier-vouchers/create')}}">
                                        <span class="menu-title">Supplier Vouchers</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion me-lg-1">
                            <a class="menu-link py-3">
                                <span class="menu-title">Stock Operations</span>
                                <span class="menu-arrow d-lg-none"></span>
                            </a>
                            <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-rounded-0 py-lg-4 w-lg-225px">
                                <div class="menu-item">
                                    <a class="menu-link py-3" href="{{url('stock-issues/create')}}">
                                        <span class="menu-title">Create Stock Issue</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link py-3" href="{{url('stock-returns/create')}}">
                                        <span class="menu-title">Create Stock Return</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link py-3" href="{{url('stock-issues/create')}}">
                                        <span class="menu-title">Stock Issue List</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link py-3" href="{{url('item-relationship/all')}}">
                                        <span class="menu-title">Item Relationships</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link py-3" href="{{url('item-conversion/create')}}">
                                        <span class="menu-title">Item Conversion</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link py-3" href="{{url('item-damages/create')}}">
                                        <span class="menu-title">Item Damages</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link py-3" href="{{url('material-issues/create')}}">
                                        <span class="menu-title">Material Issues</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion me-lg-1">
                            <a class="menu-link py-3">
                                <span class="menu-title">Accounting</span>
                                <span class="menu-arrow d-lg-none"></span>
                            </a>
                            <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-rounded-0 py-lg-4 w-lg-225px">
                                <div class="menu-item">
                                    <a class="menu-link py-3" href="{{url('expense/create')}}">
                                        <span class="menu-title">Other Expenses</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link py-3" href="{{url('/reports/x-report')}}">
                                        <span class="menu-title">Daily Summary/X-Report</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link py-3" href="{{url('/customer-cheque/all')}}">
                                        <span class="menu-title">Cheques to be deposited</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link py-3" href="{{url('/supplier-cheque/all')}}">
                                        <span class="menu-title">Cheques Issued</span>
                                    </a>
                                </div>

                            </div>
                        </div>
                        <div data-kt-menu-placement="bottom-start" class="menu-item me-lg-1">
                            <a href="{{'/reports'}}" class="menu-link py-3">
                                <span class="menu-title">Reports</span>
                                <span class="menu-arrow d-lg-none"></span>
                            </a>

                        </div>
                    </div>
                    <!--end::Menu-->
                </div>
                <!--end::Menu wrapper-->
            </div>
            <!--end::Navbar-->
            <!--begin::Topbar-->
            <div class="d-flex align-items-stretch justify-self-end flex-shrink-0">
                <!--begin::Toolbar wrapper-->
                <div class="d-flex align-items-stretch flex-shrink-0">
                    <!--begin::User-->
                    <div class="d-flex align-items-center ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
                        <!--begin::Menu wrapper-->
                        <div class="cursor-pointer symbol symbol-30px symbol-md-40px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                            <img src="{{url('assets/media/avatars/blank.png')}}" alt="user" />
                        </div>
                        <!--begin::Menu-->
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-4 fs-6 w-275px" data-kt-menu="true">
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <div class="menu-content d-flex align-items-center px-3">
                                    <!--begin::Avatar-->
                                    <div class="symbol symbol-50px me-5">
                                        <img alt="Logo" src="{{url('assets/media/avatars/blank.png')}}" />
                                    </div>
                                    <!--end::Avatar-->
                                </div>
                            </div>
                            <div class="menu-item px-5">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <a href="" onclick="event.preventDefault();
                                    this.closest('form').submit();" class="menu-link px-5">Sign Out</a>
                                </form>
                            </div>
                        </div>
                        <!--end::Menu-->
                        <!--end::Menu wrapper-->
                    </div>
                    <!--end::User -->
                    <!--begin::Heaeder menu toggle-->
                    <div class="d-flex align-items-center d-lg-none ms-3 me-n1" title="Show header menu">
                        <div class="btn btn-icon btn-active-color-primary w-30px h-30px w-md-40px h-md-40px" id="kt_header_menu_mobile_toggle">
                            <!--begin::Svg Icon | path: icons/duotune/text/txt001.svg-->
                            <span class="svg-icon svg-icon-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M13 11H3C2.4 11 2 10.6 2 10V9C2 8.4 2.4 8 3 8H13C13.6 8 14 8.4 14 9V10C14 10.6 13.6 11 13 11ZM22 5V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4V5C2 5.6 2.4 6 3 6H21C21.6 6 22 5.6 22 5Z" fill="black" />
                                    <path opacity="0.3" d="M21 16H3C2.4 16 2 15.6 2 15V14C2 13.4 2.4 13 3 13H21C21.6 13 22 13.4 22 14V15C22 15.6 21.6 16 21 16ZM14 20V19C14 18.4 13.6 18 13 18H3C2.4 18 2 18.4 2 19V20C2 20.6 2.4 21 3 21H13C13.6 21 14 20.6 14 20Z" fill="black" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </div>
                    </div>
                    <!--end::Heaeder menu toggle-->
                </div>
                <!--end::Toolbar wrapper-->
            </div>
            <!--end::Topbar-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Container-->
</div>
<!--end::Header-->
