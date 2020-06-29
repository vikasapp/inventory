<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->string('order_nr')->unique()->nullable();
            $table->bigInteger('user_id');
            $table->bigInteger('amount')->default(0);
            $table->bigInteger('paid')->default(0);
            $table->enum('type', ['sale', 'purchase']);
            $table->timestamp('order_date')->useCurrent();
            $table->tinyInteger('deleted')->default(0);
            $table->timestamp('deleted_at')->nullable();
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


    public function generateOrderNR()
    {   
        $orderObj = \DB::table('orders')->select('order_nr')->latest('id')->first();
        if ($orderObj) {
            $orderNr = $orderObj->order_nr;
            $removed1char = substr($orderNr, 1);
            $generateOrder_nr = $stpad = '#' . str_pad($removed1char + 1, 8, "0", STR_PAD_LEFT);
        } else {
            $generateOrder_nr = '#' . str_pad(1, 8, "0", STR_PAD_LEFT);
        }
        return $generateOrder_nr;
    }
}
