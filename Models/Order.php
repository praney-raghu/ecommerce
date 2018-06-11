<?php

namespace Modules\ECommerce\Models;

use Neev;
use Ssntpl\Neev\Models\Organisation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'organisation_id', 'status', 'shippable', 'recurring'
    ];

    public function organisation()
    {
        return $this->belongsTo(Organisation::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function getOrdersDetail()
    {
        return $this->where('orders.organisation_id', Neev::organisation()->getKey())
            ->join('order_product', 'orders.id', '=', 'order_product.order_id')
            ->get();
    }
}
