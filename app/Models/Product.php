<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    
    /**
     * Query Scope
     * This will be called in Controller via ->customFunctionName()
     * And Laravel will append the 'scope' automatically
     */
    public function scopeFilterResult($query, array $filter){

        
        if(isset($filter['name'])){
            $query->where(function($query){
                $query
                ->where('name', 'like', '%' . request('name') . '%')
                ->orWhere('description', 'like', '%' . request('name') . '%');
            });
        }

        // $query->with('category', 'user');

    }
}
