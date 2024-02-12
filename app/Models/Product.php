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
        'quantity',
        'options',
        'rating',
        'featured',
        'status',

    ];


    protected $hidden = [
        'image',
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    protected $appends = [
        'image_url',
    ];


    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tag', 'product_id', 'tag_id',);
    }

    protected static function booted()
    {
        static::addGlobalScope('store', new StoreScope());

        static::creating(function (Product $product) {
            $product->slug = Str::slug($product->name);
        });
        
        static::updating(function (Product $product) {
            $product->slug = Str::slug($product->name);
        });
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



    public function Scopefilter(Builder $builder, $filters)
    {
        $options = array_merge([
            'store_id'    => null,
            'category_id' => null,
            'tags'        => null,
            'status'      => 'active',

        ], $filters);

        $builder->when($options['status'], function ($builder, $value) {
            $builder->where('status', $value);
        });

        $builder->when($options['store_id'], function ($builder, $value) {
            $builder->where('stroe_id', $value);
        });

        $builder->when($options['category_id'], function ($builder, $value) {
            $builder->where('category_id', $value);
        });

        $builder->when($options['tags'], function ($builder, $value) {
            $builder->whereExists(function ($query) use ($value) {
                $query->select(1)
                    ->from('product_tag')
                    ->whereRwa('product_id', 'products.id')
                    ->where('tag_id', $value);
            });
        });

    }
}
