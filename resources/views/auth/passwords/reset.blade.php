@extends('layouts.master2')
@section('title', 'Reset Password')
@section('css')
<!-- Sidemenu-respoansive-tabs css -->
<link href="{{URL::asset('assets/plugins/sidemenu-responsive-tabs/css/sidemenu-responsive-tabs.css')}}" rel="stylesheet">
@endsection
@section('content')
		<div class="container-fluid">
			<div class="row no-gutter">
				<!-- The image half -->
				<div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent">
					<div class="row wd-100p mx-auto text-center">
						<div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
							<img src="{{URL::asset('assets/img/media/password.svg')}}" class="my-auto ht-xl-80p wd-md-100p wd-xl-50p ht-xl-60p mx-auto" alt="logo">
						</div>
					</div>
				</div>
				<!-- The content half -->
				<div class="col-md-6 col-lg-6 col-xl-5 bg-white">
					<div class="login d-flex align-items-center py-2">
						<!-- Demo content-->
						<div class="container p-0">
							<div class="row">
								<div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
									<div class="mb-5 d-flex"> <a href="{{ url('/' . $page='index') }}"><img src="{{URL::asset('assets/img/brand/favicon.png')}}" class="sign-favicon ht-40" alt="logo"></a><h1 class="main-logo1 ml-1 mr-0 my-auto tx-28">{{ config('app.name') }}</h1></div>
									<div class="main-card-signin d-md-flex">
										<div class="wd-100p">
											<div class="main-signin-header">
												<div class="">
													<h2>{{ __('Reset Your Password') }}</h2>
													<form method="POST" action="{{ route('password.update') }}">
                                                        @csrf
                                                        <input type="hidden" name="token" value="{{ $token }}">
														<div class="form-group text-left">
															<label>{{ __('Email') }}</label>
															<input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter your email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                                                            @error('email')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
														</div>
														<div class="form-group text-left">
															<label>{{ __('New Password') }}</label>
															<input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('Enter your new password') }}" required autocomplete="new-password">
                                                            @error('password')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
														</div>
														<div class="form-group text-left">
															<label>{{ __('Confirm Password') }}</label>
															<input id="password-confirm" type="password" name="password_confirmation" class="form-control" placeholder="{{ __('Confirm your password') }}" required autocomplete="new-password">
														</div>
														<button type="submit" class="btn ripple btn-main-primary btn-block">
                                                            {{ __('Reset Password') }}
                                                        </button>
													</form>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div><!-- End -->
					</div>
				</div><!-- End -->
			</div>
		</div>
@endsection
@section('js')
@endsection
