<?php
use App\Models\Niche;
use App\Models\User;


function lessData($object = null,$field = null)
{

    $deleted = Niche::onlyTrashed()->where('status','Approved')->where('web_url',$object->web_url)->with('categories')->orderby('deleted_at','desc')->first();
    $actvive = Niche::where([['web_url',$object->web_url],['status','Approved'],['price','<',$deleted->price ?? 0]])->with('categories')->first();

    if(!empty($deleted) && !empty($actvive) && $actvive->price != $deleted->price && $object->status == 'Approved'){
        if($field == 'coordinator_id'){
            $result = coodinatorName($deleted[$field]).' >> '.coodinatorName($actvive[$field]);
        }elseif($field == 'categories'){
            $result = $deleted->categories[0]['category'].' >> '.$actvive->categories[0]['category'];
        }elseif($field == 'updated_at'){
            $result = 0;
        }else{
            $result = $deleted[$field].' >> '.$actvive[$field];
        }
    }else{
        $result = $object[$field];
    }
    return $result;
}

function coodinatorName($id = null)
{
    $user = User::find($id);
    return $user->name;
}

function statusData($object = null, $status = null)
{

    if($object->spam == 1){
        return "Spam Request";
    }elseif($object->good == 1){
        return "Good Request";
    }else{
        return $object->status;
    }
}

?>
