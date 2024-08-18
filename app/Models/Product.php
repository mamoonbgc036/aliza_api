<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable = ['title', 'description', 'price', 'old_price', 'category_id', 'unit', 'created_by'];

    protected $table = 'products';

    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function getCatNameAttribute()
    {
        $category = Category::findOrFail($this->category_id);

        return $category->name;
    }
}
