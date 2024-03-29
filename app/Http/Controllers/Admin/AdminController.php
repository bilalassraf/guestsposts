<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Category;
use App\Models\Niche;
use App\Models\UserRequest;
use App\Models\CasinoRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use App\Exports\RequestExport;
use App\Models\AdvanceFilter;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BulkExport;
use App\Imports\BulkImport;
use Prophecy\Doubler\Generator\Node\ReturnTypeNode;
// use Excel;
use DB;
use App\Imports\UserRequestImport;
use App\Models\Permission;
use Illuminate\Support\Facades\DB as FacadesDB;
use DataTables;
class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        $approved = UserRequest::where('status', 'Approved')->count();
        $rejected = UserRequest::where('status', 'Rejected')->count();
        $deleted = UserRequest::where('status', 'Deleted')->count();
        $pending = UserRequest::where('status', 'Pending')->count();

        return view('admin.dashboard.admin-dashboard', compact('users', 'approved', 'pending', 'deleted', 'rejected'));
    }
    public function addCasinoRequestForm()
    {
        $categories = Category::orderBy('category', 'asc')->get();
        $guestCoordinator = User::where('type','Outreach Coordinator')->get();
        return view('pages.casino.add-websites', compact('categories','guestCoordinator'));
    }
    public function storeCasinoRequest(Request $request)
    {
        $request->validate([
            'web_name'         => 'required|unique:casino_requests',
            'coordinator_id'      => 'required',
            'price'            => 'required|integer|regex:/^[-0-9\+]+$/',
            'categories'         => 'required',
            'domain_authority' => 'required',
            'span_score'       => 'required',
            'domain_rating'    => 'required',
            'organic_trafic_ahrefs' => 'required',
            'organic_trafic_sem'    => 'required',
            'email'             => 'required',
            'web_description'   => 'required',
        ]);
        // $percentage = 8/100 * $request->price;

        $check_web_url = CasinoRequest::where('web_name',$request->web_name)->first();
       
        if (isset($check_web_url) && $check_web_url->spam == 0) {
            $check_price = $check_web_url->price > $request->price;
                if($check_price){
                    $user = User::find($request->coordinator_id);
                    $userRequest = new CasinoRequest();
                    $userRequest->web_name = $request->web_name;
                    $userRequest->Coordinator = $request->coordinator_id;
                    $userRequest->price = $request->price;
                    $userRequest->company_price  = $request->company_price ? $request->company_price : $request->price * 8 / 100 + 50;
                    $userRequest->span_score     = $request->span_score;
                    $userRequest->domain_rating     = $request->domain_rating;
                    $userRequest->domain_authority     = $request->domain_authority;
                    $userRequest->organic_trafic_ahrefs     = $request->organic_trafic_ahrefs;
                    $userRequest->organic_trafic_sem     = $request->organic_trafic_sem;
                    $userRequest->trust_flow     = "0";
                    $userRequest->citation_flow = "0";
                    $userRequest->email_webmaster = $request->email;
                    $userRequest->web_description = $request->web_description;
                    $userRequest->special_note = $request->special_note;
                    $user->user_request()->save($userRequest);
                    $userRequest->categories()->sync($request->categories);
                    return redirect(route('admin.add.casino.request'))->with('success', 'Your request has submitted');
                }else{
                    return redirect()->back()->with('warning', 'Your Price Should be Less Then '.$check_web_url->price )->withInput($request->all());
                }
        }elseif(isset($check_web_url) && $check_web_url->spam == 1) {
            return redirect()->back()->with('warning', 'This website is already in Spam. So you can not add it again.');    
        }elseif(empty($check_web_url)){
            $user = User::find($request->coordinator_id);
            $userRequest = new CasinoRequest();
            $userRequest->web_name = $request->web_name;
            $userRequest->Coordinator = $request->coordinator_id;
            $userRequest->price = $request->price;
            $userRequest->company_price  = $request->company_price;
            $userRequest->span_score     = $request->span_score;
            $userRequest->domain_rating     = $request->domain_rating;
            $userRequest->domain_authority     = $request->domain_authority;
            $userRequest->organic_trafic_ahrefs     = $request->organic_trafic_ahrefs;
            $userRequest->organic_trafic_sem     = $request->organic_trafic_sem;
            $userRequest->trust_flow     = "0";
            $userRequest->citation_flow = "0";
            $userRequest->email_webmaster = $request->email;
            $userRequest->web_description = $request->web_description;
            $userRequest->special_note = $request->special_note;
            $user->user_request()->save($userRequest);
            $userRequest->categories()->sync($request->categories);
            return redirect(route('admin.add.casino.request'))->with('success', 'Your request has submitted');
        }  
    }
    public function showCasinoRequests()
    {
        $user = User::find(Auth::user()->id);

        $user_permissions = $user->permissions()->where('type', 3)->pluck('permissions.name')->toArray();
        if($user->type == 'Admin'){
            $guest_requests = \DB::table('casino_requests')
                ->where('spam',0)
                ->select('casino_requests.*',DB::raw('COUNT(web_name) as count'))
                ->groupBy('web_name')
                ->orderBy('count')
                ->get();
        }else{
            $guest_requests = $user->user_request;
        }
        return view('pages.casino.all-web-requests', compact("guest_requests","user_permissions"));
    }
    public function casinoRequests()
    {
        $user = User::find(Auth::user()->id);
        if( $user->type == 'Admin' || $user->type == 'Moderator' ){
            $guest_requests = CasinoRequest::where('spam','0')->groupBy('web_name')->with(['categories','coodinator'])->orderBy('id', 'DESC')->get();
        }else{

            $guest_requests = $user->casino_request()->with(['categories', 'coodinator']);
        }

        $guestCoordinator = User::where('type','Outreach Coordinator')->get();
        return DataTables::of($guest_requests)
        ->addColumn('check_box', function($row){

            return '<label><input type="checkbox" class="check sub_chk" value="'.$row->id.'" name="ids[]"></label>
                    <a style="cursor: pointer; color:black; display: inline;" class="detail dropdown-toggle">
                    </a>';
        })->addColumn('actions', function($request)use($guestCoordinator){
            return view('pages.casino.actions', compact('request','guestCoordinator'));
        })->editColumn('price', function($request){
            return view('pages.casino.newPrice', compact('request'));
        })->addColumn('categories', function ($request) {
            return implode(', ', $request->categories->pluck('category')->toArray());
        })->editColumn('updated_at', function($row){
           return date("Y-m-d", strtotime($row->updated_at));
        })->addColumn('coordinator', function ($request) {
            return $request->coodinator?$request->coodinator->name:'N/A';
        })->rawColumns(['check_box','action','categories'])->make(true);
    }
    public function casinoRequestApprove($id)
    {
        $permission = CasinoRequest::find($id);
        $check_web_url = $permission->web_name;
        $check_max_niches = CasinoRequest::where('web_name', $check_web_url)->where('price','>=',$permission->price)->get();
        $check_min_niches = CasinoRequest::where('web_name', $check_web_url)->where('price','<',$permission->price)->get();
        if(count($check_min_niches) > 0 && count($check_max_niches) > 0){
            if (count($check_max_niches) > 0 ) {
                foreach ($check_max_niches as $niche) {
                    $del_obj = CasinoRequest::find($niche->id);
                    $del_obj->delete();
                }
            }
            if(count($check_min_niches) > 0){
                foreach ($check_min_niches as $niche) {
                    $obj = CasinoRequest::find($niche->id);
                    $obj->status = 'Approved';
                    $obj->update();
                }
            }
            
            return response()->json(['success'=>"Approved"]);

        }else{
            if ($permission->status == 'Pending' || $permission->status == 'Rejected') {
                $permission->status = 'Approved';
                if($permission->new_price > 0){
                    $permission->price =$permission->new_price;
                    $permission->new_price=0;
                }
                $permission->update();
                return response()->json(['success'=>"Approved"]);
            } elseif ($permission->status == 'Approved') {
                return response()->json(['info'=>"Already Approved"]);
            }
        }
    }
    public function casinoRejected($id)
    {
        $permission = CasinoRequest::find($id);
        if ($permission->status == 'Pending' || $permission->status == 'Approved') {
            $permission->status = 'Rejected';
            $permission->update();
            return response()->json(['success'=>"Requests Rejected"]);
        } else {
            return response()->json(['info'=>"Already Rejected"]);
        }    
    }
    public function casinoRequestDelete($id)
    {
        $permission = CasinoRequest::find($id);
        if ($permission->status == 'Pending' || $permission->status == 'Approved' || $permission->status == 'Rejected') {
            $permission->status = 'Deleted';
            $permission->update();
            $permission->delete();
            return response()->json(['success'=>"CasinoRequest has been deleted"]);
        }
    }
    public function updateCasino(Request $request, $id)
    {
        $niches = CasinoRequest::all();
        $userRequest = CasinoRequest::find($id);
        $userRequest->web_name = $request->web_name;
        $userRequest->Coordinator = $request->coordinator_id;
        $price = $userRequest->price = $request->price;
        $userRequest->company_price  = $request->company_price;
        $userRequest->domain_authority     = $request->domain_authority;
        $userRequest->span_score     = $request->span_score;
        $userRequest->domain_rating     = $request->domain_rating;
        $userRequest->organic_trafic_ahrefs     = $request->organic_trafic_ahrefs;
        $userRequest->organic_trafic_sem     = $request->organic_trafic_sem;
        $userRequest->trust_flow     = "0";
        $userRequest->citation_flow = "0";
        $userRequest->email_webmaster = $request->email;
        $userRequest->web_description = $request->web_description;
        $userRequest->special_note = $request->special_note;
        $userRequest->good = $request->site_quality == "Good" ? 1 : 0;
        $userRequest->black_hat = $request->site_quality == "Black" ? 1 : 0;
        $userRequest->update();
        $userRequest->categories()->sync($request->categories);
        return back()->with('success', 'Request updated successfully');
    }
    public function showCasinoDeleted()
    {
        $trashed = CasinoRequest::onlyTrashed()->get();
        $empty_message = "There is no deleted Request";
        return view('pages.casino.deleted-requests', compact('trashed', 'empty_message'));
    }
    public function restoreCasino($id)
    {
        $restored = CasinoRequest::onlyTrashed()->find($id)->restore();
        $restored_request = CasinoRequest::find($id);
        $restored_request->status = 'Pending';
        $restored_request->update();
        return back()->with('success', 'Request has been restored ');
    }
    public function forceDeleteCasino($id)
    {
        $permanent_delete = CasinoRequest::onlyTrashed()->find($id);
        $permanent_delete->forceDelete();
        return back()->with('success', 'Request has been deleted permanently');
    }
    public function getCasinoDetails($id)
    {
        $data['guest_request']= CasinoRequest::where('id', $id)->with('coodinator')->first();
        $data['user_permissions'] = Auth::user()->permissions()->where('type', 3)->pluck('permissions.name')->toArray();
        $html = view('pages.guestDetails',$data)->render();
        return $html;
    }
    public function approvedSelectedCasino(Request $request)
    {
        $ids = explode(',', $request->ids);
       
        if (!empty($ids)) {
            $data = CasinoRequest::whereIn('id', $ids)->update([
                'status' => 'Approved'
            ]);
            return response()->json(['success'=>"Selected Requests Approved successfully."]);
        } else {
            return response()->json(['info'=>"Select a user before this opreation"]);
        }
    }
    public function deleteSelectedCasino(Request $request)
    {
        $ids = $request->ids;
        DB::table("casino_requests")->whereIn('id',explode(",",$ids))->delete();
        return response()->json(['success'=>"Selected Requests Deleted successfully."]);
    }
    public function casinoSpamWebsites()
    {
        $data = CasinoRequest::where('spam',1)->get();
        $empty_message = "There is no Spam Request";
        return view('pages.casino.spam-request', compact('data', 'empty_message'));
    }


    public function getUrl(Request $request)
    {
        // dd($request->all());
        $url =  str_replace("www.","",preg_replace("/^https?\:\/\//i", "" , $request->webname));
        $value = Niche::where('spam','1')->orWhere('web_name', 'like', '%' . $url . '%')->first();
        if(isset($value) && $value->spam == 1){
            echo " This website is already in Spam. So you
            can not add it again. ";
        }
    }
    public function getName(Request $request)
    {
        $url =  str_replace("www.","",preg_replace("/^https?\:\/\//i", "" , $request->webname));
        $value = Niche::orWhere('web_name', 'like', '%' . $url . '%')->first();
        $pending_niche = Niche::orWhere('web_name', 'like', '%' . $url . '%')->where('status','Pending')->first();
        
        if (isset($value) && $value->spam == 0 && !isset($pending_niche) && empty($pending_niche)) {
            $result = "The website is already added in the database. Though you have a chance to BEAT THE PRICE.";
            $status = 'pass';
        }elseif (isset($value) && $value->spam == 1 || isset($pending_niche) && $pending_niche->spam == 1) {
            $result = "The website is marked as SPAM. You cannot add it anymore.";
            $status = 'fail';
        }elseif (isset($pending_niche) && !empty($pending_niche)) {
            $result = "The website is already in QUEUE. You cannot add it right now.";
            $status = 'fail';
        }else {
            $result = ""; // Set a default result if necessary
            $status = "";
        }
        return response()->json(['result' => $result, 'status' => $status]);
    }
    public function nicheCheckPrice(Request $request)
    {
        $url =  str_replace("www.", "", preg_replace("/^https?\:\/\//i", "", $request->webName));
        $value = Niche::orWhere('web_name', 'like', '%' . $url . '%')->first();
        if (isset($value) && $request->webName !== null) {
            if ($value->price <= $request->price) {
                $result = "You need to lower the price.";
                $color = "red";
            } else {
                $result = "You are good to go. Please add the website now.";
                $color = "green";
            }
            return response()->json([
                'result' => $result,
                'color' => $color
            ]);
        }    
    } 
    public function guestName(Request $request)
    {
        $url =  str_replace("www.","",preg_replace("/^https?\:\/\//i", "" , $request->webname));
        $value = UserRequest::orWhere('web_name', 'like', '%' . $url . '%')->first();
        $pending_request = UserRequest::orWhere('web_name', 'like', '%' . $url . '%')->where('status','Pending')->first();
        
        if (isset($value) && $value->spam == 0 && !isset($pending_request) && empty($pending_request)) {
            $result = "The website is already added in the database. Though you have a chance to BEAT THE PRICE.";
            $status = 'pass';
        }elseif (isset($value) && $value->spam == 1 || isset($pending_request) && $pending_request->spam == 1) {
            $result = "The website is marked as SPAM. You cannot add it anymore.";
            $status = 'fail';
        }elseif (isset($pending_request) && !empty($pending_request)) {
            $result = "The website is already in QUEUE. You cannot add it right now.";
            $status = 'fail';
        }else {
            $result = ""; // Set a default result if necessary
            $status = "";
        }
        
        return response()->json(['result' => $result, 'status' => $status]);
    }
    public function guestCheckPrice(Request $request)
    {
        $url =  str_replace("www.", "", preg_replace("/^https?\:\/\//i", "", $request->webName));
        $value = UserRequest::orWhere('web_name', 'like', '%' . $url . '%')->first();
        if (isset($value) && $request->webName !== null) {
            if ($value->price <= $request->price) {
                $result = "You need to lower the price.";
                $color = "red";
            } else {
                $result = "You are good to go. Please add the website now.";
                $color = "green";
            }
            return response()->json([
                'result' => $result,
                'color' => $color
            ]);
        }    
    }
    public function casinoName(Request $request)
    {
        $url = str_replace("www.", "", preg_replace("/^https?\:\/\//i", "", $request->webname));
        $value = CasinoRequest::orWhere('web_name', 'like', '%' . $url . '%')->first();
        $pending_casino = CasinoRequest::orWhere('web_name', 'like', '%' . $url . '%')->where('status','Pending')->first();
        
        if (isset($value) && $value->spam == 0 && !isset($pending_casino) && empty($pending_casino)) {
            $result = "The website is already added in the database. Though you have a chance to BEAT THE PRICE.";
            $status = 'pass';
        }elseif (isset($value) && $value->spam == 1 || isset($pending_casino) && $pending_casino->spam == 1) {
            $result = "The website is marked as SPAM. You cannot add it anymore.";
            $status = 'fail';
        }elseif (isset($pending_casino) && !empty($pending_casino)) {
            $result = "The website is already in QUEUE. You cannot add it right now.";
            $status = 'fail';
        }else {
            $result = ""; // Set a default result if necessary
            $status = "";
        }
        
        return response()->json(['result' => $result, 'status' => $status]);
    }

    public function casinoCheckPrice(Request $request)
    {
        $url =  str_replace("www.", "", preg_replace("/^https?\:\/\//i", "", $request->webName));
        $value = CasinoRequest::orWhere('web_name', 'like', '%' . $url . '%')->first();
   
        if (isset($value) && $request->webName !== null) {
            if ($value->price <= $request->price) {
                $result = "You need to lower the price.";
                $color = "red";
            } else {
                $result = "You are good to go. Please add the website now.";
                $color = "green";
            }
            return response()->json([
                'result' => $result,
                'color' => $color
            ]);
        }        
    }
    public function casinoNewPrice(Request $request , $id)
    {
        $new_price = CasinoRequest::find($id);
        $new_price->new_price = $request->new_price;
        $new_price->status = 'Pending';
        $new_price->update();
        return response()->json(['success'=>"New Price Updated Successfully"]);
    }
    public function newPrice(Request $request , $id)
    {
        $new_price = UserRequest::find($id);
        $new_price->new_price = $request->new_price;
        $new_price->status = 'Pending';
        $new_price->update();
        return back()->with('success', 'New Price Updated Successfully');
    }
    public function nicheNewPrice(Request $request , $id)
    {
        $niche_new_price = Niche::find($id);
        $niche_new_price->niche_new_price = $request->niche_new_price;
        $niche_new_price->status = 'Pending';
        $niche_new_price->update();
        return back()->with('success', 'New Price Updated Successfully');
    }
    public function addCategory(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|unique:categories|max:255',
        ]);
        Category::create([
            'category' => $request->category,
        ]);
        return redirect('user/dashboard')->with('success', 'Category added successfully');
    }
    public function showCategories()
    {
        $categories = Category::orderBy('category', 'ASC')->get();
        return view('pages.show-categories', compact('categories'));
    }
    public function editCategory(Request $request, $id)
    {
        $category = Category::find($id);
        $category->category = $request->category;
        $category->update();
        return back()->with('success', 'Category Updated Successfully');
    }
    public function deleteCategory(Request $request, $id)
    {
        $category = Category::find($id);
        $category->delete();
        return back()->with('success', 'Category has been deleted');
    }
    public function storeGuestRequest(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'web_name'         => 'required',
            'coordinator_id'      => 'required',
            'price'            => 'required|integer|regex:/^[-0-9\+]+$/',
            // 'company_price'    => 'required|integer|regex:/^[-0-9\+]+$/',
            'categories'         => 'required',
            'domain_authority' => 'required',
            'span_score'       => 'required',
            'domain_rating'    => 'required',
            'organic_trafic_ahrefs' => 'required',
            'organic_trafic_sem'    => 'required',
            // 'trust_flow'        => 'required',
            // 'citation_flow'     => 'required',
            'email'             => 'required',
            'web_description'   => 'required',
            // 'special_note'      => 'required',
        ]);
        // $percentage = 8/100 * $request->price;

        $check_web_url = UserRequest::where('web_name',$request->web_name)->first();
       
        if (isset($check_web_url) && $check_web_url->spam == 0) {
            $check_price = $check_web_url->price > $request->price;
            if($check_price){
                $user = User::find($request->coordinator_id);
                $userRequest = new UserRequest();
                $userRequest->web_name = $request->web_name;
                $userRequest->coordinator_id = $request->coordinator_id;
                $userRequest->price = $request->price;
                $userRequest->company_price  = $request->company_price;
                $userRequest->span_score     = $request->span_score;
                $userRequest->domain_authority     = $request->domain_authority;
                $userRequest->domain_rating     = $request->domain_rating;
                $userRequest->organic_trafic_ahrefs     = $request->organic_trafic_ahrefs;
                $userRequest->organic_trafic_sem     = $request->organic_trafic_sem;
                $userRequest->trust_flow     = "0";
                $userRequest->citation_flow = "0";
                $userRequest->email_webmaster = $request->email;
                $userRequest->web_description = $request->web_description;
                $userRequest->special_note = $request->special_note;
                $user->user_request()->save($userRequest);
                $userRequest->categories()->sync($request->categories);
                
                return redirect(route('admin.add.guest.request'))->with('success', 'Your request has submitted');
            }else{
                return redirect()->back()->with('warning', 'Your Price Should be Less Then '.$check_web_url->price )->withInput($request->all());
            }  
        }else{
            $user = User::find($request->coordinator_id);
            $userRequest = new UserRequest();
            $userRequest->web_name = $request->web_name;
            $userRequest->coordinator_id = $request->coordinator_id;
            $userRequest->price = $request->price;
            $userRequest->company_price  = $request->company_price;
            $userRequest->span_score     = $request->span_score;
            $userRequest->domain_authority     = $request->domain_authority;
            $userRequest->domain_rating     = $request->domain_rating;
            $userRequest->organic_trafic_ahrefs     = $request->organic_trafic_ahrefs;
            $userRequest->organic_trafic_sem     = $request->organic_trafic_sem;
            $userRequest->trust_flow     = "0";
            $userRequest->citation_flow = "0";
            $userRequest->email_webmaster = $request->email;
            $userRequest->web_description = $request->web_description;
            $userRequest->special_note = $request->special_note;
            $user->user_request()->save($userRequest);
            $userRequest->categories()->sync($request->categories);
            
            return redirect(route('admin.add.guest.request'))->with('success', 'Your request has submitted');
        }    
    }

    public function showSingleRequest($id)
    {
        $request = UserRequest::find($id);
        return view('pages.single-request', compact('request'));
    }
    public function userInfo()
    {
        $users = User::all();
        return view('pages.all-users', compact('users'));
    }
    public function createUser(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required'
        ]);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'type' => $request->type,
            'password' => bcrypt($request->password),
        ]);
        return back()->with('success', 'User added successfully');
    }
    public function userUpdate(Request $request, $id)
    {
        $request->validate([
            'password' => 'confirmed'
        ]);
        $user =  User::find($id);
        $user->name = $request->name;
        $user->type= $request->type;
        $user->email = $request->email;
        if( $request->password){
            $user->password = bcrypt($request->password);
        }
        $user->update();
        return back()->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return back()->with('User has been deleted');
    }
    public function userProfile($id)
    {
        $user = User::find($id);
        $user_permissions = $user->permissions()->pluck('permissions.id')->toArray();
        $request = UserRequest::where('user_id', $user->id)->get();
        $user_niche = User::find($id);
        $request_niche = Niche::where('user_id', $user->id)->get();
        $request_casino = CasinoRequest::where('user_id', $user->id)->get();
        $permissionCasino = Permission::where('type',3)->get();
        $permission = Permission::where('type',1)->get();
        $permissionNiche = Permission::where('type',2)->get();

        return view('pages.user-profile', compact('permissionCasino','user', 'request','user_niche' , 'request_niche','permission','user_permissions','permissionNiche','request_casino'));
    }
    public function addGuestRequestForm()
    {
        $categories = Category::orderBy('category', 'asc')->get();
        $guestCoordinator = User::where('type','Outreach Coordinator')->get();
        return view('pages.guest.add-websites', compact('categories','guestCoordinator'));
    }
    public function showGuestRequests()
    {
        $user = User::find(Auth::user()->id);

        $user_permissions = $user->permissions()->where('type', 1)->pluck('permissions.name')->toArray();
        if($user->type == 'Admin'){
            $guest_requests = \DB::table('user_requests')
                ->where('spam',0)
                ->select('user_requests.*',DB::raw('COUNT(web_name) as count'))
                ->groupBy('web_name')
                ->orderBy('count')
                ->get();
        }else{
            $guest_requests = $user->user_request;
        }
        return view('pages.guest.all-web-requests', compact("guest_requests","user_permissions"));
    }
    public function getDetails($id)
    {
        $data['guest_request']= UserRequest::where('id', $id)->with('coodinator')->first();
        $data['user_permissions'] = Auth::user()->permissions()->where('type', 1)->pluck('permissions.name')->toArray();
        $html = view('pages.guestDetails',$data)->render();
        return $html;
    }
    public function getNicheDetails($id)
    {
        $data['niche_request']= Niche::where('id', $id)->first();
        $data['user_permissions'] = Auth::user()->permissions()->where('type', 2)->pluck('permissions.name')->toArray();
        $html = view('pages.nicheDetails',$data)->render();
        return $html;
    }
    public function allGuestRequests()
    {
        $data = User::latest()->get();
        return UserRequest::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function guestRequestApprove($id)
    {
        $permission = UserRequest::find($id);
        $check_web_url = $permission->web_name;
        $check_max_niches = UserRequest::where('web_name', $check_web_url)->where('price','>=',$permission->price)->get();
        $check_min_niches = UserRequest::where('web_name', $check_web_url)->where('price','<',$permission->price)->get();
       
        if(count($check_min_niches) > 0 && count($check_max_niches) > 0){
            if (count($check_max_niches) > 0 ) {
                foreach ($check_max_niches as $niche) {
                    $del_obj = UserRequest::find($niche->id);
                    $del_obj->delete();
                }
            }
            if(count($check_min_niches) > 0){
                foreach ($check_min_niches as $niche) {
                    $obj = UserRequest::find($niche->id);
                    $obj->status = 'Approved';
                    $obj->update();
                }
            }
            return response()->json(['success'=>"Requests Approved"]);
        }else{
            if ($permission->status == 'Pending' || $permission->status == 'Rejected') {
                $permission->status = 'Approved';
                if($permission->new_price > 0){
                    $permission->price =$permission->new_price;
                    $permission->new_price=0;
                }
                $permission->update();
                return response()->json(['success'=>"Requests Approved"]);
            } elseif ($permission->status == 'Approved') {
                return response()->json(['info'=>"Already Approved"]);
            }
        }
    }
    public function nicheRejected($id)
    {
        $permission = UserRequest::find($id);
        if ($permission->status == 'Pending' || $permission->status == 'Approved') {
            $permission->status = 'Rejected';
            $permission->update();
    
            return response()->json(['success'=>"Requests Rejected"]);
        } else {
            return response()->json(['info'=>"Already Rejected"]);
        }
    }
    public function guestRequestDelete($id)
    {
        $permission = UserRequest::find($id);
        if ($permission->status == 'Pending' || $permission->status == 'Approved' || $permission->status == 'Rejected') {
            $permission->status = 'Deleted';
            $permission->update();
            $permission->delete();
            return response()->json(['success'=>"UserRequest has been deleted"]);
        }
    }
    public function makeAdmin($id)
    {
        $user = User::find($id);
        $user->type = 'Admin';
        $user->update();
        return back()->with('success', 'Admin created successfully');
    }
    public function adminProfile()
    {
        return view('admin.dashboard.user-info.admin-profile');
    }
    public function showGuestDeleted()
    {
        $trashed = UserRequest::onlyTrashed()->get();
        $empty_message = "There is no deleted Request";
        return view('pages.guest.deleted-requests', compact('trashed', 'empty_message'));
    }
    public function restoreRequest($id)
    {

        $restored = UserRequest::onlyTrashed()->find($id)->restore();
        $restored_request = UserRequest::find($id);
        $restored_request->status = 'Pending';
        $restored_request->update();
        return back()->with('success', 'Request has been restored ');
    }
    public function forceDelete($id)
    {
        $permanent_delete = UserRequest::onlyTrashed()->find($id);
        $permanent_delete->forceDelete();
        return back()->with('success', 'Request has been deleted permanently');
    }
    public function deleteSelectedREquest(Request $request)
    {
        $ids = $request->ids;
        DB::table("user_requests")->whereIn('id',explode(",",$ids))->delete();
        return response()->json(['success'=>"Selected Requests Deleted successfully."]);
    }

    public function approvedSelectedREquest(Request $request)
    {
        $ids = explode(',', $request->ids);
       
        if (!empty($ids)) {
            $data = UserRequest::whereIn('id', $ids)->update([
                'status' => 'Approved'
            ]);
            return response()->json(['success'=>"Selected Requests Approved successfully."]);
        } else {
            return response()->json(['info'=>"Select a user before this opreation"]);
        }
    }

    public function deleteSelected(Request $request)
    {
        $ids = $request->ids;
        if (!empty($ids)) {
            foreach ($ids as $id) {
                User::where('id', $id)->get()->each->delete();
            }
            return back()->with('success', 'Selected users has been removed');
        } else {
            return back()->with('info', 'Select a user before this opreation');
        }
    }
    public function getData(Request $request)
    {

        $to = empty($request->to) ? Carbon::now() : $request->to;
        $from = empty($request->from) ? Carbon::now()->subDays(20) : $request->from;
        // dd($from);
        $days_array = [];

        $period = CarbonPeriod::create($from, $to);
        $app_request = [];
        $pend_request = [];
        $rej_request = [];
        $del_request = [];
        $totalCount = 0;
        foreach ($period as $date) {
            $date = Carbon::parse($date)->format('Y-m-d 00:00:00');
            $enddate = Carbon::parse($date)->format('Y-m-d 23:59:59');
            array_push($days_array, Carbon::parse($date)->isoFormat('Do'));

            $app_req = UserRequest::whereBetween('created_at', [$date, $enddate])->where('status', 'Approved')->count();
            $pend_req = UserRequest::whereBetween('created_at', [$date, $enddate])->where('status', 'Pending')->count();
            $rej_req = UserRequest::whereBetween('created_at', [$date, $enddate])->where('status', 'Rejected')->count();
            $del_req = UserRequest::whereBetween('created_at', [$date, $enddate])->where('status', 'Deleted')->count();
            array_push($app_request, $app_req);
            array_push($pend_request, $pend_req);
            array_push($rej_request, $rej_req);
            array_push($del_request, $del_req);
        }
        $max = round(($totalCount + 10 / 2) / 10) * 10;
        $chart_data_array = array(
            'days' => $days_array,
            'max' => $max,
            'approved_request' => $app_request,
            'pending_request' => $pend_request,
            'deleted_request' => $del_request,
            'rejected_request' => $rej_request,
        );
        return $chart_data_array;
    }
    // end chart

    public function getDataUser(Request $request)
    {

        $to = empty($request->to) ? Carbon::now() : $request->to;
        $from = empty($request->from) ? Carbon::now()->subDays(20) : $request->from;
        $days_array = [];
        $period = CarbonPeriod::create($from, $to);
        $pend_request = [];
        $totalCount = 0;

        foreach ($period as $date) {
            $date = Carbon::parse($date)->format('Y-m-d 00:00:00');
            $enddate = Carbon::parse($date)->format('Y-m-d 23:59:59');
            array_push($days_array, Carbon::parse($date)->isoFormat('Do'));

            $pend_req = UserRequest::where('user_id',auth()->user()->id)->where('created_at', [Carbon::now()])->where('status', 'pending')->count();
            array_push($pend_request, $pend_req);
        }
        $max = round(($totalCount + 10 / 2) / 10) * 10;
        $chart_data_array = array(
            'days' => $days_array,
            'max' => $max,
            'pending_request' => $pend_request,
        );
        return $chart_data_array;
    }
    // end user chart
    public function editRequest($id)
    {
        $web_request = UserRequest::find($id);
        $categories = Category::orderBy('category', 'asc')->get();
        return view('pages.guest.all-web-requests', compact('web_request', 'categories'));
    }
    public function updateRequest(Request $request, $id)
    {
        $niches = UserRequest::all();
        $userRequest = UserRequest::find($id);
        $userRequest->web_name = $request->web_name;
        $userRequest->coordinator_id = $request->coordinator_id;
        $price = $userRequest->price = $request->price;
        $userRequest->company_price  = $request->company_price;
        $userRequest->domain_authority     = $request->domain_authority;
        $userRequest->span_score     = $request->span_score;
        $userRequest->domain_rating     = $request->domain_rating;
        $userRequest->organic_trafic_ahrefs     = $request->organic_trafic_ahrefs;
        $userRequest->organic_trafic_sem     = $request->organic_trafic_sem;
        $userRequest->trust_flow     = "0";
        $userRequest->citation_flow = "0";
        $userRequest->email_webmaster = $request->email;
        $userRequest->web_description = $request->web_description;
        $userRequest->special_note = $request->special_note;
        $userRequest->good = $request->site_quality == "Good" ? 1 : 0;
        $userRequest->black_hat = $request->site_quality == "Black" ? 1 : 0;
        $userRequest->update();
        $userRequest->categories()->sync($request->categories);
        return response()->json(['success'=>"Update"]);
    }
    public function updatePassword(Request $request, $id)
    {
        $user = User::find($id);
        $request->validate([
            'password' => 'confirmed'
        ]);
        $user->password = bcrypt($request->password);
        $user->update();
        alert('password has been changed');
        return back()->with('success', 'Password updated successfully');
    }
    public function search(Request $request)
    {
        $empty_message = "Record not found";
        $data = Filter_var($request->search, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        switch ($data) {
            case ('name'):
                $search_text = $_GET['search'];
                if (!empty($search_text)) {
                    $users = User::where('name', 'like', '%' . $search_text . '%')->get();
                    return view('pages.search-result', compact('users', 'empty_message'));
                } else {
                    return back()->with('info', 'Please enter Name or Email');
                }
                break;

            case ('email'):
                $email = $request->search;
                $users = User::where('email', 'like', '%' . $email . '%')->get();
                return view('pages.search-result', compact('users', 'empty_message'));
                break;

            default:
                return back()->with('error', 'Something went wrong');
        }
    }
    public function requestChart(Request $request, $requestName)
    {
        $users = User::all();
        $approved = UserRequest::where('status', 'Approved')->count();
        $rejected = UserRequest::where('status', 'Rejected')->count();
        $deleted = UserRequest::where('status', 'Deleted')->count();
        $pending = UserRequest::where('status', 'Pending')->count();
        switch ($requestName) {
            case ('Approved'):
                $status = 'Approved';
                $to = Carbon::now();
                $from = Carbon::now()->subDays(15);
                $days_array = [];
                $period = CarbonPeriod::create($from, $to);
                $chartdata = [];
                $totalCount = 0;
                foreach ($period as $date) {
                    $date = Carbon::parse($date)->format('Y-m-d 00:00:00');
                    $enddate = Carbon::parse($date)->format('Y-m-d 23:59:59');
                    array_push($days_array, Carbon::parse($date)->isoFormat('Do'));
                    $user_request = UserRequest::whereBetween('created_at', [$date, $enddate])->where('status', 'approved')->count();
                    array_push($chartdata, $user_request);
                }
                $max = round(($totalCount + 10 / 2) / 10) * 10;
                $chart_data_array = array(
                    'days' => $days_array,
                    'max' => $max,
                    'count_data' => $chartdata,
                );
                return view('graphs.single-request', $chart_data_array, compact('users', 'approved', 'pending', 'deleted', 'rejected', 'status'));
                break;

            case ('Pending'):
                $status = 'Pending';
                $to = Carbon::now();
                $from = Carbon::now()->subDays(15);
                $days_array = [];
                $period = CarbonPeriod::create($from, $to);
                $chartdata = [];
                $totalCount = 0;
                foreach ($period as $date) {
                    $date = Carbon::parse($date)->format('Y-m-d 00:00:00');
                    $enddate = Carbon::parse($date)->format('Y-m-d 23:59:59');
                    array_push($days_array, Carbon::parse($date)->isoFormat('Do'));
                    $user_request = UserRequest::whereBetween('created_at', [$date, $enddate])->where('status', 'pending')->count();
                    array_push($chartdata, $user_request);
                }
                $max = round(($totalCount + 10 / 2) / 10) * 10;
                $chart_data_array = array(
                    'days' => $days_array,
                    'max' => $max,
                    'count_data' => $chartdata,
                );
                return view('graphs.single-request', $chart_data_array, compact('users', 'approved', 'pending', 'deleted', 'rejected', 'status'));

                break;
            case ('Rejected'):
                $status = 'Rejected';
                $to = Carbon::now();
                $from = Carbon::now()->subDays(15);
                $days_array = [];
                $period = CarbonPeriod::create($from, $to);
                $chartdata = [];
                $totalCount = 0;
                foreach ($period as $date) {
                    $date = Carbon::parse($date)->format('Y-m-d 00:00:00');
                    $enddate = Carbon::parse($date)->format('Y-m-d 23:59:59');
                    array_push($days_array, Carbon::parse($date)->isoFormat('Do'));
                    $user_request = UserRequest::whereBetween('created_at', [$date, $enddate])->where('status', 'rejected')->count();
                    array_push($chartdata, $user_request);
                }
                $max = round(($totalCount + 10 / 2) / 10) * 10;
                $chart_data_array = array(
                    'days' => $days_array,
                    'max' => $max,
                    'count_data' => $chartdata,
                );
                return view('graphs.single-request', $chart_data_array, compact('users', 'approved', 'pending', 'deleted', 'rejected', 'status'));
                break;
            case ('Deleted'):
                $status = 'Deleted';
                $to = Carbon::now();
                $from = Carbon::now()->subDays(15);
                $days_array = [];
                $period = CarbonPeriod::create($from, $to);
                $chartdata = [];
                $totalCount = 0;
                foreach ($period as $date) {
                    $date = Carbon::parse($date)->format('Y-m-d 00:00:00');
                    $enddate = Carbon::parse($date)->format('Y-m-d 23:59:59');
                    array_push($days_array, Carbon::parse($date)->isoFormat('Do'));
                    $user_request = UserRequest::whereBetween('created_at', [$date, $enddate])->where('status', 'deleted')->count();
                    array_push($chartdata, $user_request);
                }
                $max = round(($totalCount + 10 / 2) / 10) * 10;
                $chart_data_array = array(
                    'days' => $days_array,
                    'max' => $max,
                    'count_data' => $chartdata,
                );
                return view('graphs.single-request', $chart_data_array, compact('users', 'approved', 'pending', 'deleted', 'rejected', 'status'));

                break;

            default:
                $msg = 'Something went wrong.';
        }
    }


    public function storeGuest(Request $request)
    {
        $user = User::find($request->user_id);
        $userRequest = new UserRequest();
        $userRequest->web_name = $request->web_name;
        $userRequest->coordinator = $request->coordinator;
        $userRequest->price     = $request->price;
        $userRequest->company_price     = $request->company_price;
        $userRequest->category     = $request->category;
        $userRequest->domain_authority     = $request->domain_authority;
        $userRequest->span_score     = $request->span_score;
        $userRequest->domain_rating     = $request->domain_rating;
        $userRequest->organic_trafic_ahrefs     = $request->organic_trafic_ahrefs;
        $userRequest->organic_trafic_sem     = $request->organic_trafic_sem;
        $userRequest->trust_flow     = "0";
        $userRequest->citation_flow = "0";
        $userRequest->email_webmaster = $request->email;
        $userRequest->web_description = $request->web_description;
        $userRequest->special_note = $request->special_note;
        $user->user_request()->save($userRequest);
        return redirect(route('admin.show.guest'))->with('success', 'Your request has submitted');
    }
    public function showAddGuestForm()
    {
        $categories = Category::orderBy('category', 'asc')->get();
        return view('pages.add-niche', compact('categories'));
    }
    public function showGuest()
    {
        $niches = UserRequest::where('spam',0)->get();
        return view('pages.all-niche-request', compact('niches'));
    }
    public function permissions(Request $request, $id)
    {
    //    dd($request->all());
        $user = User::find($id);
        $user->user_info = $request->user_info ? 'on' : 'off';
        $user->add_casino_post = $request->add_casino_post ? 'on' : 'off';
        $user->view_all_casino_post = $request->view_all_casino_post ? 'on' : 'off';
        $user->view_deleted_casino_post = $request->view_deleted_casino_post ? 'on' : 'off';
        $user->add_guest_post = $request->add_guest_post ? 'on' : 'off';
        $user->view_all_guest_post = $request->view_all_guest_post ? 'on' : 'off';
        $user->view_deleted_guest_post = $request->view_deleted_guest_post ? 'on' : 'off';
        $user->add_niche = $request->add_niche ? 'on' : 'off';
        $user->view_niches = $request->view_niches ? 'on' : 'off';
        $user->deleted_niches = $request->deleted_niches ? 'on' : 'off';
        $user->add_category = $request->add_category ? 'on' : 'off';
        $user->action = $request->actions ? 'on' : 'off';
        $user->view_all_categories = $request->view_all_categories ? 'on' : 'off';
        $user->update();

        if($request->ids){
         $user->permissions()->sync($request->ids);
        }

        return back()->with('success', 'Changes Updated Successfully');
    }

    //niche methods
    public function addNicheForm()
    {
        $categories = Category::orderBy('category', 'asc')->get();
        $guestCoordinator = User::where('type','Outreach Coordinator')->get();
        return view('pages.niche.add-niche', compact('categories','guestCoordinator'));
    }
    public function addStoreNiche(Request $request)
    {
       // preg_replace( "#^[^:/.]*[:/]+#i", "", $request->web_url );
        // $url = parse_url($request->web_url);
        // $host = $url['host'];
        // $host =  str_replace('www.' , '', $host);
        $request->web_url = '';
        $request->validate([
            'coordinator_id'      => 'required',
            'price'            => 'required|integer',
            'categories'         => 'required',
            'domain_authority' => 'required',
            'span_score'       => 'required',
            'domain_rating'    => 'required',
            'organic_trafic_ahrefs' => 'required',
            'organic_trafic_sem'    => 'required',
            'email'             => 'required',
            'web_description'   => 'required',
            ]
        );
        $check_web_url = Niche::where('web_name',$request->web_name)->first();
        // $check_web_name = Niche::where('web_name',$request->web_name)->first();
        // if($check_web_name){
        //     return redirect()->back()->with('warning', 'Website name alerady exists')->withInput($request->all());
        // }
        if (isset($check_web_url) && $check_web_url->spam == 0) {
            if($check_web_url){
                $check_price = $check_web_url->price > $request->price;
                if($check_price){
                    $user = User::find($request->user_id);
                    $Niche = new Niche();
                    // $Niche->web_name = preg_replace( "#^[^:/.]*[:/]+#i", "", $request->web_name );
                    $Niche->web_name = $request->web_name;
                    $Niche->coordinator_id = $request->coordinator_id;
                    $Niche->price = $request->price;
                    $Niche->company_price  =  $request->company_price;
                    $Niche->user_id     = $request->coordinator_id;
                    $Niche->domain_authority     = $request->domain_authority;
                    $Niche->span_score     = $request->span_score;
                    $Niche->domain_rating     = $request->domain_rating;
                    $Niche->organic_trafic_ahrefs     = $request->organic_trafic_ahrefs;
                    $Niche->organic_trafic_sem     = $request->organic_trafic_sem;
                    $Niche->trust_flow     = "0";
                    $Niche->citation_flow = "0";
                    $Niche->email_webmaster = $request->email;
                    $Niche->web_description = $request->web_description;
                    $Niche->special_note = $request->special_note;
                    $Niche->web_url = '';
                    $user->niche()->save($Niche);
                    $Niche->categories()->sync($request->categories);
                    return redirect(route('admin.show.niches'))->with('success', 'Your request has submitted');
                }else{
                    return redirect()->back()->with('warning', 'Your Price Should be Less Then '.$check_web_url->price )->withInput($request->all());
                }
            }
        }else{
            $user = User::find($request->user_id);
            $Niche = new Niche();
            $Niche->web_name = $request->web_name;
            $Niche->coordinator_id = $request->coordinator_id;
            $Niche->price = $request->price;
            $Niche->company_price  =  $request->company_price;
            $Niche->user_id     = $request->coordinator_id;
            $Niche->domain_authority     = $request->domain_authority;
            $Niche->span_score     = $request->span_score;
            $Niche->domain_rating     = $request->domain_rating;
            $Niche->organic_trafic_ahrefs     = $request->organic_trafic_ahrefs;
            $Niche->organic_trafic_sem     = $request->organic_trafic_sem;
            $Niche->trust_flow     = "0";
            $Niche->citation_flow = "0";
            $Niche->email_webmaster = $request->email;
            $Niche->web_description = $request->web_description;
            $Niche->special_note = $request->special_note;
            // $Niche->web_url = str_replace("www.","",preg_replace( "#^[^:/.]*[:/]+#i", "", $request->web_url )) ;
            $Niche->web_url = '';
            $user->niche()->save($Niche);
            $Niche->categories()->sync($request->categories);
            return redirect(route('admin.show.niches'))->with('success', 'Your request has submitted');
        }
    }
    public function webRequests(Request $request)
    {
        $user = User::find(Auth::user()->id);
        if( $user->type == 'Admin' || $user->type == 'Moderator' ){
            $guest_requests = UserRequest::where('spam',0)->groupBy('web_name')->with(['categories','coodinator'])->orderBy('id', 'DESC')->get();
        }else{
            $guest_requests = $user->user_request()->with(['categories', 'coodinator']);
        }
        $guest_requests = UserRequest::where('spam',0)->groupBy('web_name')->with(['categories','coodinator']);
        if($request->status ){
            $guest_requests->where(['status'=> $request->status]);
        }
        if(isset($request->siteQuality) && $request->siteQuality == 'Good'){
            $guest_requests->where(['good'=> 1]);
        }
        if(isset($request->siteQuality) && $request->siteQuality == 'Black'){
            $guest_requests->where(['black_hat'=> 1]);
        }
        if($request->category){
            $category = $request->category;
            $guest_requests->whereHas('categories', function($q) use ($category){
                return $q->where('categories.id', $category);
            });
        }
        if($request->to && $request->from){
            $guest_requests->wherebetween('created_at', array($request->from, $request->to));
        }elseif($request->to){
            $guest_requests->where('created_at', '<=', $request->to);
        }
        elseif($request->from){
            $guest_requests->where('created_at', '>=', $request->from);
        }
        if (!empty($request->domain_upper) && !empty($request->domain_lower)) {
            $guest_requests->where(function ($query) use ($request) {
                if (!empty($request->domain_authority)) {
                    $query->where('domain_authority', '!=', '')
                          ->whereBetween('domain_authority', [$request->domain_upper, $request->domain_lower]);
                } else {
                    return true;
                }
            });
        }
        if($request->raitings_upper && $request->raitings_lower){
            $guest_requests->wherebetween('domain_rating',  [$request->raitings_upper, $request->raitings_lower]);
        }
        if($request->web_upper && $request->web_lower){
            $guest_requests->wherebetween('price',  [$request->web_upper, $request->web_lower]);
        }
        if($request->span_upper && $request->span_lower){
            $guest_requests->wherebetween('span_score',  [$request->span_upper ,$request->span_lower]);
        }
        if($request->company_upper && $request->company_lower){
            $guest_requests->wherebetween('company_price',  [$request->company_upper , $request->company_lower]);
        }  
        if($request->traffic_upper && $request->traffic_lower){
            $guest_requests->wherebetween('organic_trafic_ahrefs',[$request->traffic_upper , $request->traffic_lower]);
        }  
        if($request->organic_upper && $request->traffic_lower){
            $guest_requests->wherebetween('organic_trafic_sem',[$request->organic_upper , $request->traffic_lower]);
        }   
         
        $guest_requests = $guest_requests->get();

        $guestCoordinator = User::where('type','Outreach Coordinator')->get();
        return DataTables::of($guest_requests)
        ->addColumn('check_box', function($row){

            return '<label><input type="checkbox" class="check sub_chk" value="'.$row->id.'" name="ids[]"></label>
                    <a style="cursor: pointer; color:black; display: inline;" class="detail dropdown-toggle">
                    </a>';
        })->addColumn('actions', function($request)use($guestCoordinator){
            return view('pages.guest.actions', compact('request','guestCoordinator'));
        })->editColumn('price', function($request){
            return view('pages.guest.newPrice', compact('request'));
        })->addColumn('categories', function ($request) {
            return implode(', ', $request->categories->pluck('category')->toArray());
        })->editColumn('updated_at', function($row){
           return date("Y-m-d", strtotime($row->updated_at));
        })->addColumn('coordinator', function ($request) {
            return $request->coodinator?$request->coodinator->name:'N/A';
        })->rawColumns(['check_box','action','categories'])->make(true);
    }
    public function nicheRequests()
    {
        $user = User::find(Auth::user()->id);
        if($user->type == 'Admin' || $user->type == 'Moderator'){
            $niches = Niche::where('spam','0')->groupBy('web_name')->with(['categories', 'coodinator'])->get();
        }else{
            $niches = $user->Niche()->with(['categories', 'coodinator'])->get();
        }
        $guestCoordinator = User::where('type','Outreach Coordinator')->get();
        return DataTables::of($niches)
        ->addColumn('check_box', function($row){
            return '<label><input type="checkbox" class="check sub_chk" value="'.$row->id.'" name="ids[]"></label>
                    <a style="cursor: pointer; color:black; display: inline;" class="detail dropdown-toggle">
                    </a>';
        })->addColumn('niche_actions', function($niche)use($guestCoordinator){
            return view('pages.niche.niche-actions', compact('niche','guestCoordinator'));
        })->editColumn('price', function($request){
            return view('pages.niche.newPrice', compact('request'));
        })->editColumn('updated_at', function($row){
           return date("Y-m-d", strtotime($row->updated_at));
        })->addColumn('categories', function ($row) {
            return implode(', ', $row->categories->pluck('category')->toArray());
        })->addColumn('coordinator', function ($request) {
            return $request->coodinator?$request->coodinator->name:'N/A';
        })
     ->rawColumns(['check_box','niche_actions','categories'])
        ->make(true);
    }
    public function userRequestsData()
    {
        $niches = UserRequest::where('user_id', auth()->user()->id)->with('categories')->get();
        return DataTables::of($niches)
        ->addColumn('check_box', function($row){

            return '<label><input type="checkbox" class="check sub_chk" value="'.$row->id.'" name="ids[]"></label>
                    <a style="cursor: pointer; color:black; display: inline;" class="detail dropdown-toggle">
                    </a>';
        })->addColumn('categories', function ($request) {
            return implode(', ', $request->categories->pluck('category')->toArray());
        })
        ->editColumn('updated_at', function($row){
           return date("Y-m-d h:i:s", strtotime($row->updated_at));
        })
        ->rawColumns(['check_box','actions','categories'])->make(true);
    }
    public function addShowNiches()
    {
        $user = User::find(Auth::user()->id);
        if($user->type == 'Admin'){
            $niches = \DB::table('niches')
                ->select('niches.*',DB::raw('COUNT(web_name) as count'))
                ->groupBy('web_name')
                ->orderBy('count')
                ->get();
            // foreach($niches as $niche){
            //     echo $niche->web_name;
            //     echo "<br>";
            // }
            // exit();   
        }else{
            $niches = $user->Niche;
        }
        $user_permissions = $user->permissions()->where('type', 2)->pluck('permissions.name')->toArray();
        $categories = Category::orderBy('category', 'asc')->get();
    
        return view('pages.niche.all-niche-request', compact('niches', 'categories', 'user_permissions'));
    }
    public function editNicheRequest(Request $request, $id)
    {
        $niche_request = Niche::find($id);
        $categories = Category::orderBy('category', 'asc')->get();
        return view('pages.niche.edit-niche', compact('niche_request', 'categories'));
    }
    public function updateNicheRequest(Request $request, $id)
    {
        $Niche = Niche::find($id);
        $Niche->web_name = $request->web_name;
        $Niche->coordinator_id = $request->coordinator_id;
        $price = $Niche->price = $request->price;
        $Niche->company_price  = $request->company_price;
        //$Niche->category     = $request->category;
        $Niche->domain_authority     = $request->domain_authority;
        $Niche->span_score     = $request->span_score;
        $Niche->domain_rating     = $request->domain_rating;
        $Niche->organic_trafic_ahrefs     = $request->organic_trafic_ahrefs;
        $Niche->organic_trafic_sem     = $request->organic_trafic_sem;
        $Niche->trust_flow     = "0";
        $Niche->citation_flow = "0";
        $Niche->email_webmaster = $request->email;
        $Niche->web_description = $request->web_description;
        $Niche->special_note = $request->special_note;
        $Niche->web_url = '';
        $Niche->good = $request->site_quality == "Good" ? 1 : 0;
        $Niche->black_hat = $request->site_quality == "Black" ? 1 : 0;
        $Niche->update();
        $Niche->categories()->sync($request->categories);
        return response()->json(['success'=>"Update"]);
    }
    public function nicheApprove(Request $request, $id)
    {
        $permission = Niche::find($id);
        $check_web_url = $permission->web_name;
        $check_max_niches = Niche::where('web_name', $check_web_url)->where('price','>=',$permission->price)->get();
        $check_min_niches = Niche::where('web_name', $check_web_url)->where('price','<',$permission->price)->get();
        if(count($check_min_niches) > 0 && count($check_max_niches) > 0){
            if (count($check_max_niches) > 0 ) {
                foreach ($check_max_niches as $niche) {
                    $del_obj = Niche::find($niche->id);
                    $del_obj->delete();
                }
            }
            if(count($check_min_niches) > 0){
                foreach ($check_min_niches as $niche) {
                    $obj = Niche::find($niche->id);
                    $obj->status = 'Approved';
                    $obj->update();
                }
            }
            
            return response()->json(['success'=>"Approved"]);

        }else{
            if ($permission->status == 'Pending' || $permission->status == 'Rejected') {
                $permission->status = 'Approved';
                if($permission->niche_new_price > 0){
                    $permission->price =$permission->niche_new_price;
                    $permission->niche_new_price=0;
                }
                $permission->update();
                return response()->json(['success'=>"Approved"]);
            } elseif ($permission->status == 'Approved') {
                return response()->json(['info'=>"Already Approved"]);
            }
        }
    }
    public function nicheReject(Request $request, $id)
    {
        $permission = Niche::find($id);
        if ($permission->status == 'Pending' || $permission->status == 'Approved') {
            $permission->status = 'Rejected';
            $permission->update();
            return response()->json(['success'=>"Rejected"]);

        } elseif ($permission->status == 'Rejected') {
            return response()->json(['info'=>"Already Rejected"]);
        }
    }
    public function nicheGood($id)
    {
        $permission = Niche::find($id);
        if($permission->good != 1){
            $permission->good = 1;
            $permission->black_hat = 0;
            $permission->update();
            return response()->json(['success'=>"Good Request"]);
        }else{
            return response()->json(['info'=>"Already Good Request"]);
        }
    }
    public function nicheBlackhat($id)
    {
        $permission = Niche::find($id);
        if($permission->black_hat != 1){
            $permission->good = 0;
            $permission->black_hat = 1;
            $permission->update();
            return response()->json(['success'=>"Black Hat Request"]);
        }else{
            return response()->json(['info'=>"Already Black Hat Request"]);
        }
    }
    public function nicheSpam(Request $request)
    {
        $ids = $request->ids;
        Niche::whereIn('id', explode(",", $ids))->update(['spam' => 1]);
        return response()->json(['success' => "Add to Spam Request Successfully"]);
    }
    public function guestRequestSpam(Request $request)
    {
        $ids = $request->ids;
        UserRequest::whereIn('id', explode(",", $ids))->update(['spam' => 1]);
        return response()->json(['success' => "Add to Spam Request Successfully"]);
    }
    public function guestUnspam($id)
    {
        $permission = UserRequest::find($id);
        if($permission->spam == 1){
            $permission->spam = 0;
            $permission->update();
            return response()->json(['success'=>"Un-Spam Request"]);   
        }else{
            return response()->json(['info'=>"Already Spam Request"]);
        }
    }
    public function guestRequestGood($id)
    {
        $permission = UserRequest::find($id);
        if($permission->good != 1){
            $permission->good = 1;
            $permission->black_hat = 0;
            $permission->update();
            return response()->json(['success'=>"Good Request"]);
        }else{
            return response()->json(['info'=>"Already Good Request"]);
        }
    }
    public function guestRequestBlackhat($id)
    {
        $permission = UserRequest::find($id);
        if($permission->black_hat != 1){
            $permission->black_hat = 1;
            $permission->good = 0;
            $permission->update();
            return response()->json(['success'=>"Black Hat Request"]);
        }else{
            return response()->json(['info'=>"Already Black Hat Request"]);
        }
    }
    public function singleGuestSpam($id){
        UserRequest::whereIn('id', explode(",", $id))->update(['spam' => 1]);
        return response()->json(['success'=>"Add to Spam Request Successfully"]);
    }

    public function guestSpamWebsites()
    {
        $data = UserRequest::where('spam',1)->get();
        $empty_message = "There is no Spam Request";
        return view('pages.guest.spam-request', compact('data', 'empty_message'));
    }
    public function casinoGood($id)
    {
        $permission = CasinoRequest::find($id);
        if($permission->good != 1){
            $permission->good = 1;
            $permission->black_hat = 0;
            $permission->update();
            return response()->json(['success'=>"Good Request"]);
        }else{
            return response()->json(['info'=>"Already Good Request"]);
        }
    }
    public function casinoBlackhat($id)
    {
        $permission = CasinoRequest::find($id);
        if($permission->black_hat != 1){
            $permission->black_hat = 1;
            $permission->good = 0;
            $permission->update();
            return response()->json(['success'=>"Black Hat Request"]);
        }else{
            return response()->json(['info'=>"Already Black Hat Request"]);
        }
    }
    public function casinoSpam(Request $request)
    {
        $ids = $request->ids;
        CasinoRequest::whereIn('id', explode(",", $ids))->update(['spam' => 1]);
        return response()->json(['success' => "Add to Spam Request Successfully"]);
    }

    public function singleCasinoSpam($id)
    {
        CasinoRequest::whereIn('id', explode(",", $id))->update(['spam' => 1]);
        return response()->json(['success' => "Add to Spam Request Successfully"]);
    }

    public function casinoUnspam($id)
    {
        $permission = CasinoRequest::find($id);
        if($permission->spam == 1){
            $permission->spam = 0;
            $permission->update();
            return response()->json(['success'=>"Un-Spam Request"]);   
        }else{
            return response()->json(['info'=>"Already Spam Request"]);
        }
    }
    public function nicheUnspam($id)
    {
        $permission = Niche::find($id);
        if($permission->spam == 1){
            $permission->spam = 0;
            $permission->update();
            return response()->json(['success'=>"Un-Spam Request"]);   
        }else{
            return response()->json(['info'=>"Already Spam Request"]);
        }
    }
    public function nicheSpamWebsites()
    {
        $data = Niche::where('spam',1)->get();
        $empty_message = "There is no Spam Request";
        return view('pages.niche.spam-request', compact('data', 'empty_message'));
    }

    public function nicheDelete(Request $request, $id)
    {
        $permission = Niche::find($id);
        if ($permission->status == 'Pending' || $permission->status == 'Approved' || $permission->status == 'Rejected') {
            $permission->status = 'Deleted';
            $permission->update();
            $permission->delete();
            return response()->json(['success'=>"Niche has been deleted"]);
        }
    }
    public function singleNicheSpam($id)
    {
        Niche::whereIn('id', explode(",", $id))->update(['spam' => 1]);
        return response()->json(['success'=>"Add to Spam Request Successfully"]);
    }
    public function showDeleteNiches()
    {
        $trashed = Niche::onlyTrashed()->get();
        $empty_message = "There is no deleted Request";
        return view('pages.niche.deleted-niche', compact('trashed', 'empty_message'));
    }
    public function clearNiche(Request $request, $id)
    {
        $permanent_delete = Niche::onlyTrashed()->find($id);
        $permanent_delete->forceDelete();
        return back()->with('success', 'Request has been deleted permanently');
    }
    public function restoreNiche(Request $request, $id)
    {
        $restored = Niche::onlyTrashed()->find($id)->restore();
        $restored_request = Niche::find($id);
        $restored_request->status = 'Pending';
        $restored_request->update();
        return back()->with('success', 'Request has been restored ');
    }
    public function deleteSelectedNiches(Request $request)
    {
        $ids = $request->ids;
        DB::table("niches")->whereIn('id',explode(",",$ids))->delete();
        return response()->json(['success'=>"Selected Requests Deleted successfully."]);
    }
    public function showSingleNiche($id)
    {
        $request = Niche::find($id);
        return view('pages.single-request', compact('request'));
    }

    public function today($status)
    {
        $status = $status;
        $users = User::all();
        $approved = UserRequest::where('status', 'Approved')->count();
        $rejected = UserRequest::where('status', 'Rejected')->count();
        $deleted = UserRequest::where('status', 'Deleted')->count();
        $pending = UserRequest::where('status', 'Pending')->count();
        $to = Carbon::today();
        $from = Carbon::today();
        $days_array = [];
        $period = CarbonPeriod::create($from, $to);
        $chartdata = [];
        $totalCount = 0;
        foreach ($period as $date) {
            $date = Carbon::parse($date)->format('Y-m-d 00:00:00');
            $enddate = Carbon::parse($date)->format('Y-m-d 23:59:59');
            array_push($days_array, Carbon::parse($date)->isoFormat('Do'));
            $user_request = UserRequest::whereBetween('created_at', [$date, $enddate])->where('status', $status)->count();
            array_push($chartdata, $user_request);
        }
        $max = round(($totalCount + 10 / 2) / 10) * 10;
        $chart_data_array = array(
            'days' => $days_array,
            'max' => $max,
            'count_data' => $chartdata,
        );
        return view('graphs.selected-result', $chart_data_array, compact('users', 'approved', 'pending', 'deleted', 'rejected', 'status'));
    }
    public function yesterdayStats($status)
    {
        $status = $status;
        $users = User::all();
        $approved = UserRequest::where('status', 'Approved')->count();
        $rejected = UserRequest::where('status', 'Rejected')->count();
        $deleted = UserRequest::where('status', 'Deleted')->count();
        $pending = UserRequest::where('status', 'Pending')->count();


        $to = Carbon::yesterday();
        $from = Carbon::yesterday();
        $days_array = [];
        $period = CarbonPeriod::create($from, $to);
        $chartdata = [];
        $totalCount = 0;
        foreach ($period as $date) {
            $date = Carbon::parse($date)->format('Y-m-d 00:00:00');
            $enddate = Carbon::parse($date)->format('Y-m-d 23:59:59');
            array_push($days_array, Carbon::parse($date)->isoFormat('Do'));
            $user_request = UserRequest::whereBetween('created_at', [$date, $enddate])->where('status', $status)->count();
            array_push($chartdata, $user_request);
        }
        $max = round(($totalCount + 10 / 2) / 10) * 10;
        $chart_data_array = array(
            'days' => $days_array,
            'max' => $max,
            'count_data' => $chartdata,
        );
        return view('graphs.selected-result', $chart_data_array, compact('users', 'approved', 'pending', 'deleted', 'rejected', 'status'));
    }
    public function sevenDays($status)
    {
        $status = $status;
        $users = User::all();
        $approved = UserRequest::where('status', 'Approved')->count();
        $rejected = UserRequest::where('status', 'Rejected')->count();
        $deleted = UserRequest::where('status', 'Deleted')->count();
        $pending = UserRequest::where('status', 'Pending')->count();


        $to = Carbon::today();
        $from = Carbon::today()->subDays(7);
        $days_array = [];
        $period = CarbonPeriod::create($from, $to);
        $chartdata = [];
        $totalCount = 0;
        foreach ($period as $date) {
            $date = Carbon::parse($date)->format('Y-m-d 00:00:00');
            $enddate = Carbon::parse($date)->format('Y-m-d 23:59:59');
            array_push($days_array, Carbon::parse($date)->isoFormat('Do'));
            $user_request = UserRequest::whereBetween('created_at', [$date, $enddate])->where('status', $status)->count();
            array_push($chartdata, $user_request);
        }
        $max = round(($totalCount + 10 / 2) / 10) * 10;
        $chart_data_array = array(
            'days' => $days_array,
            'max' => $max,
            'count_data' => $chartdata,
        );
        return view('graphs.selected-result', $chart_data_array, compact('users', 'approved', 'pending', 'deleted', 'rejected', 'status'));
    }
    public function lastThirtyDays($status)
    {
        $status = $status;
        $users = User::all();
        $approved = UserRequest::where('status', 'Approved')->count();
        $rejected = UserRequest::where('status', 'Rejected')->count();
        $deleted = UserRequest::where('status', 'Deleted')->count();
        $pending = UserRequest::where('status', 'Pending')->count();
        $to = Carbon::today();
        $from = Carbon::today()->subDays(30);
        $days_array = [];
        $period = CarbonPeriod::create($from, $to);
        $chartdata = [];
        $totalCount = 0;
        foreach ($period as $date) {
            $date = Carbon::parse($date)->format('Y-m-d 00:00:00');
            $enddate = Carbon::parse($date)->format('Y-m-d 23:59:59');
            array_push($days_array, Carbon::parse($date)->isoFormat('Do'));
            $user_request = UserRequest::whereBetween('created_at', [$date, $enddate])->where('status', $status)->count();
            array_push($chartdata, $user_request);
        }
        $max = round(($totalCount + 10 / 2) / 10) * 10;
        $chart_data_array = array(
            'days' => $days_array,
            'max' => $max,
            'count_data' => $chartdata,
        );
        return view('graphs.selected-result', $chart_data_array, compact('users', 'approved', 'pending', 'deleted', 'rejected', 'status'));
    }
    public function thisMonth($status)
    {
        $status = $status;
        $users = User::all();
        $approved = UserRequest::where('status', 'Approved')->count();
        $rejected = UserRequest::where('status', 'Rejected')->count();
        $deleted = UserRequest::where('status', 'Deleted')->count();
        $pending = UserRequest::where('status', 'Pending')->count();
        $to = Carbon::today();
        $from = Carbon::today()->startOfMonth();
        $days_array = [];
        $period = CarbonPeriod::create($from, $to);
        $chartdata = [];
        $totalCount = 0;
        foreach ($period as $date) {
            $date = Carbon::parse($date)->format('Y-m-d 00:00:00');
            $enddate = Carbon::parse($date)->format('Y-m-d 23:59:59');
            array_push($days_array, Carbon::parse($date)->isoFormat('Do'));
            $user_request = UserRequest::whereBetween('created_at', [$date, $enddate])->where('status', $status)->count();
            array_push($chartdata, $user_request);
        }
        $max = round(($totalCount + 10 / 2) / 10) * 10;
        $chart_data_array = array(
            'days' => $days_array,
            'max' => $max,
            'count_data' => $chartdata,
        );
        return view('graphs.selected-result', $chart_data_array, compact('users', 'approved', 'pending', 'deleted', 'rejected', 'status'));
    }
    public function lastMonth($status)
    {
        $status = $status;
        $users = User::all();
        $approved = UserRequest::where('status', 'Approved')->count();
        $rejected = UserRequest::where('status', 'Rejected')->count();
        $deleted = UserRequest::where('status', 'Deleted')->count();
        $pending = UserRequest::where('status', 'Pending')->count();
        $to = Carbon::today()->subMonth(1)->endOfMonth();
        $from = Carbon::today()->subMonth(1)->startOfMonth();
        $days_array = [];
        $period = CarbonPeriod::create($from, $to);
        $chartdata = [];
        $totalCount = 0;

        foreach ($period as $date) {
            $date = Carbon::parse($date)->format('Y-m-d 00:00:00');
            $enddate = Carbon::parse($date)->format('Y-m-d 23:59:59');
            array_push($days_array, Carbon::parse($date)->isoFormat('Do'));
            $user_request = UserRequest::whereBetween('created_at', [$date, $enddate])->where('status', $status)->count();

            array_push($chartdata, $user_request);
        }
        $max = round(($totalCount + 10 / 2) / 10) * 10;
        $chart_data_array = array(
            'days' => $days_array,
            'max' => $max,
            'count_data' => $chartdata,
        );
        return view('graphs.selected-result', $chart_data_array, compact('users', 'approved', 'pending', 'deleted', 'rejected', 'status'));
    }
    public function customRange(Request $request, $status)
    {
        $request->validate([
            'to' => 'required',
            'from' => 'required'
        ]);
        $users = User::all();
        $approved = UserRequest::where('status', 'Approved')->count();
        $rejected = UserRequest::where('status', 'Rejected')->count();
        $deleted = UserRequest::where('status', 'Deleted')->count();
        $pending = UserRequest::where('status', 'Pending')->count();
        $to = $request->to;
        $from = $request->from;
        $days_array = [];
        $period = CarbonPeriod::create($from, $to);
        $chartdata = [];
        $totalCount = 0;
        foreach ($period as $date) {
            $date = Carbon::parse($date)->format('Y-m-d 00:00:00');
            $enddate = Carbon::parse($date)->format('Y-m-d 23:59:59');
            array_push($days_array, Carbon::parse($date)->isoFormat('Do'));
            $user_request = UserRequest::whereBetween('created_at', [$date, $enddate])->where('status', $status)->count();
            array_push($chartdata, $user_request);
        }
        $max = round(($totalCount + 10 / 2) / 10) * 10;
        $chart_data_array = array(
            'days' => $days_array,
            'max' => $max,
            'count_data' => $chartdata,
        );
        return view('graphs.selected-result', $chart_data_array, compact('users', 'approved', 'pending', 'deleted', 'rejected', 'status'));
    }
    public function export()
    {
        return Excel::download(new RequestExport, 'request.xlsx');
        return Excel::download(new BulkExport, 'bulkData.xlsx');
    }
    public function xyz()
    {
        return view('test');
    }
    public function specific_chart(Request $request)
    {
        $to = empty($request->to) ? Carbon::now() : $request->to;
        $from = empty($request->from) ? Carbon::now()->subDays(20) : $request->from;
        $days_array = [];

        $period = CarbonPeriod::create($from, $to);
        $app_request = [];
        $pend_request = [];
        $rej_request = [];
        $del_request = [];
        $totalCount = 0;
        foreach ($period as $date) {
            $date = Carbon::parse($date)->format('Y-m-d 00:00:00');
            $enddate = Carbon::parse($date)->format('Y-m-d 23:59:59');
            array_push($days_array, Carbon::parse($date)->isoFormat('Do'));

            if ($request->approved == 'true') {
                $app_req = UserRequest::whereBetween('created_at', [$date, $enddate])->where('status', 'Approved')->count();
                array_push($app_request, $app_req);
            }
            if ($request->pending == 'true') {
                $pend_req = UserRequest::whereBetween('created_at', [$date, $enddate])->where('status', 'Pending')->count();
                array_push($pend_request, $pend_req);
            }
            if ($request->rejected == 'true') {
                $rej_req = UserRequest::whereBetween('created_at', [$date, $enddate])->where('status', 'Rejected')->count();
                array_push($rej_request, $rej_req);
            }
            if ($request->deleted == 'true') {
                $del_req = UserRequest::whereBetween('created_at', [$date, $enddate])->where('status', 'Deleted')->count();
                array_push($del_request, $del_req);
            }
        }
        $max = round(($totalCount + 10 / 2) / 10) * 10;
        $chart_data_array = array(
            'days' => $days_array,
            'max' => $max,
            'approved_request' => $app_request,
            'pending_request' => $pend_request,
            'deleted_request' => $del_request,
            'rejected_request' => $rej_request,
        );
        return $chart_data_array;
    }
    public function filter(Request $request)
    {
        $guest_requests = UserRequest::with(['categories','coodinator']);

        if($request->status ){
            $guest_requests->where(['status'=> $request->status]);
        }
        if($request->category){
            $category = $request->category;
            $guest_requests->whereHas('categories', function($q) use ($category){
                return $q->where('categories.id', $category);
            });
        }
        if($request->to && $request->from){
            $guest_requests->wherebetween('created_at', array($request->to, $request->from));
        }
        if($request->domain_upper && $request->domain_lower){
            $guest_requests->wherebetween('domain_authority', [$request->domain_upper , $request->domain_lower]);
        }
        if($request->raitings_upper && $request->raitings_lower){
            $guest_requests->wherebetween('domain_rating',  [$request->raitings_upper, $request->raitings_lower]);
        }
        if($request->web_upper && $request->web_lower){
            $guest_requests->wherebetween('price',  [$request->web_upper, $request->web_lower]);
        }
        if($request->span_upper && $request->span_lower){
            $guest_requests->wherebetween('span_score',  [$request->span_upper ,$request->span_lower]);
        }
        if($request->company_upper && $request->company_lower){
            $guest_requests->wherebetween('company_price',  [$request->company_upper , $request->company_lower]);
        }  
        if($request->traffic_upper && $request->traffic_lower){
            $guest_requests->wherebetween('organic_trafic_ahrefs',[$request->traffic_upper , $request->traffic_lower]);
        }  
        if($request->organic_upper && $request->traffic_lower){
            $guest_requests->wherebetween('organic_trafic_sem',[$request->organic_upper , $request->traffic_lower]);
        }   
         
        $guest_requests = $guest_requests->get();
            
        return view('pages.advance-filter', compact('guest_requests'));
    }
    public function showSearch()
    {
        $search_text = $_GET['query'];
        $products = UserRequest::query()->where('web_name', 'LIKE', "%{$search_text}%")
        ->orWhere('email_webmaster', 'LIKE', "%{$search_text}%")
        ->orWhere('Coordinator', 'LIKE', "%{$search_text}%")
        ->orWhere('status', 'LIKE', "%{$search_text}%")
        ->get();
        return view('pages.searchData', compact('products'));
    }
    public function importExportView()
    {
       return view('admin.show.guest.request', compact('guestCoordinator'));
    }

    public function importstore(Request $request)
    {
        $validate = $request->validate([
            'file' => 'required|max:5000|mimes:xlsx,xls,csv'
        ]);
        Excel::import(new UserRequestImport,$request->file);
        return back()->with('success','Data Imported Successfully');
    }

}
