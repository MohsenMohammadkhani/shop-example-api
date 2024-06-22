<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];
    protected $table = 'products';
    protected $connection = 'mysql';

    public function scopeFilterByQueryString($query, $queryString)
    {
        if ($queryString->has('id')) {
            $query->find($queryString->get('id'));
            return $query;
        }

        if ($queryString->has('title')) {
            $query->where('title', 'like', '%' . $queryString->get('title') . '%');
        } 

        return $query;
    }
}
