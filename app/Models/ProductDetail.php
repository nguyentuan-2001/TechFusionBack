<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['product_id', 'product_ram','operating_system', 'product_pin', 'desktop'];
    protected $primaryKey = 'product_detail_id';
    protected $table = 'product_detail';

    protected $hidden = ['created_at', 'updated_at'];
   
}
