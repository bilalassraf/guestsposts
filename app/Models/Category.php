<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guarded = []; 
    public function userRequest()
    {
        return $this->belongsToMany(UserRequest::class);
    }

    public function nicheRequest()
    {
        return $this->belongsToMany(NicheRequest::class);
    }
}
