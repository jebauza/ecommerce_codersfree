<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    /**
     * Method payment
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $orderId
     *
     * @return \Illuminate\Http\Response
     */
    public function payment(Request $request, int $orderId)
    {
        $order = Order::with('department','city','district')->findOrfail($orderId);
        $items = json_decode($order->content);

        return view('orders.payment', compact('order','items'));
    }

    /**
     * Display order.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $orderId
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, int $orderId)
    {
        $order = Order::with('department','city','district')->findOrfail($orderId);

        return view('orders.show', compact('order'));
    }

    /**
     * Display order.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Order $order
     *
     * @return \Illuminate\Http\Response
     */
    public function pay(Request $request, Order $order)
    {
        $paymentId = $request->get('payment_id');
        $accessToken = config('services.mercadopago.access_token');

        $response = json_decode(Http::get("https://api.mercadopago.com/v1/payments/$paymentId?access_token=$accessToken"));
        $status = $response->status;

        if ($status == 'approved') {
            $order->status = Order::STATUS_RECEIVED;
            $order->save();
        }

        return redirect()->route('orders.show', $order);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
