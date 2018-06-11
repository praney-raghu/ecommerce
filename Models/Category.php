<?php

namespace Modules\ECommerce\Models;

use Ssntpl\Neev\Models\Organisation;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    use HasTranslations;
    protected $table = 'category';
    protected $fillable = ['organisation_id', 'parent_id', 'name', 'description', 'meta_description', 'meta_keyword', 'slug', 'tag', 'visible', 'active'];

    /**
     * The attributes that are translatable i.e. supports multi-language
     *
     * @var array
     */
    protected $translatable = ['name', 'description', 'meta_description', 'meta_keyword', 'slug', 'tag'];

    public function organisation()
    {
        return $this->belongsTo(Organisation::class);
    }
}
