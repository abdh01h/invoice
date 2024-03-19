<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\invoices;
use App\Models\sections;
use Spatie\Activitylog\Models\Activity;;
use DataTables;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:staff-dashboard', [
            'only' => ['staff_dashboard']
        ]);
        $this->middleware('permission:admin-dashboard', [
            'only' => ['admin_dashboard']
        ]);
    }

    protected function staff_dashboard()
    {

        $section_names = sections::pluck('section_name')->toArray();
        $section_ids = sections::pluck('id')->toArray();

        foreach($section_ids as $id)
        {
            $paid_invoices[] = invoices::where('section_id', $id)->where('value_status', 1)->sum('total');
        }

        foreach($section_ids as $id)
        {
            $partially_paid_invoices[] = invoices::where('section_id', $id)->where('value_status', 2)->sum('total');
        }

        foreach($section_ids as $id)
        {
            $unpaid_invoices[] = invoices::where('section_id', $id)->where('value_status', 0)->sum('total');
        }

        $total_paid = invoices::where('value_status', 1)->sum('total');
        $total_partially_paid = invoices::where('value_status', 2)->sum('total');
        $total_unpaid = invoices::where('value_status', 0)->sum('total');

        for($x = 0; $x < count($paid_invoices); $x++) {
            $green[$x] = '#43AA8B';
        }
        for($x = 0; $x < count($partially_paid_invoices); $x++) {
            $yellow[$x] = '#F9C74F';
        }
        for($x = 0; $x < count($unpaid_invoices); $x++) {
            $red[$x] = '#F94144';
        }

        $invoicesBasedOnSections = app()->chartjs
        ->name('barChart')
        ->type('bar')
        ->size(['width' => 400, 'height' => 200])
        ->labels($section_names)
        ->datasets([
            [
                "label" => "Paid Invoices",
                'backgroundColor' => $green,
                'data' => $paid_invoices
            ],
            [
                "label" => "Partially Paid Invoices",
                'backgroundColor' => $yellow,
                'data' => $partially_paid_invoices
            ],
            [
                "label" => "Unpaid Invoices",
                'backgroundColor' => $red,
                'data' => $unpaid_invoices
            ],
        ])
        ->options([]);

        $totalInvoices = app()->chartjs
        ->name('pieChartTest')
        ->type('pie')
        ->size(['width' => 400, 'height' => 200])
        ->labels(['Paid Invoices', 'Partially Paid Invoices', 'Unpaid Invoices'])
        ->datasets([
            [
                'backgroundColor' => ['#43AA8B', '#F9C74F', '#F94144'],
                'data' => [$total_paid, $total_partially_paid, $total_unpaid]
            ]
        ])
        ->options([]);

        return view('staff_dashboard', compact('invoicesBasedOnSections', 'totalInvoices'));
    }


    protected function admin_dashboard()
    {

        if(request()->ajax()){

            $data = Activity::with(['causer' => function ($query) {
                $query->select('id', 'name');
            }])->latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function($row) {
                    return date('Y-m-d H:i:s', strtotime($row->created_at));
                })
                ->make(true);
        }

        return view('admin_dashboard');
    }

    public function index()
    {

        if(Auth::user()->hasPermissionTo('admin-dashboard'))
        {

            return $this->admin_dashboard();

        } else if(Auth::user()->hasPermissionTo('staff-dashboard'))
        {

            return $this->staff_dashboard();

        } else
        {
            abort(404);
        }

    }

}
