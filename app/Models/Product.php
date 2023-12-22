<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'category_id',
        'name',
        'description',
        'slug',
        'image',
        'price',
        'compare_price',
        'options',
        'rating',
        'featured',
        'status',
    ];



    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tag', 'product_id', 'tag_id',);
    }

    protected static function booted()
    {
        static::addGlobalScope('store', new StoreScope());
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public static function scopeActive(Builder $builder)
    {
        $builder->where('status', 'active');
    }


    // Accessros
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return "https://sudbury.legendboats.com/resource/defaultProductImage";
        }

        if (str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }

        return asset('storage/' . $this->image);
    }


    public function getSalePrecentAttribute()
    {
        if (!$this->compare_price) {
            return 0;
        }

        return  round(100 - (100 * $this->price / $this->compare_price), 1);
    }
}
