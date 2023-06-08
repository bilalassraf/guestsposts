<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
class UserRequest extends Model
{
    use softDeletes;
    use HasFactory;
    protected $date = ['deleted_at'];
    protected $guarded = [];
    protected $appends = ['check_status'];
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
        return $this->belongsTo(User::class, 'coordinator_id');
    }

    public function getcheckStatusAttribute()
    {
        if($this->black_hat == 1){
            return "Black Hat";
        }elseif($this->good == 1){
            return "Good Request";
        }else{
            return $this->status;
        }
    }

}
