<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
     protected $fillable = ['customer_id','product_id','color_id', 'storage_capacity_id', 'product_quantity'];
    protected $primaryKey = 'cart_id';
    protected $table = 'cart';

    public function productDetail()
    {
        return $this->hasOne(Product::class, 'product_id', 'product_id');
    }
    public function productColors()
    {
        return $this->hasMany(ProductColor::class, 'product_id', 'product_id');
    }
    public function productCapacity()
    {
        return $this->hasMany(ProductCapacity::class, 'product_id', 'product_id');
    }
}
