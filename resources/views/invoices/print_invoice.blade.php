@extends('layouts.master')
@section('title') Print {{ $invoice->invoice_number }} @endsection
@section('css')
<style>
@media print {
    #print_button {
        display: none;
    }
}
</style>
@endsection
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
                                / Print
                            </span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row row-sm">
					<div class="col-md-12 col-xl-12">
						<div class="main-content-body-invoice" id="print">
							<div class="card card-invoice">
								<div class="card-body">
									<div class="invoice-header">
										<h1 class="invoice-title">Invoice ({{ config('app.name') }})</h1>
										<div class="billed-from">
											<h6>BootstrapDash, SDN BHD.</h6>
											<p>201 Something St., Something Town, YT 242, Country 6546<br>
											Email: abdullah-aldarkhbani@gmail.com</p>
										</div><!-- billed-from -->
									</div><!-- invoice-header -->
									<div class="row mg-t-20">
										<div class="col-md">
											<label class="tx-gray-600">Billed To</label>
											<div class="billed-to">
												<h6>Juan Dela Cruz</h6>
												<p>4033 Patterson Road, Staten Island, NY 10301<br>
												Tel No: 324 445-4544<br>
												Email: youremail@companyname.com</p>
											</div>
										</div>
										<div class="col-md">
											<label class="tx-gray-600">Invoice Information</label>
											<p class="invoice-info-row"><span>Invoice No</span> <span>
                                                {{ $invoice->invoice_number }}
                                            </span></p>
											<p class="invoice-info-row"><span>Issue Date:</span> <span>
                                                {{ date('d F, Y', strtotime($invoice->invoice_date)) }}
                                            </span></p>
											<p class="invoice-info-row"><span>Due Date:</span><span>
                                                {{ date('d F, Y', strtotime($invoice->due_date)) }}
                                            </span></p>
										</div>
									</div>
									<div class="table-responsive mg-t-40">
										<table class="table table-invoice border text-md-nowrap mb-0">
											<thead>
												<tr>
													<th class="wd-20p">Section</th>
													<th class="wd-40p">Product</th>
													<th class="tx-center">Collection Amount</th>
													<th class="tx-right">Commission Amount</th>
													<th class="tx-right">Total</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>{{ $invoice->sections->section_name }}</td>
													<td class="tx-12">{{ $invoice->product_name }}</td>
													<td class="tx-center">
                                                        {{ number_format($invoice->collection_amount, 2) }}
                                                    </td>
													<td class="tx-right">
                                                        {{ number_format($invoice->commission_amount, 2) }}
                                                    </td>
													<td class="tx-right">
                                                        @php $total = $invoice->collection_amount +  $invoice->commission_amount @endphp
                                                        {{ number_format($total, 2) }}
                                                    </td>
												</tr>
												<tr>
													<td class="valign-middle" colspan="2" rowspan="4">
														<div class="invoice-notes">
															<label class="main-content-label tx-13">Notes</label>
															<p></p>
														</div>
													</td>
													<td class="tx-right">Total</td>
													<td class="tx-right" colspan="2">
                                                        {{ number_format($total, 2) }}
                                                    </td>
												</tr>
												<tr>
													<td class="tx-right">Vat Rate</td>
													<td class="tx-right" colspan="2">
                                                        {{ number_format($invoice->vat_rate, 2) }}
                                                    </td>
												</tr>
												<tr>
													<td class="tx-right">Discount</td>
													<td class="tx-right" colspan="2">
                                                        {{ number_format($invoice->discount, 2) }}
                                                    </td>
												</tr>
												<tr>
													<td class="tx-right tx-uppercase tx-bold tx-inverse">Total Inc. VAT</td>
													<td class="tx-right" colspan="2">
														<h4 class="tx-primary tx-bold">
                                                            {{ number_format($invoice->total, 2) }}
                                                        </h4>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
									<hr class="mg-b-40">
									<button class="btn btn-danger float-left mt-3 mr-2" id="print_button" onclick="print_invoice()">
										<i class="mdi mdi-printer ml-1"></i>
                                        Print
									</button>
								</div>
							</div>
						</div>
					</div><!-- COL-END -->
				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->

@endsection
@section('js')
<!--Internal  Chart.bundle js -->
<script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>
<script>
    function print_invoice() {
        let printContents = document.getElementById('print').innerHTML;
        let originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload();
    }
</script>
@endsection
