<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->bigInteger('order_id')->nullable();
            $table->bigInteger('amount')->default(0);
            $table->bigInteger('total_paid')->default(0);
            $table->bigInteger('total_balance')->default(0);
            $table->enum('type', ['sale', 'purchase'])->default('sale');
            $table->timestamp('payment_date')->useCurrent();
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
        Schema::dropIfExists('payments');
    }
}
