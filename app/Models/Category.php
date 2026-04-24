<?php

namespace App\Models;

use App\Trait\HasSlug;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasSlug;
    protected $fillable = [
        'icon',
        'name',
        'slug',
        'monthly_budget',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
