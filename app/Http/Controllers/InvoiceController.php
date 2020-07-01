<?php

namespace App\Http\Controllers;

use App\GeneralSetting;
use App\Invoice;
use Illuminate\Http\Request;
use App\Order;
use Barryvdh\DomPDF\Facade as PDF;
use MPDF;
use Auth;

class InvoiceController extends Controller
{
    //downloads customer invoice

    public function index()
    {
            $invoices = Invoice::first();
        return view('business_settings.invoice', compact("invoices"));
    }

    public function save_form(Request $request)
    {
        $invoice = Invoice::first();
        $invoice ->name_english = $request ->name_english;
        $invoice ->name_arabic = $request ->name_arabic;
        $invoice ->vat_no = $request ->vat;


        if($invoice ->save()){
            flash('Invoice Setting updated successfully')->success();
            return redirect()->back();
        }
        else{
            flash('Something went wrong')->error();
            return redirect()->back();
        }

    }
    public function customer_invoice_download($id)
    {
        $order = Order::findOrFail($id);
        return MPDF::loadView('invoices.customer_invoice', compact('order'))->download('order-'.$order->code.'.pdf');
    }

    //downloads seller invoice
    public function seller_invoice_download($id)
    {
        $order = Order::findOrFail($id);
        return MPDF::loadView('invoices.seller_invoice', compact('order'))->download('order-'.$order->code.'.pdf');
    }


    //downloads admin invoice
    public function admin_invoice_download($id)
    {
        $order = Order::findOrFail($id);
        return MPDF::loadView('invoices.seller_invoice', compact('order'))->download('order-'.$order->code.'.pdf');
    }
}
