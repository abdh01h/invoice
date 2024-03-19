@extends('layouts.master')
@section('title') Payment Status for {{ $invoice->invoice_number }} @endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">
                                {{ __('Invoices') }}
                            </h4>
                            <a href="{{ route('invoice_details.index', $invoice) }}" class="text-muted mt-1 tx-13 mr-2 mb-0">
                                / {{ $invoice->invoice_number }}
                            </a>
                            <span class="text-muted mt-1 tx-13 mr-2 mb-0">
                                / Payment Status
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
						<div class="card mg-b-20">
							<div class="card-header pb-0">
								<div class="d-flex justify-content-between">
									<h4 class="card-title mg-b-0">{{ __('Change Payment Status for ') . $invoice->invoice_number }}</h4>
								</div>
							</div>
							<div class="card-body">
                                <form class="row" id="status_form" action="{{ route('payment_status.update', $invoice) }}" method="POST" autocomplete="off">
                                    @csrf
                                    @method('PATCH')
                                    <div class="form-group col-lg-12">
                                        <label>Invoice Number</label>
                                        <input class="form-control" type="text" id="invoice_number" value="{{ $invoice->invoice_number }}" disabled>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Payment Status</label>
                                        <select class="form-control @error('value_status') is-invalid @enderror" name="value_status" style="width: 100% !important">
                                            <option value="0" {{ $invoice->status == 'unpaid' ? 'selected' : '' }}>unpaid</option>
                                            <option value="1" {{ $invoice->status == 'paid' ? 'selected' : '' }}>paid</option>
                                            <option value="2" {{ $invoice->status == 'partially paid' ? 'selected' : '' }}>partially paid</option>
                                        </select>
                                        @error('value_status')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-6" >
                                        <label>Payment Date - </label>
                                        <small class="text-muted">Leave empty if there's no payment date</small>
                                        <input type="text" name="payment_date" id="payment_date" class="form-control fc-datepicker @error('payment_date') is-invalid @enderror" placeholder="Invoice Date" value="{{ old('payment_date') }}">
                                        @error('payment_date')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-12 text-right">
                                        <hr>
                                        <button class="btn btn-lg btn-primary" type="submit">Change</button>
                                    </div>
                                </form>
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
<!--Internal  Form-elements js-->
<script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
<script src="{{ URL::asset('assets/js/select2.js') }}"></script>
<!--Internal  Datepicker js -->
<script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
<script>

$(function() {
    // Datepicker
	$('.fc-datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
		showOtherMonths: true,
		selectOtherMonths: true,
        changeMonth: true,
        changeYear: true,
        yearRange: '1990:2100',
	});
})


</script>
@endsection
