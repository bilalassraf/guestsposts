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
    protected $appends = ['less_web_name','less_price','less_email','less_coodinator','less_categories','less_domain_rating','less_domain_authority','less_organic_trafic_ahrefs','less_organic_trafic_sem','less_trust_flow','less_span_score','less_citation_flow','less_web_description','less_special_note','check_client_status'];
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
        $result = lessData($this,'web_name');
        return  $result;
    }

    public function getlessPriceAttribute()
    {
        $result = lessData($this,'price');
        return  $result;
    }

    public function getlessEmailAttribute()
    {
        $result = lessData($this,'email_webmaster');
        return  $result;
    }

    public function getlessCoodinatorAttribute()
    {
        $result = lessData($this,'coordinator_id');
        return  $result;
    }

    public function getlessCategoriesAttribute()
    {
        $result = lessData($this,'categories');
        return  $result;
    }

    public function getlessDomainRatingAttribute()
    {
        $result = lessData($this,'domain_rating');
        return  $result;
    }

    public function getlessDomainAuthorityAttribute()
    {
        $result = lessData($this,'domain_authority');
        return  $result;
    }

    public function getlessOrganicTraficAhrefsAttribute()
    {
        $result = lessData($this,'organic_trafic_ahrefs');
        return  $result;
    }

    public function getlessSpanScoreAttribute()
    {
        $result = lessData($this,'span_score');
        return  $result;
    }

    public function getlessOrganicTraficSemAttribute()
    {
        $result = lessData($this,'organic_trafic_sem');
        return  $result;
    }

    public function getlessTrustFlowAttribute()
    {
        $result = lessData($this,'trust_flow');
        return  $result;
    }

    public function getlessCitationFlowAttribute()
    {
        $result = lessData($this,'citation_flow');
        return  $result;
    }

    public function getlessWebDescriptionAttribute()
    {
        $result = lessData($this,'web_description');
        return  $result;
    }

    public function getlessSpecialNoteAttribute()
    {
        $result = lessData($this,'special_note');
        return  $result;
    }

    public function getcheckClientStatusAttribute()
    {
        $result = statusData($this,'status');
        return  $result;
    }
}
