<?php

namespace App\Exports;

use App\Models\invoices;
use Maatwebsite\Excel\Concerns\FromCollection;

class InvoicesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $type = 'all';

    public function __construct($t)
    {
        $this->type = $t;
    }

    public function collection()
    {

        if($this->type == 'all')
        {

            return invoices::all();

        } else if($this->type == 'paid') {

            return invoices::where('value_status', 1)->get();

        } else if($this->type == 'partially') {

            return invoices::where('value_status', 2)->get();

        } else if($this->type == 'unpaid') {

            return invoices::where('value_status', 0)->get();

        } else if($this->type == 'archived') {

            return invoices::onlyTrashed()->get();

        } else {

            abort(404);
        }


    }


}
