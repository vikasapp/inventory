<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_item_nr')->unique()->nullable();
            $table->bigInteger('order_id');
            $table->bigInteger('item_id');
            $table->bigInteger('price')->default(0);
            $table->bigInteger('quantity')->default(0);
            $table->enum('unit', ['gram', 'kg', 'unit']);
            $table->bigInteger('total_price');
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
        Schema::dropIfExists('order_items');
    }


    public function generateOrderNR()
    {   
        $orderObj = \DB::table('order_items')->select('item_nr')->latest('id')->first();
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
