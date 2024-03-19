<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\invoices;
use App\Models\InvoiceDetails;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\InvoicePaid;
use App\Notifications\InvoiceAdded;

class PaymentStatusController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:chnage-invoices-status', [
            'only' => ['show', 'update']
        ]);
    }

    public function show(invoices $invoice)
    {
        return view('invoices.payment_invoices', compact('invoice'));
    }

    public function update(Request $request, invoices $invoice)
    {

        $status = null;
        if($request->value_status == 1) {
            $status = 'paid';
        } else if($request->value_status == 2) {
            $status = 'partially paid';
        } else {
            $status = 'unpaid';
        }

        $request->validate([
            'value_status'      => ['required'],
            'payment_date'      => ['nullable', 'date_format:Y-m-d'],
        ]);

        $invoice->update([
            'status'          => $status,
            'value_status'    => $request->value_status,
        ]);

        $invoice_details = InvoiceDetails::where('invoice_id', $invoice->id)->orderBy('created_at', 'DESC')->first();

        $new_invoice_details                = $invoice_details->replicate();
        $new_invoice_details->status        = $status;
        $new_invoice_details->value_status  = $request->value_status;
        $new_invoice_details->payment_date  = $request->payment_date = isset($request->payment_date) ? $request->payment_date : null;
        $new_invoice_details->save();

        if($request->value_status == 1 && $status == 'paid') {

            // Email Notification
            // $user = User::first(); // to admin only
            // Notification::send($user, new InvoicePaid($invoice->id));
            // $user->notify(new InvoicePaid($invoice->id)); // Same as above

        }


        $request->session()->flash('type', __('success'));
        $request->session()->flash('title', __('Updated Successful'));
        $request->session()->flash('message', __('The Invoice Has Been Successfully Updated.'));

        return redirect('invoice_details/' . $invoice->id);

    }

}
