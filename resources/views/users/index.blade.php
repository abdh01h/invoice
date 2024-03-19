@extends('layouts.master')
@section('title')
Users
@endsection
@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<style>
    svg text {
        font-size: 21px;
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }
</style>
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
                                / {{ __('Users List') }}
                            </span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
@include('partials.multi_alert')
@include('partials.errors_alert')
				<!-- row -->
				<div class="row">

					<!--div-->
					<div class="col-xl-12">
						<div class="card mg-b-20">
							<div class="card-header pb-0">
								<div class="d-flex justify-content-between">
									<h4 class="card-title mg-b-0">Users List</h4>
									<div class="btn-icon-list btn-list">
                                        @can('add-users')
                                        <a href="{{ route('users.create') }}" class="btn btn-primary">
                                            <i class="fa fa-solid fa-plus"></i>
                                            New User
                                        </a>
                                        @endcan
                                    </div>
								</div>
								<p class="tx-12 tx-gray-500 mb-2">
                                    Manage and view All Users
                                </p>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table id="datatable" class="table key-buttons text-md-nowrap hover">
										<thead class="bg-light">
											<tr>
												<th>#</th>
												<th>User Name</th>
                                                <th>Role</th>
                                                <th>Status</th>
                                                <th>Created At</th>
                                                <th>Updated At</th>
                                                <th>Actions</th>
											</tr>
										</thead>
										<tbody>
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td>{{ $user->id }}</td>
                                                    <td>
                                                        <span style="width: 250px;">
                                                            <div class="d-flex align-items-center">
                                                                @if(empty($user->avatar))
                                                                    {!! Avatar::create($user->name)->setDimension(45, 45)->toSvg() !!}
                                                                @else
                                                                    <img class="rounded-circle" src="{{ asset($user->avatar) }}" alt="Avatar" width="45" height="45">
                                                                @endif
                                                                <div class="ml-4">
                                                                    <div class="text-dark-75 font-weight-bolder font-size-lg mb-0">
                                                                        <a href="{{ route('users.show', $user) }}">
                                                                            {{ $user->name }}
                                                                        </a>
                                                                    </div>
                                                                    <a href="#" class="text-muted font-weight-bold text-hover-primary">{{ $user->email }}</a>
                                                                </div>
                                                            </div>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @if(!empty($user->getRoleNames()))
                                                            @foreach($user->getRoleNames() as $role)
                                                                <label class="text-white badge bg-primary">{{ $role }}</label>
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($user->status == 1)
                                                            <span class="text-white badge bg-success">
                                                                Active
                                                            </span>
                                                        @else
                                                            <span class="text-white badge bg-danger">
                                                                Inactive
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ date('d-m-Y, h:i A', strtotime($user->created_at)) }}
                                                    </td>
                                                    <td>
                                                        {{ date('d-m-Y, h:i A', strtotime($user->updated_at)) }}
                                                    </td>
                                                    <td>
                                                        <div class="btn-icon-list btn-list">
                                                            @can('show-users')
                                                            <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-success">
                                                                <i class="fa fa-solid fa-eye"></i>
                                                            </a>
                                                            @endcan
                                                            @can('edit-users')
                                                            <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-primary">
                                                                <i class="fa fa-solid fa-pen"></i>
                                                            </a>
                                                            @endcan
                                                            @can('delete-users')
                                                            <a href="#modal-delete" class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale" data-toggle="modal" data-user_id="{{ $user->id }}" data-user_name="{{ $user->name }}">
                                                                <i class="fa fa-solid fa-trash"></i>
                                                            </a>
                                                            @endcan
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
									</table>
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

<!-- Modal delete -->
<div class="modal" id="modal-delete">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Delete User</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="row" action="{{ url('users/destroy') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" class="form-control" name="user_id" id="delete" value="">
                    <div class="col-12 mb-1">
                        <h5>
                            Are you sure you want to delete this user?
                        </h5>
                    </div>
                    <div class="form-group col-12">
                        <input type="text" class="form-control" name="user_name" id="user_name" value="" disabled>
                    </div>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-danger" type="submit" name="delete_record" id="add_record">Yes</button>
                <button class="btn ripple btn-primary" data-dismiss="modal" type="button">No</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal delete-->

@endsection
@section('js')
<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!-- Internal Modal js-->
<script src="{{URL::asset('assets/js/modal.js')}}"></script>
<script>
    $(function() {
      let table = $('#datatable').DataTable({
        "aLengthMenu": [
              [10, 25, 50, 100, -1],
              [10, 25, 50, 100, "All"]
          ],
        "iDisplayLength": 10,
         "aaSorting": [],
      });
    });

    $('#modal-delete').on('show.bs.modal', function(event) {
        let button = $(event.relatedTarget)
        let user_id = button.data('user_id')
        let user_name = button.data('user_name')
        let modal = $(this)
        modal.find('.modal-body #delete').val(user_id);
        modal.find('#user_name').val(user_name);
    })

    $(document).ready(function(){
        setTimeout(function () {
            $('.alert').fadeOut(function () {
                $('#alert').remove()
            })
        }, 5000);
    })


</script>

@endsection
