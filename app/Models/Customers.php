<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['category_name','category_desc','category_status'];
    protected $primaryKey = 'category_id';
    protected $table = 'categories';

    protected $hidden = ['created_at', 'updated_at'];
}
