<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Niche extends Model
{
    use HasFactory;use SoftDeletes;
    use HasFactory;
    protected $date = ['deleted_at'];
    protected $guarded = [];
    protected $appends = ['less_web_name','less_price','less_email','less_coodinator','less_categories','less_domain_rating','less_domain_authority','less_organic_trafic_ahrefs','less_organic_trafic_sem','less_trust_flow','less_span_score','less_citation_flow','less_web_description','less_special_note','check_client_status','less_status'];
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

    public function getlessWebNameAttribute()
    {
        $field = 'web_name';
        $result = $this->commonValue($this->web_name,$field);
        return $result;
    }

    public function getlessPriceAttribute()
    {
    
        $field = 'price';
        $result = $this->commonValue($this->web_name,$field);
        return $result;
    }

    public function getlessEmailAttribute()
    {
        $field = 'email_webmaster';
        $result = $this->commonValue($this->web_name,$field);
        return $result;
    }

    public function getlessCoodinatorAttribute()
    {
        $field = 'coordinator_id';
        $min_val = Niche::where('web_name', $this->web_name)->with('categories')->min('price');
        $max_val = Niche::where('web_name', $this->web_name)->with('categories')->max('price');
        $min_record = Niche::where('web_name', $this->web_name)->where('price', '=', $min_val ?? '')->with('categories')->first();
        $max_record = Niche::where('web_name', $this->web_name)->where('price', '=', $max_val ?? '')->with('categories')->first();

        if (!empty($min_val) && !empty($max_val) && $max_val != $min_val) {
            $result = $this->coodinatorName($max_record[$field]).' >> '.$this->coodinatorName($min_record[$field]);
        }else{
            $result = $this->coodinatorName($this[$field]);
        }
        return $result;
    }

    public function getlessCategoriesAttribute()
    {
        $field = 'categories';
        $min_val = Niche::where('web_name', $this->web_name)->with('categories')->min('price');
        $max_val = Niche::where('web_name', $this->web_name)->with('categories')->max('price');
        $min_record = Niche::where('web_name', $this->web_name)->where('price', '=', $min_val ?? '')->with('categories')->first();
        $max_record = Niche::where('web_name', $this->web_name)->where('price', '=', $max_val ?? '')->with('categories')->first();

        if (!empty($min_val) && !empty($max_val) && $max_val != $min_val) {
            $result = $max_record->categories[0]['category'].' >> '.$min_record->categories[0]['category'];
        } else {
            $result = $this->categories[0]['category'];
        }
        return $result;
    }

    public function getlessDomainRatingAttribute()
    {
        $field = 'domain_rating';
        $result = $this->commonValue($this->web_name,$field);
        return $result;
    }

    public function getlessDomainAuthorityAttribute()
    {
        $field = 'domain_authority';
        $result = $this->commonValue($this->web_name,$field);
        return $result;
    }

    public function getlessOrganicTraficAhrefsAttribute()
    {
        $field = 'organic_trafic_ahrefs';
        $result = $this->commonValue($this->web_name,$field);
        return $result;
    }

    public function getlessSpanScoreAttribute()
    {
        $field = 'span_score';
        $result = $this->commonValue($this->web_name,$field);
        return $result;
    }

    public function getlessOrganicTraficSemAttribute()
    {
        $field = 'organic_trafic_sem';
        $result = $this->commonValue($this->web_name,$field);
        return $result;
    }

    public function getlessTrustFlowAttribute()
    {
        $field = 'trust_flow';
        $result = $this->commonValue($this->web_name,$field);
        return $result;
    }

    public function getlessCitationFlowAttribute()
    {
        $field = 'citation_flow';
        $result = $this->commonValue($this->web_name,$field);
        return $result;
    }

    public function getlessWebDescriptionAttribute()
    {
        $field = 'web_description';
        $result = $this->commonValue($this->web_name,$field);
        return $result;
    }

    public function getlessSpecialNoteAttribute()
    {
        $field = 'special_note';
        $result = $this->commonValue($this->web_name,$field);
        return $result;
    }

    public function getlessStatusAttribute()
    {
        $field = 'status';
        $result = $this->commonValue($this->web_name,$field);
        return $result;
    }

    function coodinatorName($id = null)
    {
        $user = User::find($id);
        return $user->name;
    }

    public function commonValue($domain = null, $field = null)
    {
        $min_val = Niche::where('web_name', $domain)->with('categories')->groupBy('web_name')->min('price');
        $max_val = Niche::where('web_name', $domain)->with('categories')->groupBy('web_name')->max('price');
        $min_record = Niche::where('web_name', $domain)->where('price', $min_val)->with('categories')->first();
        $max_record = Niche::where('web_name', $domain)->where('price', $max_val)->with('categories')->first();

        if (!empty($min_val) && !empty($max_val) && $max_val != $min_val) {
            $result = $max_record[$field] . ' >> ' . $min_record[$field];
        } else {
            $result = $this[$field];
        }
        return $result;
    }


    public function getcheckClientStatusAttribute()
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
