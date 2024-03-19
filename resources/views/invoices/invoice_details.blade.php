@extends('layouts.master')
@section('title')
{{ $invoice->invoice_number }}
@endsection
@section('css')
<!---Internal Fileupload css-->
<link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
<!---Internal Fancy uploader css-->
<link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">
                                {{ __('Invoices') }}
                            </h4>
                            <a href="{{ route('invoices.index') }}" class="text-muted mt-1 tx-13 mr-2 mb-0">
                                / {{ __('Invoices List') }}
                            </a>
                            <span class="text-muted mt-1 tx-13 mr-2 mb-0">
                                / {{ $invoice->invoice_number }}
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
						<div class="panel panel-primary tabs-style-2">
                            <div class="card mg-b-20">
                                <div class="card-body">
                                    <div class=" tab-menu-heading">
                                        <div class="tabs-menu1">
                                            <!-- Tabs -->
                                            <ul class="nav panel-tabs main-nav-line" id="detailsTabs">
                                                <li>
                                                    <a href="#tab1" class="nav-link active" data-toggle="tab">
                                                        <i class="fa fa-solid fa-file-invoice"></i>
                                                        {{ __('Invoice Details') }}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#tab2" class="nav-link" data-toggle="tab">
                                                        <i class="fa fa-solid fa-file-invoice-dollar"></i>
                                                        {{ __('Payment Details') }}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#tab3" class="nav-link" data-toggle="tab">
                                                        <i class="fa fa-solid fa-file"></i>
                                                        {{ __('Attachments') }}
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="panel-body tabs-menu-body main-content-body-right border">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab1">
                                                <div class="d-flex flex-row-reverse">
                                                    @can('edit-invoices')
                                                    <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-primary mb-4 ml-1">
                                                        <i class="fa fa-regular fa-pen"></i>
                                                        Edit Invoice
                                                    </a>
                                                    @endcan
                                                    @can('print-invoices')
                                                    <a href="{{ route('invoice.print', $invoice) }}" class="btn btn-danger mb-4 ml-1">
                                                        <i class="fa fa-solid fa-print"></i>
                                                        Print Invoice
                                                    </a>
                                                    @endcan
                                                </div>
                                                <table class="table table-striped mg-b-0 text-md-nowrap">
                                                    <tbody>
                                                        <tr>
                                                            <th>{{ "Invoice Number" }}</th>
                                                            <td>{{ $invoice->invoice_number }}</td>
                                                            <th>{{ "Invoice Date" }}</th>
                                                            <td>{{ $invoice->invoice_date }}</td>
                                                            <th>{{ "Due Date" }}</th>
                                                            <td>{{ $invoice->due_date }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>{{ "Section" }}</th>
                                                            <td>{{ $invoice->sections->section_name }}</td>
                                                            <th>{{ "Product" }}</th>
                                                            <td>{{ $invoice->product_name }}</td>
                                                            <th>{{ "Collection Amount" }}</th>
                                                            <td>{{ $invoice->collection_amount }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>{{ "Commission Amount" }}</th>
                                                            <td>{{ $invoice->commission_amount }}</td>
                                                            <th>{{ "Discount" }}</th>
                                                            <td>{{ $invoice->discount }}</td>
                                                            <th>{{ "Vat Rate" }}</th>
                                                            <td>{{ $invoice->vat_rate }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>{{ "Vat Value" }}</th>
                                                            <td>{{ $invoice->vat_value }}</td>
                                                            <th>{{ "Total" }}</th>
                                                            <td>{{ $invoice->total }}</td>
                                                            <th>{{ "Payment Status" }}</th>
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
                                                        </tr>
                                                        <tr>
                                                            <th>{{ "Created By" }}</th>
                                                            <td>{{ $invoice->created_by }}</td>
                                                            <th>{{ "Notes" }}</th>
                                                            <td>{{ $invoice->note }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tab-pane" id="tab2">
                                                @can('chnage-invoices-status')
                                                <div class="d-flex flex-row-reverse">
                                                    <a href="{{ route('payment_status.show', $invoice) }}" class="btn btn-primary mb-4">
                                                        <i class="fa fa-solid fa-money-bill"></i>
                                                        Change Payment Status
                                                    </a>
                                                </div>
                                                @endcan
                                                <table class="table table-striped table-hover mt-2">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>{{ "Invoice Number" }}</th>
                                                            <th>{{ "Section" }}</th>
                                                            <th>{{ "Product" }}</th>
                                                            <th>{{ "Payment Status" }}</th>
                                                            <th>{{ "Payment Date" }}</th>
                                                            <th>{{ "Note" }}</th>
                                                            <th>{{ "Created By" }}</th>
                                                            <th>{{ "Created At" }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php $id = 1; @endphp
                                                        @foreach ($invoice_details as $details)
                                                            <tr>
                                                                <td>{{ $id++ }}</td>
                                                                <td>{{ $details->invoice_number }}</td>
                                                                <td>{{ $details->section }}</td>
                                                                <td>{{ $details->product }}</td>
                                                                <td>
                                                                    @php
                                                                    if($details->value_status == 1) {
                                                                        $value = 'success'; }
                                                                    elseif($details->value_status == 2) {
                                                                        $value = 'warning'; }
                                                                    else {
                                                                        $value = 'danger'; }
                                                                    @endphp
                                                                    <span class="text-white badge bg-{{$value}}">
                                                                        {{ $details->status }}
                                                                    </span>
                                                                </td>
                                                                <td>{{ $details->payment_date }}</td>
                                                                <td>{{ $details->note }}</td>
                                                                <td>{{ $details->created_by }}</td>
                                                                <td>{{ $details->created_at }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="row tab-pane" id="tab3">
                                                @can('upload-files')
                                                <form class="col-lg-12" action="{{ route('attachment.update', $invoice->id) }}" enctype="multipart/form-data" method="POST" autocomplete="off">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label>Attachment - </label>
                                                        <small class="text-danger font-weight-bold">
                                                            Only PDF, JPG or PNG is accepted
                                                        </small>
                                                        <input type="hidden" name="invoice_number" value="{{ $invoice->invoice_number }}">
                                                        <input class="dropify" type="file" name="attachment" accept=".pdf, .jpg, .png, jpeg" data-height="150">
                                                        @error('attachment')
                                                            <small class="text-danger">
                                                                {{ $message }}
                                                            </small>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-lg-12 text-right mt-2">
                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                        <hr>
                                                    </div>
                                                </form>
                                                @endcan
                                                @if(count($attachments) > 0)
                                                <table class="col-lg-12 table table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>{{ "Invoice Number" }}</th>
                                                            <th>{{ "Created By" }}</th>
                                                            <th>{{ "Created At" }}</th>
                                                            <th>{{ "Actions" }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php $id = 1; @endphp
                                                        @foreach ($attachments as $file)
                                                            <tr>
                                                                <td>{{ $id++ }}</td>
                                                                <td>{{ $file->invoice_number }}</td>
                                                                <td>{{ $file->created_by }}</td>
                                                                <td>{{ $file->created_at }}</td>
                                                                <td>
                                                                    <a href="{{ url($file->file_name) }}" target="_blank" class="btn btn-sm btn-primary">
                                                                        <i class="fa fa-solid fa-eye"></i>
                                                                    </a>
                                                                    <a href="{{ url($file->file_name) }}" class="btn btn-sm btn-info" download="">
                                                                        <i class="fa fa-solid fa-download"></i>
                                                                    </a>
                                                                    @can('delete-uploaded-files')
                                                                    <a href="#modal-delete" class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale" data-toggle="modal" data-file_id="{{ $file->id }}" data-file_name="{{ $file->file_name }}">
                                                                        <i class="fa fa-solid fa-trash"></i>
                                                                    </a>
                                                                    @endcan
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                @else
                                                <div class="text-center">There's no attachments!</div>
                                                @endif
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

@can('delete-uploaded-files')
<!-- Modal delete -->
<div class="modal" id="modal-delete">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Delete File</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('invoice_details/destroy') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="file_id" id="delete" value="">
                    <input type="hidden" name="file_name" id="file_name" value="">
                    <div class="col-12 mb-1">
                        <h5>
                            Are you sure you want to delete this file?
                        </h5>
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
<!--Internal Fileuploads js-->
<script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
<!--Internal Fancy uploader js-->
<script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
<!-- Internal Modal js-->
<script src="{{URL::asset('assets/js/modal.js')}}"></script>
<script>
    $(document).ready(function(){
        setTimeout(function () {
            $('.alert').fadeOut(function () {
                $('#alert').remove()
            })
        }, 5000);
    })

    $('#modal-delete').on('show.bs.modal', function(event) {
        let button = $(event.relatedTarget)
        let file_id = button.data('file_id')
        let file_name = button.data('file_name')
        let modal = $(this)
        modal.find('.modal-body #delete').val(file_id);
        modal.find('.modal-body #file_name').val(file_name);
    })

    $(function() {
        $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
            localStorage.setItem('activeTab', $(e.target).attr('href'));
        });
        var activeTab = localStorage.getItem('activeTab');
        if(activeTab){
            $('#detailsTabs a[href="' + activeTab + '"]').tab('show');
        }
    })

</script>
@endsection
