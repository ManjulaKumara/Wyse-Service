<html lang="en">
	<!--begin::Head-->
	<head>
		<title>Wyse Service - Edition of the Wyse POS which is tailor made for Car Service Station</title>
		<link rel="shortcut icon" href="https://wysheit.com/images/wyse.png" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Page Vendor Stylesheets(used by this page)-->
		<link href="{{url('assets/plugins/custom/leaflet/leaflet.bundle.css')}}" rel="stylesheet" type="text/css" />
		<!--end::Page Vendor Stylesheets-->
		<!--begin::Global Stylesheets Bundle(used by all pages)-->
		<link href="{{url('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{url('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css"/>
        @yield('optional_css')
		<!--end::Global Stylesheets Bundle-->
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-disabled">
        <div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="page d-flex flex-row flex-column-fluid">
                @include('layouts.includes.primary-menu')
                <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                    @include('layouts.includes.header')
                    @yield('search_panel')
                    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Container-->
						<div class="container-xxl" id="kt_content_container">
                            @yield('content')
                        </div>
						<!--end::Container-->
					</div>
					<!--end::Content-->
                    @include('layouts.includes.footer')
                </div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
        <!--end::Root-->
        @yield('activity_drawer')
        <!--begin::Scrolltop-->
		<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
			<!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
			<span class="svg-icon">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
					<rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="black" />
					<path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="black" />
				</svg>
			</span>
			<!--end::Svg Icon-->
		</div>
		<!--end::Scrolltop-->
        <script>var hostUrl = "assets/";</script>
		<!--begin::Javascript-->
		<!--begin::Global Javascript Bundle(used by all pages)-->
		<script src="{{url('assets/plugins/global/plugins.bundle.js')}}"></script>
		<script src="{{url('assets/js/scripts.bundle.js')}}"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Page Vendors Javascript(used by this page)-->
		<script src="{{url('assets/plugins/custom/leaflet/leaflet.bundle.js')}}"></script>
		<!--end::Page Vendors Javascript-->
		<!--begin::Page Custom Javascript(used by this page)-->
		<script src="{{url('assets/js/custom/modals/select-location.js')}}"></script>
		<script src="{{url('assets/js/custom/widgets.js')}}"></script>
		<script src="{{url('assets/js/custom/apps/chat/chat.js')}}"></script>
		<script src="{{url('assets/js/custom/modals/create-app.js')}}"></script>
		<script src="{{url('assets/js/custom/modals/upgrade-plan.js')}}"></script>
        <script src="{{url('assets/plugins/global/plugins.bundle.js')}}"></script>
        <script>
			const APP_URL = "{{env('APP_URL')}}";
		</script>
		<!--end::Page Custom Javascript-->
		<!--end::Javascript-->
        @yield('opyional_js')
        <script src="{{ url('assets/js/toastr.js')}}"></script>
		<script src="{{ url('assets/js/sweetalert2.js')}}"></script>
        <script>
            toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toastr-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
            };
        </script>
        @if(Session::has('success'))
            <script>
                var message='{{Session::get("success")}}';
                toastr.success(message);
            </script>
        @endif
        @if(Session::has('error'))
            <script>
                var message='{{Session::get("error")}}';
                toastr.error(message);
            </script>
        @endif
	</body>
	<!--end::Body-->
</html>
