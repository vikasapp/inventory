<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('phone')->unique()->nullable();
            $table->bigInteger('sale_amount')->default(0);
            $table->bigInteger('sale_paid')->default(0);
            $table->bigInteger('purchase_amount')->default(0);
            $table->bigInteger('purchase_paid')->default(0);
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->enum('is_active', ['yes', 'no', 'deleted']);
            $table->enum('role', ['admin', 'supper_admin', 'client']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
