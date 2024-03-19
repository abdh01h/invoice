@extends('layouts.master')
@section('title') Edit User @endsection
@section('css')
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">
                                {{ __('Users & Roles') }}
                            </h4>
                            <a href="{{ route('users.index') }}" class="text-muted mt-1 tx-13 mr-2 mb-0">
                                / {{ __('Users List') }}
                            </a>
                            <span class="text-muted mt-1 tx-13 mr-2 mb-0">
                                / {{ __('Edit User') }}
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
									<h4 class="card-title mg-b-0">{{ __('Edit User') }}</h4>
								</div>
							</div>
							<form class="card-body row" action="{{ route('users.update', $user) }}" enctype="multipart/form-data" method="POST">
                                @csrf
                                @method('PUT')
                               @include('users.form', ['submitText' => __('Edit')])
                            </form>
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
<script>

$(function(){
        setTimeout(function () {
            $('.alert').fadeOut(function () {
                $('#alert').remove()
            })
        }, 5000);
})

</script>
@endsection
