@extends('layouts.master')
@section('title')
Sections
@endsection
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
                                {{ __('Settings') }}
                            </h4>
                            <span class="text-muted mt-1 tx-13 mr-2 mb-0">
                                / {{ __('Sections List') }}
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
									<h4 class="card-title mg-b-0">Sections List</h4>
									<div class="btn-icon-list btn-list">
                                        @can('add-sections')
                                        <a href="#modal-add" class="modal-effect btn btn-primary" data-effect="effect-scale" data-toggle="modal">
                                            <i class="fa fa-solid fa-plus"></i>
                                            New Section
                                        </a>
                                        @endcan
                                    </div>
								</div>
								<p class="tx-12 tx-gray-500 mb-2">
                                    Manage and view All Sections
                                </p>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table id="datatable" class="table key-buttons text-md-nowrap hover">
										<thead class="bg-light">
											<tr>
												<th>#</th>
												<th>Section Name</th>
                                                <th>Created By</th>
                                                <th>Updated At</th>
                                                <th>Actions</th>
											</tr>
										</thead>
										<tbody>
                                            @php (int)$id = 1; @endphp
                                            @foreach ($sections as $sec)
                                                <tr>
                                                    <td>{{ $id++ }}</td>
                                                    <td>{{ $sec->section_name }}</td>
                                                    <td>{{ $sec->created_by }}</td>
                                                    <td>
                                                        {{ date('d-m-Y, h:i A', strtotime($sec->updated_at)) }}
                                                    </td>
                                                    <td>
                                                        <div class="btn-icon-list btn-list">
                                                            @can('edit-sections')
                                                            <a href="#modal-edit" class="modal-effect btn btn-sm btn-primary" data-effect="effect-scale" data-toggle="modal" data-id="{{ $sec->id }}" data-section_name="{{ $sec->section_name }}" data-description="{{ $sec->description }}">
                                                                <i class="fa fa-solid fa-pen"></i>
                                                            </a>
                                                            @endcan
                                                            @can('delete-sections')
                                                            <a href="#modal-delete" class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale" data-toggle="modal" data-id="{{ $sec->id }}" data-section_name="{{ $sec->section_name }}">
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

@can('add-sections')
<!-- Modal Add -->
<div class="modal" id="modal-add">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Add New Section</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="row" id="sections_form" action="{{ route('sections.store') }}" method="POST">
                    @csrf
                    @include('sections.form')
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-primary" type="submit" name="add_record" id="add_record">Add</button>
                <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Add-->
@endcan

@can('edit-sections')
<!-- Modal Edit -->
<div class="modal" id="modal-edit">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Edit Section</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="row" id="sections_form" action="{{ url('sections/update') }}" method="POST" autocomplete="off">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="id" id="edit" value="">
                    @include('sections.form')
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-primary" type="submit" name="edit_record" id="add_record">Edit</button>
                <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Edit-->
@endcan

@can('delete-sections')
<!-- Modal delete -->
<div class="modal" id="modal-delete">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Delete Section</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="row" action="{{ url('sections/destroy') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id" id="delete" value="">
                    <div class="col-12 mb-1">
                        <h5>
                            Are you sure you want to delete this section?
                        </h5>
                    </div>
                    <div class="form-group col-12">
                        <input type="text" class="form-control" name="section_name" id="section_name_delete" placeholder="Section Name" value="" disabled>
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
@endcan

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
    $(function(e) {
      let table = $('#datatable').DataTable({
        "aLengthMenu": [
              [10, 25, 50, 100, -1],
              [10, 25, 50, 100, "All"]
          ],
        "iDisplayLength": 10,
        "aaSorting": [],
      });
    });

    $('#modal-edit').on('show.bs.modal', function(event) {
        let button = $(event.relatedTarget)
        let id = button.data('id')
        let section_name = button.data('section_name')
        let description = button.data('description')
        let modal = $(this)
        modal.find('.modal-body #edit').val(id);
        modal.find('.modal-body #section_name').val(section_name);
        modal.find('.modal-body #description').val(description);
    })

    $('#modal-delete').on('show.bs.modal', function(event) {
        let button = $(event.relatedTarget)
        let id = button.data('id')
        let section_name = button.data('section_name')
        let modal = $(this)
        modal.find('.modal-body #delete').val(id);
        modal.find('#section_name_delete').val(section_name);
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
