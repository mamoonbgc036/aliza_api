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

    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }
}
