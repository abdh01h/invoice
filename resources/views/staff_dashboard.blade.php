@extends('layouts.master')
@section('title', 'Dashboard')
@section('css')
@endsection
@section('page-header')
        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="my-auto">
                <div class="d-flex">
                    <h4 class="content-title mb-0 my-auto">
                        {{ __('Dashboard') }}
                    </h4>
                </div>
            </div>
        </div>
        <!-- /breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row row-sm mt-4">
					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden sales-card bg-primary-gradient">
							<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
								<div class="">
									<h6 class="mb-3 tx-12 text-white">TOTAL INVOICES</h6>
								</div>
								<div class="pb-0 mt-0">
									<div class="d-flex justify-content-between">
										<div class="">
											<h4 class="tx-20 font-weight-bold mb-1 text-white">
                                                {{
                                                    number_format(App\Models\invoices::sum('total'), 2)
                                                }}
                                            </h4>
											<p class="mb-0 tx-12 text-white op-7">
                                                {{ App\Models\invoices::count() }}
                                            </p>
										</div>
										<div class="">
											<span class="text-white op-7">100%</span>
										</div>
									</div>
								</div>
							</div>
							<span id="compositeline" class="pt-1">
                                @php
                                    $total_invoices = App\Models\invoices::orderBy('id', 'desc')->limit(10)->pluck('total');
                                    $copy = $total_invoices;
                                    foreach($total_invoices as $invoice) {
                                        echo round($invoice) . ',';
                                    }
                                @endphp
                            </span>
						</div>
					</div>
					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden sales-card bg-success-gradient">
							<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
								<div class="">
									<h6 class="mb-3 tx-12 text-white">PAID INVOICES</h6>
								</div>
								<div class="pb-0 mt-0">
									<div class="d-flex justify-content-between">
										<div class="">
											<h4 class="tx-20 font-weight-bold mb-1 text-white">
                                                {{ number_format(App\Models\invoices::where('value_status', 1)->sum('total'), 2) }}
                                            </h4>
											<p class="mb-0 tx-12 text-white op-7">
                                                {{ App\Models\invoices::where('value_status', 1)->count() }}
                                            </p>
										</div>
										<div class="">
											<span class="text-white op-7">
                                                {{
                                                    round(App\Models\invoices::where('value_status', 1)->count() /
                                                    App\Models\invoices::count() * 100)
                                                }}%
                                            </span>
                                        </div>
									</div>
								</div>
							</div>
							<span id="compositeline3" class="pt-1">
                                @php
                                    $total_invoices = App\Models\invoices::where('value_status', 1)->limit(10)->orderBy('id', 'desc')->pluck('total');
                                    $copy = $total_invoices;
                                    foreach($total_invoices as $invoice) {
                                        echo round($invoice) . ',';
                                    }
                                @endphp
                            </span>
						</div>
					</div>
					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden sales-card bg-warning-gradient">
							<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
								<div class="">
									<h6 class="mb-3 tx-12 text-white">PARTIALLY PAID INVOICES</h6>
								</div>
								<div class="pb-0 mt-0">
									<div class="d-flex justify-content-between">
										<div class="">
											<h4 class="tx-20 font-weight-bold mb-1 text-white">
                                                {{ number_format(App\Models\invoices::where('value_status', 2)->sum('total'), 2) }}
                                            </h4>
											<p class="mb-0 tx-12 text-white op-7">
                                                {{ App\Models\invoices::where('value_status', 2)->count() }}
                                            </p>
										</div>
										<div class="">
											<span class="text-white op-7">
                                                {{
                                                    round(App\Models\invoices::where('value_status', 2)->count() /
                                                    App\Models\invoices::count() * 100)
                                                }}%
                                            </span>
                                        </div>
									</div>
								</div>
							</div>
							<span id="compositeline4" class="pt-1">
                                @php
                                    $total_invoices = App\Models\invoices::where('value_status', 2)->limit(10)->orderBy('id', 'desc')->pluck('total');
                                    $copy = $total_invoices;
                                    foreach($total_invoices as $invoice) {
                                        echo round($invoice) . ',';
                                    }
                                @endphp
                            </span>
						</div>
					</div>
                    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden sales-card bg-danger-gradient">
							<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
								<div class="">
									<h6 class="mb-3 tx-12 text-white">UNPAID INVOICES</h6>
								</div>
								<div class="pb-0 mt-0">
									<div class="d-flex justify-content-between">
										<div class="">
											<h4 class="tx-20 font-weight-bold mb-1 text-white">
                                                {{ number_format(App\Models\invoices::where('value_status', 0)->sum('total'), 2) }}
                                            </h4>
											<p class="mb-0 tx-12 text-white op-7">
                                                {{ App\Models\invoices::where('value_status', 0)->count() }}
                                            </p>
										</div>
										<div class="">
											<span class="text-white op-7">
                                                {{
                                                    round(App\Models\invoices::where('value_status', 0)->count() /
                                                    App\Models\invoices::count() * 100)
                                                }}%
                                            </span>
                                        </div>
									</div>
								</div>
							</div>
							<span id="compositeline2" class="pt-1">
                                @php
                                    $total_invoices = App\Models\invoices::where('value_status', 0)->limit(10)->orderBy('id', 'desc')->pluck('total');
                                    $copy = $total_invoices;
                                    foreach($total_invoices as $invoice) {
                                        echo round($invoice) . ',';
                                    }
                                @endphp
                            </span>
						</div>
					</div>
				</div>
				<!-- row closed -->

				<!-- row opened -->
				<div class="row row-sm">
					<div class="col-md-12 col-lg-6 col-xl-6">
						<div class="card">
							<div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
								<div class="d-flex justify-content-between">
									<h4 class="card-title mb-0">Invoices Statistics Based on sections</h4>
									<i class="mdi mdi-dots-horizontal text-gray"></i>
								</div>
							</div>
							<div class="card-body">
								{!! $invoicesBasedOnSections->render() !!}
							</div>
						</div>
					</div>
                    <div class="col-md-12 col-lg-6 col-xl-6">
						<div class="card">
							<div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
								<div class="d-flex justify-content-between">
									<h4 class="card-title mb-0">Total Invoices Statistics</h4>
									<i class="mdi mdi-dots-horizontal text-gray"></i>
								</div>
							</div>
							<div class="card-body">
								{!! $totalInvoices->render() !!}
							</div>
						</div>
					</div>
				</div>
				<!-- row closed -->

			</div>
		</div>
		<!-- Container closed -->
@endsection
@section('js')
<!--Internal  Chart.bundle js -->
<script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>
<!--Internal  index js -->
<script src="{{URL::asset('assets/js/index.js')}}"></script>
@endsection
