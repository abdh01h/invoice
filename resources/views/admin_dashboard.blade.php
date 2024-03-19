@extends('layouts.master')
@section('title', 'Admin Dashboard')
@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="my-auto">
                <div class="d-flex">
                    <h4 class="content-title mb-0 my-auto">
                        {{ __('Admin Dashboard') }}
                    </h4>
                </div>
            </div>
        </div>
        <!-- /breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row row-sm mt-4">
					<div class="col-xl-4 col-lg-4 col-sm-12 col-md-12">
                        <a href="{{ url('users') }}" class="card text-center">
                            <div class="card-body rounded-lg bg-primary">
                                <div class="feature widget-2 text-center mt-0 mb-1">
                                    <i class="fa fa-solid fa-user text-white fa-lg"></i>
                                </div>
                                <h6 class="mb-1 h5 text-white">Total Users</h6>
                                <h3 class="fw-semibold text-white">
                                    {{ App\Models\User::count() }}
                                </h3>
                            </div>
                        </a>
                    </div>

                    <div class="col-xl-4 col-lg-4 col-sm-12 col-md-12">
                        <a href="{{ url('roles') }}" class="card text-center">
                            <div class="card-body rounded-lg bg-success">
                                <div class="feature widget-2 text-center mt-0 mb-1">
                                    <i class="fa fa-solid fa-users text-white fa-lg"></i>
                                </div>
                                <h6 class="mb-1 h5 text-white">Total Roles</h6>
                                <h3 class="fw-semibold text-white">
                                    {{ Spatie\Permission\Models\Role::count() }}
                                </h3>
                            </div>
                        </a>
                    </div>

                    <div class="col-xl-4 col-lg-4 col-sm-12 col-md-12">
                        <a href="{{ url('roles') }}" class="card text-center">
                            <div class="card-body rounded-lg bg-danger">
                                <div class="feature widget-2 text-center mt-0 mb-1">
                                    <i class="fa fa-solid fa-wrench text-white fa-lg"></i>
                                </div>
                                <h6 class="mb-1 h5 text-white">Total Permissions</h6>
                                <h3 class="fw-semibold text-white">
                                    {{  Spatie\Permission\Models\Permission::count() }}
                                </h3>
                            </div>
                        </a>
                    </div>

                    @can('show-audit-trail')
                    <!--div-->
					<div class="col-xl-12">
						<div class="card mg-b-20">
							<div class="card-header pb-0">
								<div class="d-flex justify-content-between">
									<h4 class="card-title mg-b-0">Audit Trail</h4>
									<div class="btn-icon-list btn-list"></div>
								</div>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table id="datatable" class="table key-buttons text-md-nowrap hover">
										<thead class="bg-light">
											<tr>
												<th>#</th>
                                                <th>Module</th>
                                                <th>By</th>
                                                <th>User ID</th>
                                                <th>Description</th>
                                                <th>At</th>
											</tr>
										</thead>
										<tbody></tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<!--/div-->
                    @endcan

				</div>
				<!-- row closed -->

			</div>
		</div>
		<!-- Container closed -->
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
<!--Internal  Chart.bundle js -->
<script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>
<!--Internal  index js -->
<script src="{{URL::asset('assets/js/index.js')}}"></script>
<script>

$(function () {
    let table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'log_name', name: 'log_name'},
            {data: 'causer.name', name: 'causer.name'},
            {data: 'causer_id', name: 'causer_id'},
            {data: 'description', name: 'description'},
            {data: 'created_at', name: 'created_at'},

        ],
        aaSorting: [],
    });
});

// $(function(e) {
//     let table = $('#datatable').DataTable({
//     "aLengthMenu": [
//             [10, 25, 50, 100, -1],
//             [10, 25, 50, 100, "All"]
//         ],
//     "iDisplayLength": 10,
//     "aaSorting": [],
//     });
// });

</script>
@endsection
