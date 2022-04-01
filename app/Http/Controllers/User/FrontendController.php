<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use App\Models\UserRequest;
use Illuminate\Http\Request;
use Carbon\CarbonPeriod;
use Carbon\Carbon;
use Auth;
class FrontendController extends Controller
{
    public function index()
    {
        $to = Carbon::now();
        $from = Carbon::now()->subDays(10);
        $period = CarbonPeriod::create($from, $to);
        $chartdata = [];
        $totalCount = 0;
        foreach ($period as $p) {

            $date = Carbon::parse($p)->format('Y-m-d 00:00:00');
            $enddate = Carbon::parse($p)->format('Y-m-d 23:59:59');
            $count = UserRequest::whereBetween('created_at',[$date,$enddate])->get();
            $app = $count->where('status','approved')->count();
            $rej = $count->where('status','rejected')->count();
            $del = $count->where('status','deleted')->count();
            $pend = $count->where('status','pending')->count();
            if($count){
                $totalCount++;
            }
            array_push($chartdata,$count);
        }
        $data['chartRange'] = json_encode($period->toArray());
        // dd($data['chartRange'],json_decode($data['chartRange']));
        $data['chartdata'] = json_encode($chartdata);
        $data['totalCount'] = $totalCount;
        $categories = Category::all();
        $users = User::all();
        $approved = UserRequest::where('status','approved')->count();
        $rejected = UserRequest::where('status','rejected')->count();
        $deleted = UserRequest::where('status','deleted')->count();
        $pending = UserRequest::where('status','pending')->count();
        $to = Carbon::tomorrow();
        $from = Carbon::now()->subDays(28);
        $days_array = [];
        $period = CarbonPeriod::create($from, $to);
        $chartdata = [];
        $totalCount = 0;
        foreach ($period as $date) {
            $date = Carbon::parse($date)->format('Y-m-d 00:00:00');
            $enddate = Carbon::parse($date)->format('Y-m-d 23:59:59');
            array_push($days_array, Carbon::parse($date)->isoFormat('Do'));
            $user_request = UserRequest::where('user_id',auth()->user()->id)->whereBetween('created_at', [$date, $enddate])->count();
            array_push($chartdata, $user_request);
        }
        $max = round(($totalCount + 10 / 2) / 10) * 10;
        $chart_data_array = array(
            'days' => $days_array,
            'max' => $max,
            'count_data' => $chartdata,
        );
        $total = UserRequest::count();
        return view('dashboard',$data,compact('categories','users','approved','pending','deleted','rejected','app','del','pend','rej'))->with($chart_data_array);
    }
    public function addWebsite(Request $request)
    {
        $request->validate([
            'web_name'         => 'required|unique:user_requests',
            'coordinator_id'      => 'required',
            'price'            => 'required|integer',
            //'company_price'    => 'required|integer',
            //'category'         =>'required',
            'domain_authority' => 'required',
            'span_score'       => 'required',
            'domain_rating'    => 'required',
            'organic_trafic_ahrefs' => 'required',
            'organic_trafic_sem'    => 'required',
            'trust_flow'        => 'required',
            'citation_flow'     => 'required',
            'email'             => 'required',
            'web_description'   => 'required',
            // 'special_note'      => 'required',

        ]);
        $percentage = 8/100 * $request->price;
        $company_price = ($request->price * $percentage + 50) + $request->price;

        $user = User::find($request->user_id);
         $userRequest = new UserRequest();
        //  $userRequest->user_id = $request->user_id;
         $userRequest->web_name = $request->web_name;
         $userRequest->coordinator_id = $request->coordinator_id;
         $price = $userRequest->price = $request->price;
        $userRequest->company_price  = $company_price;
        // $userRequest->category     = $request->category;
         $userRequest->domain_authority     = $request->domain_authority;
         $userRequest->span_score     = $request->span_score;
         $userRequest->domain_rating     = $request->domain_rating;
         $userRequest->organic_trafic_ahrefs     = $request->organic_trafic_ahrefs;
         $userRequest->organic_trafic_sem     = $request->organic_trafic_sem;
         $userRequest->trust_flow     = $request->trust_flow;
         $userRequest->citation_flow = $request->citation_flow;
         $userRequest->email_webmaster = $request->email;
         $userRequest->web_description = $request->web_description;
         $userRequest->special_note = $request->special_note;
         $user->user_request()->save($userRequest);
         $userRequest->categories()->sync($request->categories);
        return redirect(route('user.requests'))->with('success','Your request has submitted');
    }
    public function userUpdateProfile(Request $request)
    {
        $user = User::find($request->user_id);
        $user->name  = $request->name ;
        $user->email  = $request->email ;
        $user->gender  = $request->gender ;
        $user->address  = $request->address ;
        $user->phone  = $request->mobile ;
        $user->province  = $request->province ;
        $user->city  = $request->city ;
        $user->postal  = $request->postal ;
        $user->country  = $request->country ;
        $user->about  = $request->about;

       if($request->hasFile('profile')){
        $request->validate([
        'profile' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $extension = $request->file('profile')->getClientOriginalExtension();
        $fileName = "profile_".rand(11111,99999).'_'.time().'_'.substr($request->name,0, 6).'.'.$extension;
        $upload_path = 'uploads/users/';
        $full_path = '/uploads/users/'.$fileName;
        $request->file('profile')->move($upload_path, $fileName);
        $file_path  = $full_path;
        $user->profile = $file_path;
        }
        if($request->hasFile('cover')){
        $request->validate([
        'cover' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $extension = $request->file('cover')->getClientOriginalExtension();
        $fileName = "cover_".rand(11111,99999).'_'.time().'_'.substr($request->name,0, 6).'.'.$extension;
        $upload_path = 'uploads/users/';
        $full_path = '/uploads/users/'.$fileName;
        $request->file('cover')->move($upload_path, $fileName);
        $file_path  = $full_path;
        $user->cover = $file_path;
         }
       $user->update();
         return back()->with('success','Profile Updated Successfully');
    }
    public function user_request()
    {
        $user = User::find(Auth::user()->id);
        $user_permissions = $user->permissions()->where('type', 1)->pluck('permissions.name')->toArray();
        if($user->type == 'admin'){
            $guest_requests = UserRequest::orderBy('id', 'DESC')->get();
        }else{
            $guest_requests = $user->user_request;
        }
        // $niches = UserRequest::where('user_id', auth()->user()->id)->get();
        return view('pages.user.user-requests',compact('user', 'user_permissions','guest_requests'));
    }
    public function showNicheForm()
    {
        $categories = Category::all();
        return view('user.user requests.add-request',compact('categories'));
    }
    public function userEditRequest($id)
    {
        $request = UserRequest::find($id);
        $categories = Category::all();
        return view('pages.user.user-edit-request',compact('request','categories'));
    }
    public function userUpdateRequest(Request $request,$id)
    {
        $request->validate([
            'price'            => 'required|integer',
            'company_price'    => 'required|integer',
        ]);
        $userRequest = UserRequest::find($id);
         $userRequest->web_name = $request->web_name;
         $userRequest->coordinator = $request->coordinator;
         $price = $userRequest->price = $request->price;
         $percentage = 8/100 * $price;
            $userRequest->company_price  = $request->company_price - ($price * $percentage) + $price + 50;
         //$userRequest->category     = $request->category;
         $userRequest->domain_authority     = $request->domain_authority;
         $userRequest->span_score     = $request->span_score;
         $userRequest->domain_rating     = $request->domain_rating;
         $userRequest->organic_trafic_ahrefs     = $request->organic_trafic_ahrefs;
         $userRequest->organic_trafic_sem     = $request->organic_trafic_sem;
         $userRequest->trust_flow     = $request->trust_flow;
         $userRequest->citation_flow = $request->citation_flow;
         $userRequest->email_webmaster = $request->email;
         $userRequest->web_description = $request->web_description;
         $userRequest->special_note = $request->special_note;
         $userRequest->update();

        return redirect(route('user.requests'))->with('success','Your request has updated');
    }
    public function userShowProfile($id)
    {
        $user = User::find($id);
        $request = UserRequest::where('user_id', $user->id)->get();
        return view('pages.user.auth-user-profile',compact('user','request'));
    }


}

