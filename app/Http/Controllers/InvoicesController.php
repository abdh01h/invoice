<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\invoices;
use App\Models\InvoiceDetails;
use App\Models\InvoiceAttachments;
use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InvoicesExport;
use Illuminate\Support\Facades\Notification;
use App\Notifications\InvoiceAdded;

class InvoicesController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:show-all-invoices', [
            'only' => ['index']
        ]);
        $this->middleware('permission:show-paid-invoices', [
            'only' => ['paid']
        ]);
        $this->middleware('permission:show-partially-paid-invoices', [
            'only' => ['partially']
        ]);
        $this->middleware('permission:show-unpaid-invoices', [
            'only' => ['unpaid']
        ]);
        $this->middleware('permission:show-archived-invoices', [
            'only' => ['archive']
        ]);

        $this->middleware('permission:add-invoices', [
            'only' => ['create','store']
        ]);

        $this->middleware('permission:edit-invoices', [
            'only' => ['edit', 'update']
        ]);

        $this->middleware('permission:delete-invoices', [
            'only' => ['destroy']
        ]);

        $this->middleware('permission:export-invoices', [
            'only' => ['export_all']
        ]);
        $this->middleware('permission:export-paid-invoices', [
            'only' => ['export_paid']
        ]);
        $this->middleware('permission:export-partially-paid-invoices', [
            'only' => ['export_partially']
        ]);
        $this->middleware('permission:export-unpaid-invoices', [
            'only' => ['export_unpaid']
        ]);
        $this->middleware('permission:export-archived-invoices', [
            'only' => ['export_archived']
        ]);

        $this->middleware('permission:restore-archived-invoices', [
            'only' => ['restore']
        ]);

        $this->middleware('permission:print-invoices', [
            'only' => ['print']
        ]);


    }

    public function index()
    {
        $invoices = invoices::orderBy('created_at', 'desc')->get();

        return view('invoices.invoices', compact('invoices'));
    }

    public function create()
    {
        $sections = sections::orderBy('updated_at', 'desc')->get();
        return view('invoices.add_invoices', compact('sections'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'invoice_number'      => ['required'],
            'invoice_date'        => ['required', 'date_format:Y-m-d'],
            'due_date'            => ['required', 'date_format:Y-m-d'],
            'section'             => ['required'],
            'product'             => ['required'],
            'collection'          => ['required', 'numeric'],
            'commission'          => ['required', 'numeric'],
            'discount'            => ['required', 'numeric'],
            'vat_rate'            => ['required', 'numeric'],
            'vat_value'           => ['required', 'numeric'],
            'total'               => ['required', 'numeric'],
            'note'                => ['max:999'],
            'attachment'          => ['nullable', 'mimes:jpeg,jpg,png,pdf', 'max:2048'],
        ]);

        $request->invoice_date  = date('Y-m-d', strtotime($request->invoice_date));
        $request->due_date      = date('Y-m-d', strtotime($request->due_date));

        $product_id     = $request->product;
        $product_name   = sections::find($request->section)
                        ->products()
                        ->where('id', '=', $product_id)
                        ->pluck('product_name')[0];
        $product_name = str_replace('"', '', $product_name);

        $invoice = invoices::create([
            'invoice_number'        => $request->invoice_number,
            'invoice_date'          => $request->invoice_date,
            'due_date'              => $request->due_date,
            'section_id'            => $request->section,
            'product_name'          => $product_name,
            'collection_amount'     => $request->collection,
            'commission_amount'     => $request->commission,
            'discount'              => $request->discount,
            'vat_rate'              => $request->vat_rate,
            'vat_value'             => $request->vat_value,
            'total'                 => $request->total,
            'status'                => 'unpaid',
            'value_status'          => 0,
            'note'                  => $request->note,
            'created_by'            => (Auth::user()->name),
        ]); // You can do it in one line but name must be same with columns in database

        $invoice_id     = $invoice->id;
        $section_id     = $invoice->section_id;
        $section_name   = sections::where('id', '=', $section_id)->pluck('section_name')[0];
        $section_name   = str_replace('"', '', $section_name);

        InvoiceDetails::create([
            'invoice_id'        => $invoice_id,
            'invoice_number'    => $request->invoice_number,
            'section'           => $section_name,
            'product'           => $product_name,
            'status'            => 'unpaid',
            'value_status'      => 0,
            'note'              => $request->note,
            'created_by'        => (Auth::user()->name),
        ]);

        if ($request->hasFile('attachment')) {

            $file           = $request->file('attachment');
            $file_name      = $request->file('attachment')->getClientOriginalName();
            $invoice_number = $request->invoice_number;
            $path           = 'storage/attachments/invoices/' . $invoice_number;

            InvoiceAttachments::create([
                'file_name'         => $path . '/' . $file_name,
                'invoice_number'    => $invoice_number,
                'created_by'        => Auth::user()->name,
                'invoice_id'        => $invoice_id,
            ]);

            // Move File
            $file->move(public_path($path), $file_name);
        }

        // Dtatabase Notification
        $invoice_number    = $invoice->invoice_number;
        $user              = $invoice->created_by;
        $send_to           = User::first();
        $send_to->notify(new InvoiceAdded($invoice_id, $invoice_number, $user));

        // $user = User::first();
        // $invoices = invoices::latest()->first();
        // Notification::send($user, new InvoiceAdded($invoices));
        // event(new MyEventClass('hello world'));

        $request->session()->flash('type', __('success'));
        $request->session()->flash('title', __('Created Successful'));
        $request->session()->flash('message', __('The Invoice Has Been Successfully Created.'));

        return redirect('invoice_details/' . $invoice_id);
    }

    public function show(invoices $invoices)
    {
        return back();
    }

    public function edit(invoices $invoice)
    {
        $sections    = sections::orderBy('updated_at', 'desc')->get();
        $product_id  = sections::find($invoice->section_id)
                            ->products()
                            ->where('product_name', $invoice->product_name)
                            ->pluck('id');

        return view('invoices.edit_invoices', compact('sections' ,'invoice', 'product_id'));
    }

    public function update(Request $request, invoices $invoice)
    {

        $request->validate([
            'invoice_date'        => ['required', 'date_format:Y-m-d'],
            'due_date'            => ['required', 'date_format:Y-m-d'],
            'section'             => ['required'],
            'product'             => ['required'],
            'collection'          => ['required', 'numeric'],
            'commission'          => ['required', 'numeric'],
            'discount'            => ['required', 'numeric'],
            'vat_rate'            => ['required', 'numeric'],
            'vat_value'           => ['required', 'numeric'],
            'total'               => ['required', 'numeric'],
            'note'                => ['max:999'],
        ]);

        $request->invoice_date  = date('Y-m-d', strtotime($request->invoice_date));
        $request->due_date      = date('Y-m-d', strtotime($request->due_date));

        $product_id     = $request->product;
        $product_name   = sections::find($request->section)
                        ->products()
                        ->where('id', '=', $product_id)
                        ->pluck('product_name')[0];
        $product_name = str_replace('"', '', $product_name);

        $invoice->update([
            'invoice_date'          => $request->invoice_date,
            'due_date'              => $request->due_date,
            'section_id'            => $request->section,
            'product_name'          => $product_name,
            'collection_amount'     => $request->collection,
            'commission_amount'     => $request->commission,
            'discount'              => $request->discount,
            'vat_rate'              => $request->vat_rate,
            'vat_value'             => $request->vat_value,
            'total'                 => $request->total,
            'note'                  => $request->note,
        ]);

        $invoice_id     = $invoice->id;
        $section_id     = $invoice->section_id;
        $section_name   = sections::where('id', '=', $section_id)->pluck('section_name')[0];
        $section_name   = str_replace('"', '', $section_name);

        InvoiceDetails::where('invoice_id', $invoice_id)->update([
            'section'           => $section_name,
            'product'           => $product_name,
            'note'              => $request->note,
        ]);

        $request->session()->flash('type', __('success'));
        $request->session()->flash('title', __('Updated Successful'));
        $request->session()->flash('message', __('The Invoice Has Been Successfully Updated.'));

        return redirect('invoice_details/' . $invoice_id);
    }

    public function destroy(Request $request)
    {

        $id = $request->invoice_id;
        $invoice = invoices::withTrashed()->where('id', $id);
        $invoice_number = $invoice->pluck('invoice_number')->first();

        if($request->exists('archive') && $request->archive == 'archive') {

            $invoice->delete();

            $request->session()->flash('type', __('success'));
            $request->session()->flash('title', __('Archived Successful'));
            $request->session()->flash('message', __('The Invoice Has Been Successfully Archived.'));

            return back();

        } else if($request->exists('delete') && $request->delete == 'delete') {

            $path = 'storage/attachments/invoices/' . $invoice_number;

            $invoice->forceDelete();

            if(isset($invoice_number) && File::exists(public_path($path))) {
                File::deleteDirectory(public_path($path));
            }

            $request->session()->flash('type', __('success'));
            $request->session()->flash('title', __('Deleted Successful'));
            $request->session()->flash('message', __('The Invoice Has Been Successfully Deleted.'));

            return back();

        } else {

            return back();
        }

    }

    public function restore(Request $request)
    {
        $invoice = invoices::onlyTrashed()->where('id', $request->invoice_id)->first();

        $invoice->restore();

        $request->session()->flash('type', __('success'));
        $request->session()->flash('title', __('Restored Successful'));
        $request->session()->flash('message', __('The Invoice Has Been Successfully Restored.'));

        return back();

    }

    public function get_products($id)
    {
        $products = sections::find($id)->products()->pluck('product_name', 'id');
        return json_decode($products); // For ajax request
    }

    public function print(invoices $invoice)
    {
        return view('invoices.print_invoice', compact('invoice'));
    }

    public function paid()
    {
        $invoices = invoices::where('value_status', 1)->orderBy('created_at', 'desc')->get();

        return view('invoices.invoices_paid', compact('invoices'));
    }


    public function partially()
    {
        $invoices = invoices::where('value_status', 2)->orderBy('created_at', 'desc')->get();

        return view('invoices.invoices_partially', compact('invoices'));
    }

    public function unpaid()
    {
        $invoices = invoices::where('value_status', 0)->orderBy('created_at', 'desc')->get();

        return view('invoices.invoices_unpaid', compact('invoices'));
    }

    public function archive()
    {
        $invoices = invoices::onlyTrashed()->orderBy('created_at', 'desc')->get();

        return view('invoices.invoices_archive', compact('invoices'));
    }

    public function export_all()
    {
        return Excel::download(new InvoicesExport('all'), 'all_invoices.xlsx');
    }

    public function export_paid()
    {
        return Excel::download(new InvoicesExport('paid'), 'paid_invoices.xlsx');
    }

    public function export_partially()
    {
        return Excel::download(new InvoicesExport('partially'), 'partially_paid_invoices.xlsx');
    }

    public function export_unpaid()
    {
        return Excel::download(new InvoicesExport('unpaid'), 'unpaid_invoices.xlsx');
    }

    public function export_archived()
    {
        return Excel::download(new InvoicesExport('archived'), 'archived_invoices.xlsx');
    }


}
