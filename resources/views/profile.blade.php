@extends('layouts.master')
@section('title', 'My Profile')
@section('css')
<!---Internal Fileupload css-->
<link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
<!---Internal Fancy uploader css-->
<link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
<!--Internal  Font Awesome -->
<link href="{{URL::asset('assets/plugins/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
<!--Internal   Notify -->
<link href="{{URL::asset('assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
<!--Internal  treeview -->
<link href="{{URL::asset('assets/plugins/treeview/treeview.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">
                                <a href="{{ url('/') }}">{{ config('app.name') }}</a>
                            </h4>
                            <span class="text-muted mt-1 tx-13 mr-2 mb-0">
                                / {{ __('My Profile') }}
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
						<div class="panel panel-primary tabs-style-2">
                            <div class="card mg-b-20">
                                <div class="card-body">
                                    <div class="d-flex justify-content-center">
                                        <div class="main-profile-overview">
                                            <div class="mb-2 ml-1">
                                                @if(Auth::user()->avatar == '')
                                                    <img src="{{ Avatar::create(Auth::user()->name)->setDimension(128, 128)->toBase64() }}" class="rounded-circle" alt="Avatar">
                                                @else
                                                    <img src="{{ asset(Auth::user()->avatar) }}" class="rounded-circle" alt="Avatar" height="128" width="128">
                                                @endif
                                            </div>
                                            <div class="text-center">
                                                <h5 class="main-profile-name">{{ Auth::user()->name }}</h5>
                                                <p class="main-profile-name-text">{{ Auth::user()->email }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @if(!Auth::user()->avatar == '')
                                        <div class="text-right">
                                            <form class="inline-block" action="{{ url('/profile') }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('Are you sure?')">
                                                    <i class="fa fa-solid fa-trash"></i>
                                                    Delete Avatar
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                    <hr>
                                    <div class="row justify-content-center mt-8">
                                        <form class="col-lg-8" action="{{ url('profile/') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <label>Role</label>
                                                <div class="form-control bg-light">
                                                    @if(!empty(Auth::user()->getRoleNames()))
                                                        @foreach(Auth::user()->getRoleNames() as $role)
                                                            <div class="h6 mt-1">{{ $role }}</div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input name="name" class="form-control @error('name') is-invalid @enderror" type="text" placeholder="Your Name" value="{{ Auth::user()->name }}">
                                                @error('name')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input name="email" class="form-control @error('email') is-invalid @enderror" type="text" placeholder="example@example.com" value="{{ Auth::user()->email }}">
                                                @error('email')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>Old Password</label>
                                                <input name="old-password" class="form-control @error('old-password') is-invalid @enderror" type="password" placeholder="********">
                                                @error('old-password')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>New Password</label>
                                                <input name="password" class="form-control @error('password') is-invalid @enderror" type="password" placeholder="********">
                                                @error('password')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>Confirm New Password</label>
                                                <input name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" type="password" placeholder="********">
                                            </div>
                                            <div class="form-group">
                                                <label>Upload Avatar</label>
                                                <input class="dropify" type="file" name="avatar" accept=".jpg, .png, jpeg" data-height="120">
                                                @error('avatar')
                                                    <small class="text-danger">
                                                        {{ $message }}
                                                    </small>
                                                @enderror
                                            </div>
                                            <div class="form-group text-center">
                                                <hr>
                                                <button class="btn btn-primary" type="submit">Update</button>
                                            </div>
                                        </form>
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
<!--Internal Fileuploads js-->
<script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
<!--Internal Fancy uploader js-->
<script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
<!-- Internal Treeview js -->
<script src="{{URL::asset('assets/plugins/treeview/treeview.js')}}"></script>
<!--Internal  Notify js -->
<script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
@include('partials.multi_js_alert')
<script>
    $(document).ready(function(){
        setTimeout(function () {
            $('.alert').fadeOut(function () {
                $('#alert').remove()
            })
        }, 5000);
    })
</script>
@endsection
