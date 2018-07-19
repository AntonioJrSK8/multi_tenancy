<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Builder;

class Category extends Model
{
    protected $fillable = [
        'name'
    ];

    /**
     * Quary Scope Local
     * @var $query
     * @var $account_id
     */
    public function scopeByAccount(Builder $query, $account_id){
        return $query->where('account_id', $account_id);
    }
}
