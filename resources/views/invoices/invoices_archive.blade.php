@extends('layouts.master')
@section('title')
Archived Invoices List
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
                                / {{ __('Archived Invoices List') }}
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
									<h4 class="card-title mg-b-0">Archived Invoices List</h4>
									<div class="btn-icon-list btn-list">
                                        @can('export-archived-invoices')
                                        <a href="{{ route('invoices.excel.archived') }}" class="btn btn-icon  btn-success" data-placement="top" data-toggle="tooltip" title="Export as Excel">
                                            <i class="fa fa-regular fa-file-excel"></i>
                                        </a>
                                        @endcan
                                    </div>
								</div>
								<p class="tx-12 tx-gray-500 mb-2">
                                    Manage and view All Archived invoices
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
                                                    <td>{{ $invoice->invoice_number }}</td>
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
                                                            @can('restore-archived-invoices')
                                                            <a href="#modal-restore" class="modal-effect btn btn-sm btn-primary" data-effect="effect-scale" data-toggle="modal" data-invoice_id="{{ $invoice->id }}" data-invoice_number="{{ $invoice->invoice_number }}">
                                                                <i class="fa fa-solid fa-share"></i>
                                                            </a>
                                                            @endcan
                                                            @can('delete-invoices')
                                                            <a href="#modal-delete" class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale" data-toggle="modal" data-invoice_id="{{ $invoice->id }}" data-invoice_number="{{ $invoice->invoice_number }}">
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

@can('restore-archived-invoices')
@isset($invoice)
<!-- Modal restore -->
<div class="modal" id="modal-restore">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Restore Invoice</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('invoices_archive/') }}" method="POST">
                    @csrf
                    <input type="hidden" name="invoice_id" id="delete" value="">
                    <div class="col-12 mb-1">
                        <h5>
                            Are you sure you want to restore this invoice?
                        </h5>
                    </div>
                    <div class="form-group col-12">
                        <input type="text" class="form-control" id="invoice_number_delete" value="" disabled>
                    </div>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-danger" type="submit" name="restore_record">Yes</button>
                <button class="btn ripple btn-primary" data-dismiss="modal" type="button">No</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal restore-->

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

    $('#modal-delete, #modal-restore').on('show.bs.modal', function(event) {
        let button = $(event.relatedTarget)
        let invoice_id = button.data('invoice_id')
        let invoice_number = button.data('invoice_number')
        let modal = $(this)
        modal.find('.modal-body #delete').val(invoice_id);
        modal.find('.modal-body #invoice_number_delete').val(invoice_number);
    })


</script>
@endsection
