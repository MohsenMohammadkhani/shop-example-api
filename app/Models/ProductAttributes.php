<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class ProductAttributes extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection  = 'product_attributes';

    protected $guarded = ['id'];
    protected $hidden = ['product_id'];
    public $timestamps = false;
}
