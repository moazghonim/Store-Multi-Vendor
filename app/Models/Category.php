<?php

namespace App\Models;

use Illuminate\Contracts\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable = [
        'name',
        'parent_id',
        'slug',
        'description',
        'image',
        'status'
    ];

    public function scopeActive(Builder $builder)
    {
        $builder->where('status', 'active');
    }

    public function scopeFilter(Builder $builder, $filters)
    {

        $builder->when($filters['name'] ?? false, function ($builder, $value) {
            $builder->where('name', 'LIKE', "%{$value}%");
        });

        $builder->when($filters['status'] ?? false, function ($builder, $value) {
            $builder->where('status', $value);
        });
    }

    public static function rules($id = 0)
    {
        return [
            'name' => "required|string|min:3|max:255|unique:categories,name,$id|filter:php,laravel,html",
            'parent_id' => ['nullable', 'int', 'exists:categories,id'],
            'image' => 'image|max:1048576|dimensions:min_with:=100 min_height:=100',
            'status' => 'in:active,archived',
        ];
    }


    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id')->withDefault(['name' => '-']);
    }

    public function children()
    {
        return $this->hasManys(Category::class, 'parent_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
