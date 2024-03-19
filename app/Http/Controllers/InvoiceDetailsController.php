<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\InvoiceDetails;
use App\Models\InvoiceAttachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class InvoiceDetailsController extends Controller
{

    public function __construct(Request $request)
    {
        $inv = $request->path();
        $inv = explode('/', $inv);
        $inv = end($inv);

        $status_paid        = InvoiceDetails::where('invoice_id', $inv)
                                            ->where('value_status', 1)
                                            ->orderBy('created_at', 'desc')
                                            ->pluck('value_status')->first();
        $status_partially   = InvoiceDetails::where('invoice_id', $inv)
                                            ->where('value_status', 2)
                                            ->orderBy('created_at', 'desc')
                                            ->pluck('value_status')->first();

        if($status_paid  == 1) {

            $this->middleware('permission:paid-invoice-details', [
                'only' => ['index']
            ]);

        } else if($status_partially == 2) {

            $this->middleware('permission:partially-paid-invoice-details', [
                'only' => ['index']
            ]);

        } else {

            $this->middleware('permission:unpaid-invoice-details', [
                'only' => ['index']
            ]);

        }

        $this->middleware('permission:upload-files', [
            'only' => ['update']
        ]);

        $this->middleware('permission:delete-uploaded-files', [
            'only' => ['destroy']
        ]);
    }

    public function index(invoices $inv)
    {

        $invoice            = invoices::find($inv->id);
        $invoice_details    = InvoiceDetails::where('invoice_id', $invoice->id)->orderBy('created_at', 'DESC')->get();
        $attachments        = InvoiceAttachments::where('invoice_id', '=', $invoice->id)->orderBy('created_at', 'DESC')->get();

        return view('invoices.invoice_details', compact('invoice', 'invoice_details', 'attachments'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'attachment' => ['nullable', 'mimes:jpeg,jpg,png,pdf', 'max:2048'],
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
                'invoice_id'        => $id,
            ]);

            // Move File
            $file->move(public_path($path), $file_name);

            $request->session()->flash('type', __('success'));
            $request->session()->flash('title', __('File uploaded Successful'));
            $request->session()->flash('message', __('The File Has Been Successfully Uploaded.'));

        }

        return back();

    }

    public function destroy(Request $request)
    {

        InvoiceAttachments::find($request->file_id)->delete();

        if(file_exists(public_path($request->file_name))) {
            File::delete($request->file_name);
        }

        $request->session()->flash('type', __('success'));
        $request->session()->flash('title', __('Deleted Successful'));
        $request->session()->flash('message', __('The Attachment Has Been Successfully Deleted.'));

        return back();

    }
}
