@extends('layouts.master')
@section('title', 'Invoices Report')
@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<!-- Interenal Accordion Css -->
<link href="{{URL::asset('assets/plugins/accordion/accordion.css')}}" rel="stylesheet" />
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">
                                {{ __('Reports') }}
                            </h4>
                            <span class="text-muted mt-1 tx-13 mr-2 mb-0">
                                / {{ __('Invoices Report') }}
                            </span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row">

                    <div class="col-xl-12 mb-4">
						<div id="accordion" class="w-100 br-2 overflow-hidden">
                            <div class="">
                                <div class="accor bg-primary" id="headingOne1">
                                    <h4 class="m-0">
                                        <a href="#collapseOne1" class="" data-toggle="collapse" aria-expanded="true" aria-controls="collapseOne">
                                           Filter Options
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseOne1" class="collapse show bg-white" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="border p-3">
                                        <form class="row" action="{{ url('invoices_report') }}" method="GET" autocomplete="off">

                                            <div class="col-lg-12 form-group">
                                                <div class="row mg-t-10">
                                                    <div class="col-lg-3">
                                                        <label class="rdiobox">
                                                            <input name="search_by" type="radio" id="search_by_number" value="search_by_number" checked>
                                                            <span>Invoice Number</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <label class="rdiobox">
                                                            <input name="search_by" type="radio" id="search_basic" value="search_basic">
                                                            <span>Basic Filter</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <label class="rdiobox">
                                                            <input name="search_by" type="radio" id="search_advance" value="search_advance">
                                                            <span>Advance Filter</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12" id="by_number">
                                                <div class="row">
                                                    <div class="form-group col-lg-12">
                                                        <label>Invoice Number</label>
                                                        <input type="text" name="invoice_number" class="form-control @error('invoice_number') is-invalid @enderror" placeholder="Invoice Number" value="{{ $invoice_number }}">
                                                        @error('invoice_number')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="form-group col-lg-12" id="status" style="display: none">
                                                        <label>Invoice Status</label>
                                                        <select class="form-control" name="status">
                                                            <option selected disabled>Select Invoice Status</option>
                                                            @foreach ($status as $status)
                                                                <option value="{{ strtolower($status) }}"
                                                                {{ isset($invoice_status) && $invoice_status == strtolower($status) ? 'selected' : '' }}>
                                                                    {{ $status }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-12" id="basic_filter" style="display: none">
                                                        <div class="row">
                                                            <div class="form-group col-lg-6">
                                                                <label>Invoice Date</label>
                                                                <input type="text" name="invoice_date" id="" class="form-control fc-datepicker @error('invoice_date') is-invalid @enderror" placeholder="YYYY-MM-DD" value="{{ $invoice_date }}">
                                                                @error('invoice_date')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group col-lg-6">
                                                                <label>Due Date</label>
                                                                <input type="text" name="due_date" id="" class="form-control fc-datepicker @error('due_date') is-invalid @enderror" placeholder="YYYY-MM-DD" value="{{ $due_date }}">
                                                                @error('due_date')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12" id="advance_filter" style="display: none">
                                                        <div class="row">
                                                            <div class="form-group col-lg-6">
                                                                <label>From Date</label>
                                                                <input type="text" name="from_date" id="" class="form-control fc-datepicker @error('from_date') is-invalid @enderror" placeholder="YYYY-MM-DD" value="{{ $from_date }}">
                                                                @error('from_date')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group col-lg-6">
                                                                <label>To Date</label>
                                                                <input type="text" name="to_date" id="" class="form-control fc-datepicker @error('to_date') is-invalid @enderror" placeholder="YYYY-MM-DD" value="{{ $to_date }}">
                                                                @error('to_date')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="form-group col-lg-12 text-center">
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="fa fa-solid fa-filter"></i>
                                                            Filter
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
					</div>
                    <!--div-->
					<div class="col-xl-12">
						<div class="card mg-b-20">
							<div class="card-header pb-0">
								<div class="d-flex justify-content-between">
									<h4 class="card-title mg-b-0">Invoices Report</h4>
									<div class="btn-icon-list btn-list"></div>
								</div>
								<p class="tx-12 tx-gray-500 mb-2">
                                    Filter and Export invoices
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
<!--- Internal Accordion Js -->
<script src="{{URL::asset('assets/plugins/accordion/accordion.min.js')}}"></script>
<script src="{{URL::asset('assets/js/accordion.js')}}"></script>
<!--Internal  Datepicker js -->
<script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
<script>
    $(function(e) {
      let table = $('#datatable').DataTable({
        "aLengthMenu": [
              [10, 25, 50, 100, -1],
              [10, 25, 50, 100, "All"]
          ],
        "iDisplayLength": 10,
        "aaSorting": [],
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });
    });

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

    $(document).ready(function() {
        setTimeout(function () {
            $('.alert').fadeOut(function () {
                $('#alert').remove()
            })
        }, 5000);
    })

    $(document).ready(function() {
        $('#basic_filter').css('display', 'none');
        $('#advance_filter').css('display', 'none');
        $("#search_by_number").click(function() {
            $('#by_number').show();
            $('#status').hide();
            $('#basic_filter').hide();
            $('#advance_filter').hide();
        });
        $("#search_basic").click(function() {
            $('#by_number').hide();
            $('#advance_filter').hide();
            $('#status').show();
            $('#basic_filter').show();
        });
        $("#search_advance").click(function() {
            $('#by_number').hide();
            $('#basic_filter').hide();
            $('#status').show();
            $('#advance_filter').show();
        });
    })

</script>
@endsection
