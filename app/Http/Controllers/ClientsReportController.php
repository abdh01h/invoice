<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\invoices;
use App\Models\sections;

class ClientsReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show-clients-reports', [
            'only' => ['index']
        ]);
    }

    public function index(Request $request)
    {

        $sections = sections::orderBy('updated_at', 'desc')->get();

        $section_id             = $request->section_id;
        $product_name           = $request->product_name;
        $from_date              = date($request->from_date);
        $to_date                = date($request->to_date);

        invoices::setWhiteListFilter([
            'section_id',
            'product_name',
        ]);


        if(!empty($section_id) && !empty($product_name) && empty($from_date) && empty($to_date))
        {

            $from_date = $to_date = null;

            if($section_id == 'all' && $product_name == 'all') {

                $invoices = invoices::all();

            } else if($section_id != 'all' && $product_name == 'all')
            {

                $invoices = invoices::filter($request->only('section_id'))->get();


            } else {

                $invoices = invoices::filter($request->only('section_id', 'product_name'))->get();
            }

        } else {

            if($section_id == 'all' && $product_name == 'all' || empty($section_id) && empty($product_name))
            {

                $invoices = invoices::whereBetween('invoice_date', [$from_date, $to_date])->get();

            } else if($section_id != 'all' && $product_name == 'all')
            {

                $invoices = invoices::whereBetween('invoice_date', [$from_date, $to_date])
                                    ->where('section_id', $section_id)
                                    ->get();
            } else {
                $invoices = invoices::whereBetween('invoice_date', [$from_date, $to_date])
                                    ->where('section_id', $section_id)
                                    ->where('product_name', $product_name)
                                    ->get();
            }

        }

        if (!count($request->all()))
        {
            $invoices = invoices::orderBy('created_at', 'desc')->get();
        }

        return view('reporting.clients_report', [
            'invoices'              => $invoices,
            'sections'              => $sections,
            'section_id'            => $section_id,
            'from_date'             => $request->from_date,
            'to_date'               => $request->to_date,
        ]);

    }


}
