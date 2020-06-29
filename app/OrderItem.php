<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
	protected $table = 'order_items';
    protected $fillable = [
        'item_nr', 'order_id', 'item_id', 'price', 'quantity', 'unit', 'total_price', 'deleted', 'deleted_at'
    ];
}
