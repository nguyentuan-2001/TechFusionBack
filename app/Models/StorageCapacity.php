<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorageCapacity extends Model
{
    use HasFactory;
    protected $fillable = ['total_capacity'];
    protected $primaryKey = 'storage_capacity_id';
    protected $table = 'storage_capacity';

    protected $hidden = ['created_at', 'updated_at'];
}
