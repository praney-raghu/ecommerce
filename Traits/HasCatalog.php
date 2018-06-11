<?php

namespace Modules\ECommerce\Traits;

use Modules\ECommerce\Models\Order;
use Modules\ECommerce\Models\Product;
use Modules\ECommerce\Models\Category;

trait HasCatalog
{
    /**
     * Get the organisation products.
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'organisation_id');
    }

    /**
     * Get the organisation category.
     */
    public function categories()
    {
        return $this->hasMany(Category::class, 'organisation_id');
    }

    /**
     * Get the organisation orders.
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'organisation_id');
    }
}
