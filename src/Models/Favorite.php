<?php

namespace Grechanyuk\Favorite\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Favorite extends Model
{
    protected $fillable = ['user_id', 'list'];

    public function favoriteable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(Config::get('auth.providers.users.model'));
    }

    public function scopeList($query, string $list = 'favorite')
    {
        $query->whereList($list);
    }
}