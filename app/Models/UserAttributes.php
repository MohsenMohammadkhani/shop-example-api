<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class UserAttributes extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection  = 'user_attributes';

    protected $guarded = ['id'];
    protected $hidden = ['user_id'];
    public $timestamps = false;
}
