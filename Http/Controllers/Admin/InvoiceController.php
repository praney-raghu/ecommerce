<?php

namespace Modules\ECommerce\Http\Controllers\Admin;

use Neev;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\ECommerce\Models\Order;
use Modules\ECommerce\Models\Invoice;
use Ssntpl\Neev\Http\Controllers\Controller;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::where('invoices.organisation_id', Neev::organisation()->getKey())->get();
        //dd($invoices);
        return view('neev::admin.catalogue.invoice.index')->with('invoices', $invoices);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // For getting orders list for corresponding organisation
        $order = new Order();
        $orders = $order->getOrdersDetail();
        //dd($orders);
        return view('neev::admin.catalogue.invoice.create')->with('orders', $orders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        // creating new entry in Invoice table // Todo
        $invoice = Invoice::create([
            'organisation_id' => Neev::organisation()->getKey(),
            'status' => $request->status,
            'invoice_date' => $request->invoice_date,
            'invoice_number' => $request->invoice_number,
            'po_number' => $request->po_number,
            'due_date' => $request->due_date,

            'bill_name' => $request->bill_name,
            'bill_address' => $request->bill_address,
            'bill_state' => $request->bill_state,
            'bill_country' => $request->bill_country,
            'bill_zip' => $request->bill_zip,
            'bill_taxcode_name' => $request->bill_taxcode_name,
            'bill_taxcode_number' => $request->bill_taxcode_number,
            'bill_field_name_1' => $request->bill_field_name_1,
            'bill_field_value_1' => $request->bill_field_value_1,
            'bill_field_name_2' => $request->bill_field_name_2,
            'bill_field_value_2' => $request->bill_field_value_2,

            'ship_name' => $request->ship_name,
            'ship_address' => $request->ship_address,
            'ship_state' => $request->ship_state,
            'ship_country' => $request->ship_country,
            'ship_zip' => $request->ship_zip,
            'ship_taxcode_name' => $request->ship_taxcode_name,
            'ship_taxcode_number' => $request->ship_taxcode_number,
            'ship_field_name_1' => $request->ship_field_name_1,
            'ship_field_value_1' => $request->ship_field_value_1,
            'ship_field_name_2' => $request->ship_field_name_2,
            'ship_field_value_2' => $request->ship_field_value_2,

            'seller_name' => $request->seller_name,
            'seller_address' => $request->seller_address,
            'seller_state' => $request->seller_state,
            'seller_country' => $request->seller_country,
            'seller_zip' => $request->seller_zip,
            'seller_taxcode_name' => $request->seller_taxcode_name,
            'seller_taxcode_number' => $request->seller_taxcode_number,
            'seller_field_name_1' => $request->seller_field_name_1,
            'seller_field_value_1' => $request->seller_field_value_1,
            'seller_field_name_2' => $request->seller_field_name_2,
            'seller_field_value_2' => $request->seller_field_value_2,

            'amount' => $request->amount,
            'currency' => $request->currency,
            'amount_base_currency' => $request->amount_base_currency,
            'base_currency' => $request->base_currency,
            'currency_rate' => $request->currency_rate,
            'terms' => $request->terms,
            'footer' => $request->footer,
            'private_notes' => $request->private_notes,
        ]);

        $invoice_id = $invoice->id;
        $request->selected_orders = trim($request->selected_orders, ',');
        $arr = explode(',', $request->selected_orders);

        //dd($request->selected_orders);
        foreach ($arr as $key => $value) {
            DB::table('invoice_order')->insert([
                'invoice_id' => $invoice_id,
                'order_id' => $value,
            ]);
        }
        return redirect(route('admin.invoice.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        $order = new Order();
        $orders = $order->getOrdersDetail();
        $invoice_orders = DB::table('invoice_order')->where('invoice_id', $invoice->id)->get();

        $selected_orders = [];
        foreach ($invoice_orders as $value) {
            array_push($selected_orders, $value->order_id);
        }
        //dd(json_encode($selected_orders));
        return view('neev::admin.catalogue.invoice.edit')->with(['invoice' => $invoice, 'orders' => $orders, 'selected_orders' => $selected_orders]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        // Updating Invoice table    // Todo

        //dd($request);

        $invoice->organisation_id = Neev::organisation()->getKey();
        $invoice->status = $request->status;
        $invoice->invoice_date = $request->invoice_date;
        $invoice->invoice_number = $request->invoice_number;
        $invoice->po_number = $request->po_number;
        $invoice->due_date = $request->due_date;

        $invoice->bill_name = $request->bill_name;
        $invoice->bill_address = $request->bill_address;
        $invoice->bill_state = $request->bill_state;
        $invoice->bill_country = $request->bill_country;
        $invoice->bill_zip = $request->bill_zip;
        $invoice->bill_taxcode_name = $request->bill_taxcode_name;
        $invoice->bill_taxcode_number = $request->bill_taxcode_number;
        $invoice->bill_field_name_1 = $request->bill_field_name_1;
        $invoice->bill_field_value_1 = $request->bill_field_value_1;
        $invoice->bill_field_name_2 = $request->bill_field_name_2;
        $invoice->bill_field_value_2 = $request->bill_field_value_2;

        $invoice->ship_name = $request->ship_name;
        $invoice->ship_address = $request->ship_address;
        $invoice->ship_state = $request->ship_state;
        $invoice->ship_country = $request->ship_country;
        $invoice->ship_zip = $request->ship_zip;
        $invoice->ship_taxcode_name = $request->ship_taxcode_name;
        $invoice->ship_taxcode_number = $request->ship_taxcode_number;
        $invoice->ship_field_name_1 = $request->ship_field_name_1;
        $invoice->ship_field_value_1 = $request->ship_field_value_1;
        $invoice->ship_field_name_2 = $request->ship_field_name_2;
        $invoice->ship_field_value_2 = $request->ship_field_value_2;

        $invoice->seller_name = $request->seller_name;
        $invoice->seller_address = $request->seller_address;
        $invoice->seller_state = $request->seller_state;
        $invoice->seller_country = $request->seller_country;
        $invoice->seller_zip = $request->seller_zip;
        $invoice->seller_taxcode_name = $request->seller_taxcode_name;
        $invoice->seller_taxcode_number = $request->seller_taxcode_number;
        $invoice->seller_field_name_1 = $request->seller_field_name_1;
        $invoice->seller_field_value_1 = $request->seller_field_value_1;
        $invoice->seller_field_name_2 = $request->seller_field_name_2;
        $invoice->seller_field_value_2 = $request->seller_field_value_2;

        $invoice->amount = $request->amount;
        $invoice->currency = $request->currency;
        $invoice->amount_base_currency = $request->amount_base_currency;
        $invoice->base_currency = $request->base_currency;
        $invoice->currency_rate = $request->currency_rate;
        $invoice->terms = $request->terms;
        $invoice->footer = $request->footer;
        $invoice->private_notes = $request->private_notes;

        $invoice->save();

        // foreach($request->order as $order)
        // {
        //     DB::table('invoice_order')->where('invoice_id', $invoice->id)->update([
        //         'invoice_id' => $invoice->id,
        //     ]);
        // }

        return redirect(route('admin.invoice.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return redirect(route('admin.invoice.index'));
    }

    /**
     * Get order details for corresponding order id
     *
     * @return ajax response
     */
    public function getOrder(Request $request)
    {
        $id = $request->id;
        $data = DB::table('order_product')->where('order_id', $id)->first();
        return ['status' => true, 'data' => $data];
    }
}
