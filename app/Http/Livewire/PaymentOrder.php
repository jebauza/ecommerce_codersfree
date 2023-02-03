<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class PaymentOrder extends Component
{
    use AuthorizesRequests;

    public $order;

    protected $listeners = ['payOrder'];

    public function mount(Order $order)
    {
        // refresh() is a mutable operation: It will reload the current model instance from the database.
        $this->order = $order->fresh(['department','city','district']); // is an immutable operation: It returns a new model instance from the database. It doesn't affect the current instance.
    }

    public function render()
    {
        $this->authorize('author', $this->order);
        $this->authorize('payment', $this->order);

        $items = json_decode($this->order->content);

        return view('livewire.payment-order', compact('items'));
    }

    public function payOrder($orderData)
    {
        // $transaction = $orderData['purchase_units'][0]['payments']['captures'][0];
        // dd($transaction->id, $transaction->status);
        $this->order->status = Order::STATUS_RECEIVED;
        $this->order->save();

        return redirect()->route('orders.show', $this->order);
    }
}
