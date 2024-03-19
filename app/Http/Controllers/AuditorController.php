<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Spatie\Activitylog\Facades\LogBatch;
use Spatie\Activitylog\Models\Activity;;
use DataTables;



class AuditorController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show-audit-trail', [
            'only' => ['index']
        ]);
    }

    public function index()
    {

        $audits = Activity::with('causer')->latest()->limit(250)->get();

        foreach($audits as $audit) {
            $audit->subject_type = str_replace('App\\Models\\', '', $audit->subject_type);
            $audit->causer_type = str_replace('App\\Models\\', '', $audit->causer_type);
        }

        return view('auditor.index', compact('audits'));

    }

}
