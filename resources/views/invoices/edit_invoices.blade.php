@extends('layouts.master')
@section('title') Edit {{ $invoice->invoice_number }} @endsection
@section('css')
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
                                / Edit
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
					<div class="col-xl-10">
                        @include('partials.multi_alert')
						<div class="card mg-b-20">
							<div class="card-header pb-0">
								<div class="d-flex justify-content-between">
									<h4 class="card-title mg-b-0">{{ __('Edit ') . $invoice->invoice_number }}</h4>
								</div>
							</div>
							<form class="card-body row" action="{{ route('invoices.update', $invoice) }}" enctype="multipart/form-data" method="POST" autocomplete="off" onchange="calc()">
                                @csrf
                                @method('PUT')
                               @include('invoices.form', ['submitText' => __('Save')])
                            </form>
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
<!--Internal  jquery.maskedinput js -->
<script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
<!--Internal  spectrum-colorpicker js -->
<script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
<!-- Internal form-elements js -->
<script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
<script>

$(function(){
        setTimeout(function () {
            $('.alert').fadeOut(function () {
                $('#alert').remove()
            })
        }, 5000);
})

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

$(function() {
    $('select[name="section"]').on('change', function() {
        var section_id = $(this).val();
        if (section_id) {
            $.ajax({
                url: "{{ URL::to('section') }}/" + section_id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('select[name="product"]').empty();
                    $.each(data, function(key, value) {
                        $('select[name="product"]').append('<option value="' +
                            key + '">' + value + '</option>');
                    });
                },
            });
        } else {
            $('select[name="product"]').empty();
        }
    });
});

function calc() {
    let commission = parseFloat(document.getElementById("commission").value);
    let discount = parseFloat(document.getElementById("discount").value);
    let vat_rate = parseFloat(document.getElementById("vat_rate").value);
    let vat_value = parseFloat(document.getElementById("vat_value").value);
    let commission2 = commission - discount;

    let intResults = commission2 * vat_rate / 100;
    let intResults2 = parseFloat(intResults + commission2);
    sumq = parseFloat(intResults).toFixed(2);
    sumt = parseFloat(intResults2).toFixed(2);
    document.getElementById("vat_value").value = sumq;
    document.getElementById("total").value = sumt;

}

</script>
@endsection
