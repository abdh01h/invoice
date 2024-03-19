@extends('layouts.master')
@section('title') Role {{ $role->name }} @endsection
@section('css')
<!-- Interenal Accordion Css -->
<link href="http://localhost:8000/assets/plugins/accordion/accordion.css" rel="stylesheet" />
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">
                                {{ __('Users & Roles') }}
                            </h4>
                            <a href="{{ route('roles.index') }}" class="text-muted mt-1 tx-13 mr-2 mb-0">
                                / {{ __('Roles List') }}
                            </a>
                            <span class="text-muted mt-1 tx-13 mr-2 mb-0">
                                / Role {{ $role->name }}
                            </span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row justify-content-center">

					<!--div-->
					<div class="col-xl-8">
                        @include('partials.multi_alert')
						<div class="card mg-b-20">
							<div class="card-header pb-0">
								<div class="d-flex justify-content-between">
									<h4 class="card-title mg-b-0">{{ __('Edit Role') }}</h4>
                                    <a href="{{ url('/roles') }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-solid fa-arrow-left"></i>
                                        Back
                                    </a>
								</div>
							</div>
							<div class="card-body">
                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label>Role Name</label>
                                        <input type="text" class="form-control" value="{{ $role->name }}" disabled>
                                    </div>
                                </div>
                                <div id="accordion" class="w-100 br-2 overflow-hidden">
                                    <div class="">
                                        <div class="accor bg-primary" id="headingOne1">
                                            <h4 class="m-0">
                                                <a href="#collapseOne1" class="" data-toggle="collapse" aria-expanded="true" aria-controls="collapseOne">
                                                    Role Permissions
                                                    <i class="fa fa-solid fa-arrow-right"></i>
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseOne1" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                            <div class="border p-3">
                                                <ul>
                                                    @foreach ($rolePermissions as $permission)
                                                        <li class="h5">{{ $permission }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
						</div>
						</div>
					</div>
					<!--/div-->

				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
<!--- Internal Accordion Js -->
<script src="http://localhost:8000/assets/plugins/accordion/accordion.min.js"></script>
<script src="http://localhost:8000/assets/js/accordion.js"></script>
@endsection
