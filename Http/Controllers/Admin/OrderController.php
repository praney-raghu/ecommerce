<?php

namespace Modules\ECommerce\Http\Controllers\Admin;

use Neev;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\ECommerce\Models\Order;
use Modules\ECommerce\Models\Product;
use Ssntpl\Neev\Http\Controllers\Controller;

class OrderController extends Controller
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
        $order = new Order();
        $orders = $order->getOrdersDetail();

        return view('neev::admin.catalogue.order.index')
            ->with('orders', $orders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::where('organisation_id', Neev::organisation()->getKey()); // For getting products list for corresponding organisation
        return view('neev::admin.catalogue.order.create')->with('products', $products);
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
        //creating new entry in Order table
        $order = Order::create([
            'organisation_id' => Neev::organisation()->getKey(),
            'parent_id' => $request->parent_id,
            'status' => 'Draft',
            'shippable' => $request->shippable,
            'recurring' => $request->recurring
        ]);

        $order_id = $order->id;
        $i = 0;
        foreach ($request->product as $product) {
            $data = Product::findOrFail($product);
            //dd($data->name);
            // creating new entry in Order_product table
            DB::table('order_product')->insert([
                'order_id' => $order_id,
                'product_id' => $product,
                'name' => $data->name,
                'description' => $data->description,
                'cost' => $request->cost[$i],
                'qty' => $request->qty[$i],
                'unit' => $data->unit,
                'hsn' => $data->hsn,
                'type' => $data->type,
                'shippable' => $request->shippable,
                'recurring' => $request->recurring
            ]);
            $i++;
        }

        return redirect(route('admin.order.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $id = $order->id;
        $order = $order->where(['orders.id' => $id, 'organisation_id' => Neev::organisation()->getKey()])->join('order_product', 'orders.id', '=', 'order_product.order_id')->get();
        //dd($order[0]->order_id);
        $products = Neev::organisation()->products;
        $order_products = DB::table('order_product')->where('order_id', $id)->get(['product_id']);
        $selected_products = [];
        foreach ($order_products as $value) {
            array_push($selected_products, $value->product_id);
        }
        //dd($selected_products);
        return view('neev::admin.catalogue.order.edit')->with(['order' => $order, 'products' => $products, 'selected_products' => $selected_products]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //dd($request);
        // Updating Order table
        $order->organisation_id = Neev::organisation()->getKey();
        $order->parent_id = $request->parent_id;
        $order->status = 'Draft';
        $order->shippable = $request->shippable;
        $order->recurring = $request->recurring;
        $order->save();

        $order_id = $order->id;

        // Updating order_product table
        $i = 0;
        foreach ($request->product as $product) {
            DB::table('order_product')->where(['order_id' => $order_id, 'product_id' => $product])->update([
                'cost' => $request->cost[$i],
                'qty' => $request->qty[$i],
                'shippable' => $request->shippable,
                'recurring' => $request->recurring
            ]);
            $i++;
        }

        return redirect(route('admin.order.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect(route('admin.order.index'));
    }

    /**
     * Get product details for corresponding product id
     *
     * @return ajax response
     */
    public function getProduct(Request $request)
    {
        $id = $request->id;
        $data = Neev::organisation()->products->where('id', $id)->first();
        return ['status' => true, 'data' => $data];
    }
}
