<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Builder;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $countPending = auth()->user()->orders()->pending()->count();
        $countReceived = auth()->user()->orders()->received()->count();
        $countShipped = auth()->user()->orders()->shipped()->count();
        $countCompleted = auth()->user()->orders()->completed()->count();
        $countCanceled = auth()->user()->orders()
                                        ->annuled()
                                        ->orWhere(function (Builder $query) {
                                            return $query->canceled();
                                        })
                                        ->count();

        $orders = auth()->user()->orders()
                                ->when($request->status, function ($query, $status) {
                                    return $query->where('status', $status);
                                })
                                ->get();

        return view('orders.index', compact('orders','countPending','countReceived','countShipped','countCompleted','countCanceled'));
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
        $this->authorize('author', $order);

        $items = json_decode($order->content);

        return view('orders.show', compact('order', 'items'));
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
        $this->authorize('author', $order);

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
