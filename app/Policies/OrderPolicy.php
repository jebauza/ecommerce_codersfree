<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Order;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Method author
     *
     * @param App\Models\User $user
     * @param App\Models\Order $order
     *
     * @return bool
     */
    public function author(User $user, Order $order){
        return $order->user_id == $user->id;
    }

    /**
     * Method payment
     *
     * @param App\Models\User $user
     * @param App\Models\Order $order
     *
     * @return bool
     */
    public function payment(User $user, Order $order){
        return $order->status == Order::STATUS_PENDING;
    }
}
