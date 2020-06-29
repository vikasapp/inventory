<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_nr' ,'user_id', 'amount', 'paid', 'type', 'order_date', 'deleted', 'deleted_at'
    ];
    protected $dates = ['order_date', 'deleted_at'];
}
