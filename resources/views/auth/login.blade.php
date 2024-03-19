@extends('layouts.master2')

@section('title')
    {{ __('Login') }}
@endsection

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
							<img src="{{URL::asset('assets/img/media/login.svg')}}" class="my-auto ht-xl-80p wd-md-100p wd-xl-80p mx-auto" alt="logo">
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
									<div class="card-sigin">
										<div class="mb-5 d-flex"><img src="{{URL::asset('assets/img/brand/favicon.png')}}" class="sign-favicon ht-40" alt="logo"><h1 class="main-logo1 ml-1 mr-0 my-auto tx-28">{{ config('app.name') }}</h1></div>
										<div class="card-sigin">
											<div class="main-signup-header">
												<h2>{{ __('Welcome back!') }}</h2>
												<h5 class="font-weight-semibold mb-4">
                                                    {{ __('Please login in to continue.') }}
                                                </h5>
                                                @include('partials.multi_alert')
												<form action="{{ route('login') }}" method="POST">
                                                    @csrf
													<div class="form-group">
														<label>{{ __('Email') }}</label>
                                                        <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter your email" value="{{ old('email') }}">
                                                        @error('email')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
													</div>
													<div class="form-group">
														<label>{{ __('Password') }}</label>
                                                        <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter your password">
                                                        @error('password')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
													</div>
                                                    <div class="form-group mb-3 justify-content-end">
                                                        <div class="checkbox">
                                                            <div class="custom-checkbox custom-control">
                                                                <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                                <label for="remember" class="custom-control-label mt-1">
                                                                    {{ __('Remember Me') }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-main-primary btn-block">
                                                        {{ __('Log In') }}
                                                    </button>
												</form>

                                                <div class="d-flex justify-content-between mt-2">
                                                    <div class="main-signin-footer">
                                                        @if (Route::has('password.request'))
                                                            <p><a href="{{ route('password.request') }}">
                                                                {{ __('Forgot password?') }}</a></p>
                                                        @endif
                                                    </div>
                                                    <div class="main-signin-footer">
                                                        @if (Route::has('register'))
                                                            <p><a href="{{ route('register') }}">{{ __('Register') }}</a></p>
                                                        @endif
                                                    </div>
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
