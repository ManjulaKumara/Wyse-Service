<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head>
		<title>Wyse Service - Edition of the Wyse POS which is tailor made for Car Service Station</title>
		<meta charset="utf-8" />

		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="shortcut icon" href="https://wysheit.com/images/wyse.png" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Global Stylesheets Bundle(used by all pages)-->
		<link href="{{url('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{url('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled page-loading">
		<!-- Google Tag Manager (noscript) -->
		<noscript>
			<iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5FS8GGP" height="0" width="0" style="display:none;visibility:hidden"></iframe>
		</noscript>
		<!-- End Google Tag Manager (noscript) -->
		<!--begin::Main-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Error-->
			<div class="error error-6 d-flex flex-row-fluid bgi-size-cover bgi-position-center" style="background-image: url({{url('assets/media/errors/bg6.jpg')}});">
				<!--begin::Content-->
				<div class="d-flex flex-column flex-row-fluid text-center">
					<h1 class="display-2 font-weight-boldest text-white mb-12" style="margin-top: 12rem;">Oops...</h1>
					<p class="display-6 font-weight-bold text-white">Looks like you don't have permissions to access this information.</p>
				</div>
				<!--end::Content-->
			</div>
			<!--end::Error-->
		</div>
		<!--begin::Global Config(global config for global JS scripts)-->

		<script>var hostUrl = "{{url('assets/')}}";</script>
		<!--begin::Javascript-->
		<!--begin::Global Javascript Bundle(used by all pages)-->
		<script src="{{url('assets/plugins/global/plugins.bundle.js')}}"></script>
		<script src="{{url('assets/js/scripts.bundle.js')}}"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Page Custom Javascript(used by this page)-->
		<script src="{{url('assets/js/custom/authentication/sign-in/general.js')}}"></script>
		<!--end::Page Custom Javascript-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>
