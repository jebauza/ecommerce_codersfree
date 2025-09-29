<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Console\Command;

class CancelUnpaidOrdersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:cancel-unpaid';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It is in charge of canceling the orders that have not been paid in a period of 10 minutes from its creation, returns the products to the stock of the store';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $time = now()->subMinute(10);
        $orders = Order::pending()
                        ->whereTime('created_at', '<=', $time->toDateTimeString())
                        ->get();

        foreach ($orders as $order) {
            $items = json_decode($order->content);
            foreach ($items as $item) {
                if ($product = Product::with('sizes.colors','colors')->find($item->id)) {
                    $sizeId = !empty($item->options->size) ? $item->options->size->id : null;
                    $colorId = !empty($item->options->color) ? $item->options->color->id : null;

                    if ($sizeId && $colorId && ($size = $product->sizes->firstWhere('id', $sizeId))) {
                        $color = $size->colors->firstWhere('id', $colorId);
                        $size->colors()
                            ->updateExistingPivot($color->id, ['quantity' => $color->pivot->quantity + $item->qty]);
                    } elseif ($colorId && ($color = $product->colors->firstWhere('id', $colorId))) {
                        $product->colors()
                                ->updateExistingPivot($color->id, ['quantity' => $color->pivot->quantity + $item->qty]);
                    } else {
                        $product->quantity += $item->qty;
                        $product->save();
                    }
                }
            }

            $order->status = Order::STATUS_ANNULED;
            $order->save();
        }

        $this->info('✅ ' . 'Canceled '.$orders->count().' orders for non-payment');
    }
}
