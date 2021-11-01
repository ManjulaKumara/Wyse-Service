<!--begin::Aside-->
<div id="kt_aside" class="aside bg-primary" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="auto" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_toggle">
    <!--begin::Logo-->
    <div class="aside-logo d-none d-lg-flex flex-column align-items-center flex-column-auto py-8" id="kt_aside_logo">
        <a href="{{url('/')}}">
            <img alt="Logo" src="{{url('assets/media/logos/wyse_logo.png')}}" class="h-55px" />
        </a>
    </div>
    <!--end::Logo-->
    <!--begin::Nav-->
    <div class="aside-nav d-flex flex-column align-lg-center flex-column-fluid w-100 pt-5 pt-lg-0" id="kt_aside_nav">
        <!--begin::Primary menu-->
        <div id="kt_aside_menu" class="menu menu-column menu-title-gray-600 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-bold fs-6" data-kt-menu="true">
            <div class="menu-item py-3">
                <a class="menu-link active menu-center" href="{{url('/')}}" title="Dashboard" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                    <span class="menu-icon me-0">
                        <i class="bi bi-house fs-2"></i>
                    </span>
                </a>
            </div>
            <div data-kt-menu-placement="right-start" title="Invoice" class="menu-item py-3">
                <a class="menu-link menu-center" href="{{url('sales/create')}}">
                    <span class="menu-icon me-0">
                        <i class="bi bi-receipt fs-2"></i>
                    </span>
                </a>
            </div>
            <div  data-kt-menu-placement="right-start" title="Supplier Voucher" class="menu-item py-3">
                <a class="menu-link menu-center" href="{{url('/supplier-vouchers/create')}}">
                    <span class="menu-icon me-0">
                        <i class="bi bi-credit-card-2-back-fill fs-2"></i>
                    </span>
                </a>
            </div>
            <div  data-kt-menu-placement="right-start" title="Customer Receipt" class="menu-item py-3">
                <a class="menu-link menu-center" href="{{url('/customer-receipts/create')}}">
                    <span class="menu-icon me-0">
                        <i class="bi bi-cash-coin fs-2"></i>
                    </span>
                </a>
            </div>
            <div  data-kt-menu-placement="right-start" class="menu-item py-3">
                <a class="menu-link menu-center" href="{{url('/stock-issues/create')}}" title="Stock Issues">
                    <span class="menu-icon me-0">
                        <i class="bi bi-cart-fill fs-2"></i>
                    </span>
                </a>
            </div>
            <div data-kt-menu-placement="right-start" class="menu-item py-3">
                <a class="menu-link menu-center" href="{{url('/grns/create')}}" title="Item Purchases" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                    <span class="menu-icon me-0">
                        <i class="bi bi-upc-scan fs-2"></i>
                    </span>
                </a>

            </div>
            <div data-kt-menu-placement="right-start" class="menu-item py-3">
                <a href="{{url('/stock-returns/create')}}" class="menu-link menu-center" title="Stock Returns" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                    <span class="menu-icon me-0">
                        <i class="bi bi-arrow-return-left fs-2"></i>
                    </span>
                </a>

            </div>
        </div>
        <!--end::Primary menu-->
    </div>
    <!--end::Nav-->
    <!--end::Footer-->
</div>
<!--end::Aside-->
