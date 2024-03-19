<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\invoices;

class InvoicesReportController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:show-invoices-reports', [
            'only' => ['index']
        ]);
    }

    public function index(Request $request)
    {

        $invoices = invoices::orderBy('created_at', 'desc')->get();

        $status = [
            'All',
            'Paid',
            'Partially Paid',
            'Unpaid',
        ];

        $radio = $request->search_by;

        $invoice_number         = $request->invoice_number;
        $invoice_status         = $request->status;
        $invoice_date           = date($request->invoice_date);
        $due_date               = date($request->due_date);
        $from_date              = date($request->from_date);
        $to_date                = date($request->to_date);

        invoices::setWhiteListFilter([
            'invoice_number',
            'status',
            'invoice_date',
            'due_date'
        ]);

        if($radio == 'search_by_number')
        {
            $invoices = invoices::filter($request->only('invoice_number'))->get();

        } else if($radio == 'search_basic')
        {
            if($invoice_status == 'all' || empty($invoice_status))
            {
                $invoices = invoices::filter($request->only('invoice_date', 'due_date'))->get();
            } else {
                $invoices = invoices::filter($request->only('status', 'invoice_date', 'due_date'))->get();
            }

        } else if($radio == 'search_advance')
        {

            if($invoice_status == 'all' || empty($invoice_status))
            {
                $invoices = invoices::whereBetween('invoice_date', [$from_date, $to_date])->get();

            } else {
                $invoices = invoices::where('status', $invoice_status)
                ->whereBetween('invoice_date', [$from_date, $to_date])
                ->get();
            }

        }

        return view('reporting.invoices_report', [
            'invoices'              => $invoices,
            'status'                => $status,
            'invoice_number'        => $request->invoice_number,
            'invoice_status'        => $request->status,
            'invoice_date'          => $request->invoice_date,
            'due_date'              => $request->due_date,
            'from_date'             => $request->from_date,
            'to_date'               => $request->to_date,
        ]);
    }



}
