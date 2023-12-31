<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // public $timestamps = false;
    protected $fillable = ['category_id','product_name', 'product_content', 'product_price','product_sale', 'product_image','product_inventory_quantity', 'product_status'];
    protected $primaryKey = 'product_id';
    protected $table = 'products';

    protected $hidden = ['created_at', 'updated_at'];

    public function productDetail()
    {
        return $this->hasOne(ProductDetail::class, 'product_id', 'product_id');
    }
}
