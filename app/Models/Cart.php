<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
     protected $fillable = ['customer_id','product_id', 'product_quantity'];
    protected $primaryKey = 'cart_id';
    protected $table = 'cart';

    // public function products()
    // {
    //     return $this->hasMany(Product::class, 'product_id', 'product_id');
    // }
}
