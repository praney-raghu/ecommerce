<?php

namespace Modules\ECommerce\Models;

use Ssntpl\Neev\Models\Organisation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'organisation_id', 'status', 'invoice_date', 'invoice_number', 'po_number', 'due_date', 'bill_name',
        'bill_address', 'bill_state', 'bill_country', 'bill_zip', 'bill_taxcode_name', 'bill_taxcode_number',
        'bill_field_name_1', 'bill_field_value_1', 'bill_field_name_2', 'bill_field_value_2', 'ship_name',
        'ship_address', 'ship_state', 'ship_country', 'ship_zip', 'ship_taxcode_name', 'ship_taxcode_number',
        'ship_field_name_1', 'ship_field_value_1', 'ship_field_name_2', 'ship_field_value_2', 'seller_name',
        'seller_address', 'seller_state', 'seller_country', 'seller_zip', 'seller_taxcode_name', 'seller_taxcode_number',
        'seller_field_name_1', 'seller_field_value_1', 'seller_field_name_2', 'seller_field_value_2', 'amount', 'currency',
        'amount_base_currency', 'base_currency', 'currency_rate', 'terms', 'footer', 'private_notes'
    ];

    public function organisation()
    {
        return $this->belongsTo(Organisation::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
