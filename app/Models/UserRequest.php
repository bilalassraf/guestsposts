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
    protected $appends = ['less_web_name','less_price','less_email','less_coodinator','less_categories','less_domain_rating','less_domain_authority','less_organic_trafic_ahrefs','less_organic_trafic_sem','less_trust_flow','less_span_score','less_citation_flow','less_web_description','less_special_note','check_status'];
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
        $deleted = UserRequest::onlyTrashed()->where('status','Approved')->where('web_name',$this->web_name)->with('categories')->orderby('deleted_at','desc')->first();
        $actvive = UserRequest::where([['web_name',$this->web_name],['status','Approved'],['price','<',$deleted->price ?? 0]])->with('categories')->first();
   
        if(!empty($deleted) && !empty($actvive) && $actvive->price != $deleted->price && $this->status == 'Approved'){
            $result = $deleted[$field].' >> '.$actvive[$field];
        }else{
            $result = $this[$field];
        }
        return $result;
    }

    public function getlessPriceAttribute()
    {
    
        $field = 'price';
        $deleted = UserRequest::onlyTrashed()->where('status','Approved')->where('web_name',$this->web_name)->with('categories')->orderby('deleted_at','desc')->first();
        $actvive = UserRequest::where([['web_name',$this->web_name],['status','Approved'],['price','<',$deleted->price ?? 0]])->with('categories')->first();

        if(!empty($deleted) && !empty($actvive) && $actvive->price != $deleted->price && $this->status == 'Approved'){
            $result = $deleted[$field].' >> '.$actvive[$field];
        }else{
            $result = $this[$field];
        }
        return $result;

    }

    public function getlessEmailAttribute()
    {
        $field = 'email_webmaster';
        
        $deleted = UserRequest::onlyTrashed()->where('status','Approved')->where('web_name',$this->web_name)->with('categories')->orderby('deleted_at','desc')->first();
        $actvive = UserRequest::where([['web_name',$this->web_name],['status','Approved'],['price','<',$deleted->price ?? 0]])->with('categories')->first();

        if(!empty($deleted) && !empty($actvive) && $actvive->price != $deleted->price && $this->status == 'Approved'){
            
            $result = $deleted[$field].' >> '.$actvive[$field];
            
        }else{
            $result = $this[$field];
        }
        return $result;

    }

    public function getlessCoodinatorAttribute()
    {
        $field = 'coordinator_id';
        
        $deleted = UserRequest::onlyTrashed()->where('status','Approved')->where('web_name',$this->web_name)->with('categories')->orderby('deleted_at','desc')->first();
        $actvive = UserRequest::where([['web_name',$this->web_name],['status','Approved'],['price','<',$deleted->price ?? 0]])->with('categories')->first();

        if(!empty($deleted) && !empty($actvive) && $actvive->price != $deleted->price && $this->status == 'Approved'){
            if($field == 'coordinator_id'){
                $result = $this->coodinatorName($deleted[$field]).' >> '.$this->coodinatorName($actvive[$field]);
            }
        }else{
            $result = $this->coodinatorName($this[$field]);
        }
        return $result;
    }

    public function getlessCategoriesAttribute()
    {
    
        $field = 'categories';
        
        $deleted = UserRequest::onlyTrashed()->where('status','Approved')->where('web_name',$this->web_name)->with('categories')->orderby('deleted_at','desc')->first();
        $actvive = UserRequest::where([['web_name',$this->web_name],['status','Approved'],['price','<',$deleted->price ?? 0]])->with('categories')->first();

        if(!empty($deleted) && !empty($actvive) && $actvive->price != $deleted->price && $this->status == 'Approved'){
            if($field == 'coordinator_id'){
                $result = $this->coodinatorName($deleted[$field]).' >> '.$this->coodinatorName($actvive[$field]);
            }elseif($field == 'categories'){
                $result = $deleted->categories[0]['category'].' >> '.$actvive->categories[0]['category'];
            }elseif($field == 'updated_at'){
                $result = 0;
            }else{
                $result = $deleted[$field].' >> '.$actvive[$field];
            }
        }else{
            $result = $this->categories[0]['category'];
        }
        return $result;

    }

    public function getlessDomainRatingAttribute()
    {
        $field = 'domain_rating';
        
        $deleted = UserRequest::onlyTrashed()->where('status','Approved')->where('web_name',$this->web_name)->with('categories')->orderby('deleted_at','desc')->first();
        $actvive = UserRequest::where([['web_name',$this->web_name],['status','Approved'],['price','<',$deleted->price ?? 0]])->with('categories')->first();

        if(!empty($deleted) && !empty($actvive) && $actvive->price != $deleted->price && $this->status == 'Approved'){
            
            $result = $deleted[$field].' >> '.$actvive[$field];

        }else{
            $result = $this[$field];
        }
        return $result;

    }

    public function getlessDomainAuthorityAttribute()
    {
        $field = 'domain_authority';
        
        $deleted = UserRequest::onlyTrashed()->where('status','Approved')->where('web_name',$this->web_name)->with('categories')->orderby('deleted_at','desc')->first();
        $actvive = UserRequest::where([['web_name',$this->web_name],['status','Approved'],['price','<',$deleted->price ?? 0]])->with('categories')->first();

        if(!empty($deleted) && !empty($actvive) && $actvive->price != $deleted->price && $this->status == 'Approved'){
            
            $result = $deleted[$field].' >> '.$actvive[$field];
            
        }else{
            $result = $this[$field];
        }
        return $result;

    }

    public function getlessOrganicTraficAhrefsAttribute()
    {
        $field = 'organic_trafic_ahrefs';
        
        $deleted = UserRequest::onlyTrashed()->where('status','Approved')->where('web_name',$this->web_name)->with('categories')->orderby('deleted_at','desc')->first();
        $actvive = UserRequest::where([['web_name',$this->web_name],['status','Approved'],['price','<',$deleted->price ?? 0]])->with('categories')->first();

        if(!empty($deleted) && !empty($actvive) && $actvive->price != $deleted->price && $this->status == 'Approved'){
            
                $result = $deleted[$field].' >> '.$actvive[$field];
        }else{
            $result = $this[$field];
        }
        return $result;

    }

    public function getlessSpanScoreAttribute()
    {
        $field = 'span_score';
        
        $deleted = UserRequest::onlyTrashed()->where('status','Approved')->where('web_name',$this->web_name)->with('categories')->orderby('deleted_at','desc')->first();
        $actvive = UserRequest::where([['web_name',$this->web_name],['status','Approved'],['price','<',$deleted->price ?? 0]])->with('categories')->first();

        if(!empty($deleted) && !empty($actvive) && $actvive->price != $deleted->price && $this->status == 'Approved'){
            
            $result = $deleted[$field].' >> '.$actvive[$field];
            
        }else{
            $result = $this[$field];
        }
        return $result;

    }

    public function getlessOrganicTraficSemAttribute()
    {
        $field = 'organic_trafic_sem';
        
        $deleted = UserRequest::onlyTrashed()->where('status','Approved')->where('web_name',$this->web_name)->with('categories')->orderby('deleted_at','desc')->first();
        $actvive = UserRequest::where([['web_name',$this->web_name],['status','Approved'],['price','<',$deleted->price ?? 0]])->with('categories')->first();

        if(!empty($deleted) && !empty($actvive) && $actvive->price != $deleted->price && $this->status == 'Approved'){
           
            $result = $deleted[$field].' >> '.$actvive[$field];
            
        }else{
            $result = $this[$field];
        }
        return $result;

    }

    public function getlessTrustFlowAttribute()
    {
        $field = 'trust_flow';
        
        $deleted = UserRequest::onlyTrashed()->where('status','Approved')->where('web_name',$this->web_name)->with('categories')->orderby('deleted_at','desc')->first();
        $actvive = UserRequest::where([['web_name',$this->web_name],['status','Approved'],['price','<',$deleted->price ?? 0]])->with('categories')->first();

        if(!empty($deleted) && !empty($actvive) && $actvive->price != $deleted->price && $this->status == 'Approved'){
            
            $result = $deleted[$field].' >> '.$actvive[$field];
            
        }else{
            $result = $this[$field];
        }
        return $result;

    }

    public function getlessCitationFlowAttribute()
    {
        $field = 'citation_flow';
        
        $deleted = UserRequest::onlyTrashed()->where('status','Approved')->where('web_name',$this->web_name)->with('categories')->orderby('deleted_at','desc')->first();
        $actvive = UserRequest::where([['web_name',$this->web_name],['status','Approved'],['price','<',$deleted->price ?? 0]])->with('categories')->first();

        if(!empty($deleted) && !empty($actvive) && $actvive->price != $deleted->price && $this->status == 'Approved'){
            
            $result = $deleted[$field].' >> '.$actvive[$field];
            
        }else{
            $result = $this[$field];
        }
        return $result;

    }

    public function getlessWebDescriptionAttribute()
    {
        $field = 'web_description';
        
        $deleted = UserRequest::onlyTrashed()->where('status','Approved')->where('web_name',$this->web_name)->with('categories')->orderby('deleted_at','desc')->first();
        $actvive = UserRequest::where([['web_name',$this->web_name],['status','Approved'],['price','<',$deleted->price ?? 0]])->with('categories')->first();

        if(!empty($deleted) && !empty($actvive) && $actvive->price != $deleted->price && $this->status == 'Approved'){
            
            $result = $deleted[$field].' >> '.$actvive[$field];
            
        }else{
            $result = $this[$field];
        }
        return $result;

    }

    public function getlessSpecialNoteAttribute()
    {
        $field = 'special_note';
        
        $deleted = UserRequest::onlyTrashed()->where('status','Approved')->where('web_name',$this->web_name)->with('categories')->orderby('deleted_at','desc')->first();
        $actvive = UserRequest::where([['web_name',$this->web_name],['status','Approved'],['price','<',$deleted->price ?? 0]])->with('categories')->first();

        if(!empty($deleted) && !empty($actvive) && $actvive->price != $deleted->price && $this->status == 'Approved'){
            
            $result = $deleted[$field].' >> '.$actvive[$field];
            
        }else{
            $result = $this[$field];
        }
        return $result;

    }

    function coodinatorName($id = null)
    {
        $user = User::find($id);
        return $user->name ?? '';
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
