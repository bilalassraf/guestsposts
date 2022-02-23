<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Category;
use App\Models\Niche;
use App\Models\UserRequest;
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
use Illuminate\Support\Facades\DB as FacadesDB;
use DataTables;
class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        $approved = UserRequest::where('status', 'approved')->count();
        $rejected = UserRequest::where('status', 'rejected')->count();
        $deleted = UserRequest::where('status', 'deleted')->count();
        $pending = UserRequest::where('status', 'pending')->count();
        return view('admin.dashboard.admin-dashboard', compact('users', 'approved', 'pending', 'deleted', 'rejected'));
    }
    public function addCategory(Request $request)
    {
        Category::create([
            'category' => $request->category,
        ]);
        return redirect('user/dashboard')->with('success', 'Category added successfully');
    }
    public function showCategories()
    {
        $categories = Category::all();
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

        $request->validate([
            'web_name'         => 'required|unique:user_requests',
            'coordinator'      => 'required',
            'price'            => 'required|integer|regex:/^[-0-9\+]+$/',
            // 'company_price'    => 'required|integer|regex:/^[-0-9\+]+$/',
            'categories'         => 'required',
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
        ],
        [
            'web_name.unique' => 'Sorry, this URL is already in Build with'
        ]);
        $percentage = 8/100 * $request->price;
        $company_price = ($request->price * $percentage + 50) + $request->price;

        $user = User::find($request->user_id);
        $userRequest = new UserRequest();
        $userRequest->web_name = $request->web_name;
        $userRequest->coordinator = $request->coordinator;
        $price = $userRequest->price = $request->price;
        $userRequest->company_price  = $company_price;
        //$userRequest->category = $request->category;
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
        return redirect(route('admin.show.guest.request'))->with('success', 'Your request has submitted');
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
    public function createUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required'
        ]);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
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
        $request = UserRequest::where('user_id', $user->id)->get();
        $user_niche = User::find($id);
        $request_niche = Niche::where('user_id', $user->id)->get();
        return view('pages.user-profile', compact('user', 'request','user_niche' , 'request_niche'));
    }
    public function addGuestRequestForm()
    {
        $categories = Category::all();
        return view('pages.guest.add-websites', compact('categories'));
    }
    public function showGuestRequests()
    {
        $user = User::find(Auth::user()->id);
        if($user->type == 'admin'){
            $guest_requests = UserRequest::orderBy('id', 'DESC')->get();
        }else{
            $guest_requests = $user->user_request;
        }
        return view('pages.guest.all-web-requests', compact("guest_requests"));
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
        if ($permission->status == 'pending' || $permission->status == 'rejected') {
            $permission->status = 'approved';
            $permission->update();
            return back()->with('success', 'Request has been approved');
        } elseif ($permission->status == 'approved') {
            return back()->with('info', 'Request is already approved');
        }
    }
    public function nicheRejected($id)
    {
        $permission = UserRequest::find($id);
        if ($permission->status == 'pending' || $permission->status == 'approved') {
            $permission->status = 'rejected';
            $permission->update();
            return back()->with('success', 'Request has been Rejected');
        } elseif ($permission->status == 'rejected') {
            return back()->with('info', 'Request is already Rejected');
        }
    }
    public function guestRequestDelete($id)
    {
        $permission = UserRequest::find($id);
        if ($permission->status == 'pending' || $permission->status == 'approved' || $permission->status == 'rejected') {
            $permission->status = 'deleted';
            $permission->update();
            $permission->delete();
            return redirect(route('admin.show.guest.request'))->with('success', 'Request has been deleted');
        }
    }
    public function makeAdmin($id)
    {
        $user = User::find($id);
        $user->type = 'admin';
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
        $restored_request->status = 'pending';
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
        // $ids = $request->ids;
        // if (!empty($ids)) {
        //     foreach ($ids as $id) {
        //         UserRequest::where('id', $id)->get()->each->delete();
        //     }
        //     return back()->with('success', 'Selected users has been removed');
        // } else {
        //     return back()->with('info', 'Selecte a request before this opreation');
        // }
        return response()->json(['success'=>"Selected Requests Deleted successfully."]);
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
            return back()->with('info', 'Selecte a user before this opreation');
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

            $app_req = UserRequest::whereBetween('created_at', [$date, $enddate])->where('status', 'approved')->count();
            $pend_req = UserRequest::whereBetween('created_at', [$date, $enddate])->where('status', 'pending')->count();
            $rej_req = UserRequest::whereBetween('created_at', [$date, $enddate])->where('status', 'rejected')->count();
            $del_req = UserRequest::whereBetween('created_at', [$date, $enddate])->where('status', 'deleted')->count();
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
        $categories = Category::all();
        return view('pages.guest.all-web-requests', compact('web_request', 'categories'));
    }
    public function updateRequest(Request $request, $id)
    {
        $niches = UserRequest::all();
        $userRequest = UserRequest::find($id);
        $userRequest->web_name = $request->web_name;
        $userRequest->coordinator = $request->coordinator;
        $price = $userRequest->price = $request->price;
        $userRequest->company_price  = $request->company_price;
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
        $userRequest->categories()->sync($request->categories);
        return back()->with('success', 'Request updated successfully');
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
        $approved = UserRequest::where('status', 'approved')->count();
        $rejected = UserRequest::where('status', 'rejected')->count();
        $deleted = UserRequest::where('status', 'deleted')->count();
        $pending = UserRequest::where('status', 'pending')->count();
        switch ($requestName) {
            case ('approved'):
                $status = 'approved';
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

            case ('pending'):
                $status = 'pending';
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
            case ('rejected'):
                $status = 'rejected';
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
            case ('deleted'):
                $status = 'deleted';
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
        $userRequest->trust_flow     = $request->trust_flow;
        $userRequest->citation_flow = $request->citation_flow;
        $userRequest->email_webmaster = $request->email;
        $userRequest->web_description = $request->web_description;
        $userRequest->special_note = $request->special_note;
        $user->user_request()->save($userRequest);
        return redirect(route('admin.show.guest'))->with('success', 'Your request has submitted');
    }
    public function showAddGuestForm()
    {
        $categories = Category::all();
        return view('pages.add-niche', compact('categories'));
    }
    public function showGuest()
    {
        $niches = UserRequest::all();
        return view('pages.all-niche-request', compact('niches'));
    }
    public function permissions(Request $request, $id)
    {
        $user = User::find($id);
        $user->user_info = $request->user_info ? 'on' : 'off';
        $user->add_guest_post = $request->add_guest_post ? 'on' : 'off';
        $user->view_all_guest_post = $request->view_all_guest_post ? 'on' : 'off';
        $user->view_deleted_guest_post = $request->view_deleted_guest_post ? 'on' : 'off';
        $user->add_niche = $request->add_niche ? 'on' : 'off';
        $user->view_niches = $request->view_niches ? 'on' : 'off';
        $user->deleted_niches = $request->deleted_niches ? 'on' : 'off';
        $user->add_category = $request->add_category ? 'on' : 'off';
        $user->view_all_categories = $request->view_all_categories ? 'on' : 'off';
        $user->update();
        return back()->with('success', 'Changes Updated Successfully');
    }

    //niche methods
    public function addNicheForm()
    {
        $categories = Category::all();
        return view('pages.niche.add-niche', compact('categories'));
    }
    public function addStoreNiche(Request $request)
    {
       // preg_replace( "#^[^:/.]*[:/]+#i", "", $request->web_url );
        $url = parse_url($request->web_url);
        $host = $url['host'];
        $host =  str_replace('www.' , '', $host);
        $request->web_url = $host;
        $request->validate([
            
            'coordinator'      => 'required',
            'price'            => 'required|integer',
            // 'company_price'    => 'required|integer',
            'categories'         => 'required',
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
        ],
        [
            'web_name.unique' => 'Sorry, this URL is already in Build with'
        ]
    );
        $check = Niche::where('web_url',$request->web_url)->first();
        if($check){
            return redirect()->back()->with('warning', 'Url alerady exists')->withInput($request->all());
        }
        $check = Niche::where('web_name',$request->web_name)->first();
        if($check){
            return redirect()->back()->with('warning', 'Website name alerady exists')->withInput($request->all());
        }
        $percentage = 8/100 * $request->price;
        $company_price = ($request->price * $percentage + 50) + $request->price;

        $user = User::find($request->user_id);
        $Niche = new Niche();
        $Niche->web_name = $request->web_name;
        $Niche->coordinator = $request->coordinator;
        $price = $Niche->price = $request->price;
        $Niche->company_price  =  $company_price;
        //$Niche->category     = $request->category;
        $Niche->domain_authority     = $request->domain_authority;
        $Niche->span_score     = $request->span_score;
        $Niche->domain_rating     = $request->domain_rating;
        $Niche->organic_trafic_ahrefs     = $request->organic_trafic_ahrefs;
        $Niche->organic_trafic_sem     = $request->organic_trafic_sem;
        $Niche->trust_flow     = $request->trust_flow;
        $Niche->citation_flow = $request->citation_flow;
        $Niche->email_webmaster = $request->email;
        $Niche->web_description = $request->web_description;
        $Niche->special_note = $request->special_note;
        $Niche->web_url = preg_replace( "#^[^:/.]*[:/]+#i", "", $request->web_url );
        $user->niche()->save($Niche);
        $Niche->categories()->sync($request->categories);
        return redirect(route('admin.show.niches'))->with('success', 'Your request has submitted');
    }
    public function webRequests()
    {
        $user = User::find(Auth::user()->id);
        if($user->type == 'admin'){
            $guest_requests = UserRequest::with('categories')->orderBy('id', 'DESC')->get();
        }else{

            $guest_requests = $user->user_request()->with('categories');
        }
        return DataTables::of($guest_requests)
        ->addColumn('check_box', function($row){

            return '<label><input type="checkbox" class="check sub_chk" value="'.$row->id.'" name="ids[]"></label>
                    <a href="#" style="cursor: pointer; color:black; display: inline;" class="detail dropdown-toggle">
                        Detail
                    </a>';
        })->addColumn('actions', function($request){
            return view('pages.guest.actions', compact('request'));
        })->addColumn('categories', function ($request) {
            return implode(', ', $request->categories->pluck('category')->toArray());
        })
        ->editColumn('updated_at', function($row){
           return date("Y-m-d h:i:s", strtotime($row->updated_at));
        })
     ->rawColumns(['check_box','action','categories'])
        ->make(true);
    }
    public function nicheRequests()
    {
        $user = User::find(Auth::user()->id);
        if($user->type == 'admin'){
            $niches = Niche::with('categories')->get();
        }else{
            $niches = $user->Niche()->with('categories')->get();
        }
        return DataTables::of($niches)
        ->addColumn('check_box', function($row){

            return '<label><input type="checkbox" class="check sub_chk" value="'.$row->id.'" name="ids[]"></label>
                    <a href="#" style="cursor: pointer; color:black; display: inline;" class="detail dropdown-toggle">
                        Detail
                    </a>';
        })->addColumn('niche_actions', function($niche){
            return view('pages.niche.niche-actions', compact('niche'));
        })
        ->editColumn('updated_at', function($row){
           return date("Y-m-d h:i:s", strtotime($row->updated_at));
        })->addColumn('categories', function ($row) {
            return implode(', ', $row->categories->pluck('category')->toArray());
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
                    <a href="#" style="cursor: pointer; color:black; display: inline;" class="detail dropdown-toggle">
                        Detail
                    </a>';
        })->addColumn('categories', function ($request) {
            return implode(', ', $request->categories->pluck('category')->toArray());
        })
        ->editColumn('updated_at', function($row){
           return date("Y-m-d h:i:s", strtotime($row->updated_at));
        })
     ->rawColumns(['check_box','actions','categories'])
        ->make(true);
    }
    public function addShowNiches()
    {
        $user = User::find(Auth::user()->id);
        if($user->type == 'admin'){
            $niches = Niche::all();
        }else{
            $niches = $user->Niche;
        }
        $categories = Category::all();
        return view('pages.niche.all-niche-request', compact('niches', 'categories'));
    }
    public function editNicheRequest(Request $request, $id)
    {
        $niche_request = Niche::find($id);
        $categories = Category::all();
        return view('pages.niche.edit-niche', compact('niche_request', 'categories'));
    }
    public function updateNicheRequest(Request $request, $id)
    {
        $Niche = Niche::find($id);
        $Niche->web_name = $request->web_name;
        $Niche->coordinator = $request->coordinator;
        $price = $Niche->price = $request->price;
        $Niche->company_price  = $request->company_price;
        //$Niche->category     = $request->category;
        $Niche->domain_authority     = $request->domain_authority;
        $Niche->span_score     = $request->span_score;
        $Niche->domain_rating     = $request->domain_rating;
        $Niche->organic_trafic_ahrefs     = $request->organic_trafic_ahrefs;
        $Niche->organic_trafic_sem     = $request->organic_trafic_sem;
        $Niche->trust_flow     = $request->trust_flow;
        $Niche->citation_flow = $request->citation_flow;
        $Niche->email_webmaster = $request->email;
        $Niche->web_description = $request->web_description;
        $Niche->special_note = $request->special_note;
        $Niche->web_url = $request->web_url;
        $Niche->update();
        $Niche->categories()->sync($request->categories);
        return redirect(route('admin.show.niches'))->with('success', 'Your Niche has been Updated');
    }
    public function nicheApprove(Request $request, $id)
    {
        $permission = Niche::find($id);
        if ($permission->status == 'pending' || $permission->status == 'rejected') {
            $permission->status = 'approved';
            $permission->update();
            return back()->with('success', 'Request has been approved');
        } elseif ($permission->status == 'approved') {
            return back()->with('info', 'Request is already approved');
        }
    }
    public function nicheReject(Request $request, $id)
    {
        $permission = Niche::find($id);
        if ($permission->status == 'pending' || $permission->status == 'approved') {
            $permission->status = 'rejected';
            $permission->update();
            return back()->with('success', 'Niche has been Rejected');
        } elseif ($permission->status == 'rejected') {
            return back()->with('info', 'Niche is already Rejected');
        }
    }
    public function nicheDelete(Request $request, $id)
    {
        $permission = Niche::find($id);
        if ($permission->status == 'pending' || $permission->status == 'approved' || $permission->status == 'rejected') {
            $permission->status = 'deleted';
            $permission->update();
            $permission->delete();
            return back()->with('success', 'Niche has been deleted');
        }
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
        $restored_request->status = 'pending';
        $restored_request->update();
        return back()->with('success', 'Request has been restored ');
    }
    public function deleteSelectedNiches(Request $request)
    {
        $ids = $request->ids;
        if (!empty($ids)) {
            foreach ($ids as $id) {
                Niche::where('id', $id)->get()->each->delete();
            }
            return back()->with('success', 'Selected Niche has been removed');
        } else {
            return back()->with('info', 'Selecte a Niche before this opreation');
        }
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
        $approved = UserRequest::where('status', 'approved')->count();
        $rejected = UserRequest::where('status', 'rejected')->count();
        $deleted = UserRequest::where('status', 'deleted')->count();
        $pending = UserRequest::where('status', 'pending')->count();
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
        $approved = UserRequest::where('status', 'approved')->count();
        $rejected = UserRequest::where('status', 'rejected')->count();
        $deleted = UserRequest::where('status', 'deleted')->count();
        $pending = UserRequest::where('status', 'pending')->count();


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
        $approved = UserRequest::where('status', 'approved')->count();
        $rejected = UserRequest::where('status', 'rejected')->count();
        $deleted = UserRequest::where('status', 'deleted')->count();
        $pending = UserRequest::where('status', 'pending')->count();


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
        $approved = UserRequest::where('status', 'approved')->count();
        $rejected = UserRequest::where('status', 'rejected')->count();
        $deleted = UserRequest::where('status', 'deleted')->count();
        $pending = UserRequest::where('status', 'pending')->count();
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
        $approved = UserRequest::where('status', 'approved')->count();
        $rejected = UserRequest::where('status', 'rejected')->count();
        $deleted = UserRequest::where('status', 'deleted')->count();
        $pending = UserRequest::where('status', 'pending')->count();
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
        $approved = UserRequest::where('status', 'approved')->count();
        $rejected = UserRequest::where('status', 'rejected')->count();
        $deleted = UserRequest::where('status', 'deleted')->count();
        $pending = UserRequest::where('status', 'pending')->count();
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
        $approved = UserRequest::where('status', 'approved')->count();
        $rejected = UserRequest::where('status', 'rejected')->count();
        $deleted = UserRequest::where('status', 'deleted')->count();
        $pending = UserRequest::where('status', 'pending')->count();
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
                $app_req = UserRequest::whereBetween('created_at', [$date, $enddate])->where('status', 'approved')->count();
                array_push($app_request, $app_req);
            }
            if ($request->pending == 'true') {
                $pend_req = UserRequest::whereBetween('created_at', [$date, $enddate])->where('status', 'pending')->count();
                array_push($pend_request, $pend_req);
            }
            if ($request->rejected == 'true') {
                $rej_req = UserRequest::whereBetween('created_at', [$date, $enddate])->where('status', 'rejected')->count();
                array_push($rej_request, $rej_req);
            }
            if ($request->deleted == 'true') {
                $del_req = UserRequest::whereBetween('created_at', [$date, $enddate])->where('status', 'deleted')->count();
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
        $category = $request->category;
        $guest_requests = UserRequest::where([
            ['status', $request->status]
        ])->whereHas('categories', function($q) use ($category){
            return $q->where('categories.id', $category);
        })->orwherebetween('created_at', array($request->to, $request->from))
            ->orwherebetween('domain_rating', [$request->raitings_lower, $request->raitings_upper])
            ->wherebetween('price', [$request->web_lower, $request->web_upper])
            ->wherebetween('span_score', [$request->span_lower, $request->span_upper])
            ->wherebetween('company_price', [$request->company_lower, $request->company_upper])
            ->wherebetween('trust_flow', [$request->trust_lower, $request->trust_upper])
            ->wherebetween('citation_flow', [$request->citation_lower, $request->citation_upper])
            ->wherebetween('organic_trafic_ahrefs', [$request->traffic_lower, $request->traffic_upper])
            ->wherebetween('organic_trafic_ahrefs', [$request->organic_lower, $request->organic_upper])->with('categories')->get();
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
       return view('admin.show.guest.request');
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
