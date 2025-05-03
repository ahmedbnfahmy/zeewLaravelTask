<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';
    const STATUS_SHIPPED = 'shipped';

    protected $fillable = [
        'customer_id',
        'product_name',
        'quantity',
        'price',
        'status'
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isShipped()
    {
        return $this->status === self::STATUS_SHIPPED;
    }
}