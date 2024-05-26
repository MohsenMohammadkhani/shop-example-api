<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $hidden = ['pivot'];
    protected $fillable = [
        'name',
        'persian_name',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, "role_permission");
    }

    public function scopeFilterByQueryString($query, $queryString)
    {
        if ($queryString->has('id')) {
            $query->find($queryString->get('id'));
            return $query;
        }

        if ($queryString->has('name')) {
            $query->where('name', 'like', '%' . $queryString->get('name') . '%');
        }

        if ($queryString->has('persian_name')) {
            $query->where('persian_name', 'like', '%' . $queryString->get('persian_name') . '%');
        }

        return $query;
    }
}
