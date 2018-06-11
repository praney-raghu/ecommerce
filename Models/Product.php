<?php

namespace Modules\ECommerce\Models;

use Ssntpl\Neev\Models\Organisation;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    use HasTranslations;
    protected $fillable = ['organisation_id', 'hsn', 'type', 'module', 'name', 'description', 'meta_description', 'meta_keyword', 'slug', 'tag', 'cost', 'qty', 'unit', 'visible', 'active'];

    /**
     * The attributes that are translatable i.e. supports multi-language
     *
     * @var array
     */
    protected $translatable = ['name', 'description', 'meta_description', 'meta_keyword', 'slug', 'tag'];

    public function productType()
    {
        $type = ['physical' => 'Physical', 'downloadable' => 'Downloadable', 'service' => 'Service', 'domain' => 'Domain', 'script' => 'Script', 'subscription' => 'Subscription'];
        return $type;
    }

    // /**
    //  * @var array
    //  */
    // public static $productType = [
    //     PHYSICAL,
    //     DOWNLOADABLE,
    //     ACCOUNT_LOCALIZATION,
    //     ACCOUNT_PAYMENTS,
    //     ACCOUNT_TAX_RATES,
    //     ACCOUNT_PRODUCTS,
    //     ACCOUNT_NOTIFICATIONS,
    //     ACCOUNT_IMPORT_EXPORT,
    //     ACCOUNT_MANAGEMENT,
    // ];

    public function organisation()
    {
        return $this->belongsTo(Organisation::class);
    }
}
