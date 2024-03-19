@extends('layouts.master')
@section('title')
Partially Paid Invoices List
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
                                {{ __('Invoices') }}
                            </h4>
                            <span class="text-muted mt-1 tx-13 mr-2 mb-0">
                                / {{ __('Partially Paid Invoices List') }}
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
									<h4 class="card-title mg-b-0">Partially Paid Invoices List</h4>
									<div class="btn-icon-list btn-list">
                                        @can('export-partially-paid-invoices')
                                        <a href="{{ route('invoices.excel.partially') }}" class="btn btn-icon  btn-success" data-placement="top" data-toggle="tooltip" title="Export as Excel">
                                            <i class="fa fa-regular fa-file-excel"></i>
                                        </a>
                                        @endcan
                                        @can('add-invoices')
                                        <a href="{{ route('invoices.create') }}" class="btn btn-icon  btn-primary" data-placement="top" data-toggle="tooltip" title="Add New Invoice">
                                            <i class="fa fa-solid fa-plus"></i>
                                        </a>
                                        @endcan
                                    </div>
								</div>
								<p class="tx-12 tx-gray-500 mb-2">
                                    Manage and view All Partially Paid invoices
                                </p>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table id="datatable" class="table key-buttons text-md-nowrap hover">
										<thead class="bg-light">
											<tr>
                                                <th>#</th>
												<th>Invoice No.</th>
												<th>Invoice Date</th>
												<th>Due Date</th>
                                                <th>Section</th>
                                                <th>Product</th>
												<th>Discount</th>
												<th>Vat Rate</th>
												<th>Vat Value</th>
                                                <th>Total</th>
												<th>status</th>
                                                <th>Actions</th>
											</tr>
										</thead>
										<tbody>
                                            @php $id = 1; @endphp
                                            @foreach ($invoices as $invoice)
                                                <tr>
                                                    <td>{{ $id++ }}</td>
                                                    <td>
                                                        <a href="{{ route("invoice_details.index", $invoice) }}">
                                                            {{ $invoice->invoice_number }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $invoice->invoice_date }}</td>
                                                    <td>{{ $invoice->due_date }}</td>
                                                    <td>{{ $invoice->sections->section_name }}</td>
                                                    <td>{{ $invoice->product_name }}</td>
                                                    <td>{{ $invoice->discount }}</td>
                                                    <td>{{ $invoice->vat_rate }}</td>
                                                    <td>{{ $invoice->vat_value }}</td>
                                                    <td>{{ $invoice->total }}</td>
                                                    <td>
                                                        @php
                                                            if($invoice->value_status == 1) {
                                                                $value = 'success'; }
                                                            elseif($invoice->value_status == 2) {
                                                                $value = 'warning'; }
                                                            else {
                                                                $value = 'danger'; }
                                                        @endphp
                                                        <span class="text-white badge bg-{{$value}}">
                                                            {{ $invoice->status }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="dropdown show">
                                                            <a class="btn btn-primary btn-sm dropdown-toggle" href="#" role="button" id="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                Actions
                                                                <i class="fa fa-solid fa-chevron-down"></i>
                                                            </a>
                                                            <div class="dropdown-menu" aria-labelledby="dropdown">
                                                                @can('show-partially-paid-invoices')
                                                                <a href="{{ route("invoice_details.index", $invoice) }}" class="dropdown-item">
                                                                    <i class="fa fa-regular fa-eye"></i>
                                                                    View
                                                                </a>
                                                                @endcan
                                                                @can('edit-invoices')
                                                                <a href="{{ route('invoices.edit', $invoice) }}" class="dropdown-item">
                                                                    <i class="fa fa-solid fa-pen"></i>
                                                                    Edit
                                                                </a>
                                                                @endcan
                                                                @can('chnage-invoices-status')
                                                                <a href="{{ route('payment_status.show', $invoice) }}" class="dropdown-item">
                                                                    <i class="fa fa-solid fa-money-bill"></i>
                                                                    Change Status
                                                                </a>
                                                                @endcan
                                                                @can('delete-invoices')
                                                                <a href="#modal-archive" class="modal-effect dropdown-item" data-effect="effect-scale" data-toggle="modal" data-invoice_id="{{ $invoice->id }}" data-invoice_number="{{ $invoice->invoice_number }}">
                                                                    <i class="fa fa-solid fa-inbox"></i>
                                                                    Move to Archive
                                                                </a>
                                                                <a href="#modal-delete" class="modal-effect dropdown-item" data-effect="effect-scale" data-toggle="modal" data-invoice_id="{{ $invoice->id }}" data-invoice_number="{{ $invoice->invoice_number }}">
                                                                    <i class="fa fa-solid fa-trash"></i>
                                                                    Delete
                                                                </a>
                                                                @endcan
                                                            </div>
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

@can('delete-invoices')
@isset($invoice)
<!-- Modal archive -->
<div class="modal" id="modal-archive">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Move Invoice to archive</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('invoices.destroy', $invoice) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="invoice_id" id="delete" value="">
                    <input type="hidden" name="archive" value="archive">
                    <div class="col-12 mb-1">
                        <h5>
                            Are you sure you want to move this invoice to archive?
                        </h5>
                    </div>
                    <div class="form-group col-12">
                        <input type="text" class="form-control" id="invoice_number_delete" value="" disabled>
                    </div>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-danger" type="submit" name="archive_record">Yes</button>
                <button class="btn ripple btn-primary" data-dismiss="modal" type="button">No</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal archive-->

<!-- Modal delete -->
<div class="modal" id="modal-delete">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Delete Invoice</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('invoices.destroy', $invoice) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="invoice_id" id="delete" value="">
                    <input type="hidden" name="delete" value="delete">
                    <div class="col-12 mb-1">
                        <h5>
                            Are you sure you want to delete this invoice Permanently?
                        </h5>
                    </div>
                    <div class="form-group col-12">
                        <input type="text" class="form-control" id="invoice_number_delete" value="" disabled>
                    </div>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-danger" type="submit" name="delete_record">Yes</button>
                <button class="btn ripple btn-primary" data-dismiss="modal" type="button">No</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal delete-->
@endisset
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

    $(document).ready(function(){
        setTimeout(function () {
            $('.alert').fadeOut(function () {
                $('#alert').remove()
            })
        }, 5000);
    })

    $('#modal-delete, #modal-archive').on('show.bs.modal', function(event) {
        let button = $(event.relatedTarget)
        let invoice_id = button.data('invoice_id')
        let invoice_number = button.data('invoice_number')
        let modal = $(this)
        modal.find('.modal-body #delete').val(invoice_id);
        modal.find('.modal-body #invoice_number_delete').val(invoice_number);
    })


</script>
@endsection
