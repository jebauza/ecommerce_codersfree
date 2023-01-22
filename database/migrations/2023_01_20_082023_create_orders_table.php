<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->string('contact');
            $table->string('phone');
            $table->string('status', 50)->default('pending');
            $table->string('pickup_type', 50)->default('store');
            $table->float('shipping_cost');
            $table->float('total');
            $table->json('content');

            $table->unsignedBigInteger('department_id')->nullable();
            $table->foreign('department_id')->references('id')->on('departments');

            $table->unsignedBigInteger('city_id')->nullable();
            $table->foreign('city_id')->references('id')->on('cities');

            $table->unsignedBigInteger('district_id')->nullable();
            $table->foreign('district_id')->references('id')->on('districts');

            $table->text('address')->nullable();
            $table->text('references')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
