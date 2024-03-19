<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="Description" content="Debt Management System - Collect and recover company's assets">
		<meta name="Author" content="Abdullah Aldarkhbani">
		<meta name="Keywords" content="Debt Management System"/>
		@include('layouts.head')
	</head>

	<body class="main-body app sidebar-mini leftmenu-dark">
		<!-- Loader -->
		<div id="global-loader">
			<img src="{{URL::asset('assets/img/loader.svg')}}" class="loader-img" alt="Loader">
		</div>
		<!-- /Loader -->
		@include('layouts.main-sidebar')
		<!-- main-content -->
		<div class="main-content app-content">
			@include('layouts.main-header')
			<!-- container -->
			<div class="container-fluid">
				@yield('page-header')
				@yield('content')
            	@include('layouts.footer')
				@include('layouts.footer-scripts')
	</body>
</html>
