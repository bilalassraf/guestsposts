<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CasinoRequest extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $date = ['deleted_at'];
    protected $appends = ['check_status'];
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
    public function coodinator()
    {
        return $this->belongsTo(User::class, 'Coordinator');
    }
    public function getcheckStatusAttribute()
    {
        $result = statusData($this,'status');
        return  $result;
    }

}
