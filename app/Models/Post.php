<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
   
    use HasFactory , SoftDeletes;
    protected $guarded = [];


    public function tags()
    {
        return $this->hasMany(PostTag::class, 'post_id');
    }

    public function User()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
