<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCapacity extends Model
{
    use HasFactory;
    protected $fillable = ['product_id','storage_capacity_id'];
    protected $primaryKey = 'product_capacity_id';
    protected $table = 'product_capacity';

    protected $hidden = ['created_at', 'updated_at'];
}
