@extends('layouts.master')
@section('title', $user->name . ' Profile')
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
                            <span class="text-muted mt-1 tx-13 mr-2 mb-0">
                                / {{ $user->name }}
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
						<div class="panel panel-primary tabs-style-2">
                            <div class="card mg-b-20">
                                <div class="card-header pb-0">
                                    <div class="d-flex justify-content-between">
                                        <h4 class="card-title mg-b-0">{{ __('User Profile') }}</h4>
                                        <a href="{{ url('/users') }}" class="btn btn-primary btn-sm">
                                            <i class="fa fa-solid fa-arrow-left"></i>
                                            Back
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-center">
                                        <div class="main-profile-overview">
                                            <div class="mb-2 ml-1">
                                                @if(empty($user->avatar))
                                                    <img src="{{ Avatar::create($user->name)->setDimension(128, 128)->toBase64() }}" class="rounded-circle" alt="Avatar">
                                                @else
                                                    <img src="{{ asset($user->avatar) }}" class="rounded-circle" alt="Avatar" height="128" width="128">
                                                @endif
                                            </div>
                                            <div class="text-center">
                                                <h5 class="main-profile-name">{{ $user->name }}</h5>
                                                <p class="main-profile-name-text">{{ $user->email }}</p>
                                                <p class="main-profile-name-text">
                                                    @if($user->status == 1)
                                                        <span class="text-white badge bg-success">
                                                            Active
                                                        </span>
                                                    @else
                                                        <span class="text-white badge bg-danger">
                                                            Inactive
                                                        </span>
                                                    @endif
                                                </p>
                                                <p class="main-profile-name-text">
                                                    @if(!empty($user->getRoleNames()))
                                                        @foreach($user->getRoleNames() as $role)
                                                            <label class="text-white badge bg-primary">
                                                                {{ $role }}
                                                            </label>
                                                        @endforeach
                                                    @endif
                                                </p>
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
@endsection
