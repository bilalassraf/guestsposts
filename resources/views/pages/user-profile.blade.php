@extends('layouts.default')
@section('title')
Profile
@endsection

<style type="text/css">
    .card-primary.card-outline {
        border-top: 3px solid #00695B !important;
    }

    button.btn.btn-primary.bg-green.text-centergi {}

    button.btn.btn-primary.bg-green.text-centergi {
        width: 26%;
        float: right;
    }

    .form-control-image {
        height: calc(2.800rem + 0px) !important;
        padding: -0.5rem 1rem !important;
    }

    /*   a:hover {
      color: red !important;
    }*/

</style>
@section('content')
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script>
    $('#allow_user_info').bootstrapToggle();
    $(function() {
        $('#allow_user_info').bootstrapToggle({
            on: 'Allow'
            , off: 'Deny'
        });
    })
    function onlyNumberKey(evt) {
          var ASCIICode = (evt.which) ? evt.which : evt.keyCode
          if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
              return false;
          return true;
      }

</script>
<section class="content content-wrapper p-4">
    @include('filter')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            @if($user->profile)
                            <img class="profile-user-img  rounded-circle" src="{{ asset($user->profile) }}" height="100px" width="100px">
                            @else
                            <img src="{{ asset('./images/00000b.png') }}" class="img-circle rounded-circle" alt="User Image" height="100px" width="100px">
                            @endif
                        </div>

                        <h3 class="profile-username text-center">{{ $user->name }}</h3>

                        <p class="text-muted text-center">{{ $user->email }}</p>
                        <div class="text-center mb-2">
                            @if ($user->type == 'User')
                            <a href="{{ route('make.admin', $user->id) }}" class="btn btn-dark text-white">Make Admin</a>
                            @endif
                        </div>
                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b class="text-green">Approved Sites</b> <a class="float-right">{{ $user->user_request()->where('status', 'approved')->count() }}</a>
                            </li>
                            <li class="list-group-item">
                                <b class="text-green">Pending Sites</b> <a class="float-right">{{ $user->user_request()->where('status', 'pending')->count() }}</a>
                            </li>
                            <li class="list-group-item">
                                <b class="text-green">Total Sites</b> <a class="float-right">{{ $user->user_request()->count() }}</a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

                <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills request">
                            @if (auth()->user()->view_all_guest_post == "on")
                                <li class="nav-item"><a class="nav-link site active" href="#requests" data-toggle="tab">Guest Post</a></li>
                            @endif
                            @if (auth()->user()->view_niches == "on")
                                <li class="nav-item"><a class="nav-link site" href="#niche" data-toggle="tab">Niche Post</a></li>
                            @endif
                            @if (auth()->user()->view_all_casino_post == "on")
                                <li class="nav-item"><a class="nav-link site" href="#casino" data-toggle="tab">Casino Post</a></li>
                            @endif
                            <li class="nav-item"><a class="nav-link site" href="#about" data-toggle="tab">About</a></li>
                            <li class="nav-item"><a class="nav-link site" href="#update-profile" data-toggle="tab"> Update Profile</a></li>
                            @if(auth()->user()->type == 'Admin' || auth()->user()->type == 'Moderator')
                                <li class="nav-item"><a class="nav-link site" href="#permissions" data-toggle="tab">Permissions</a></li>
                            @endif
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            @if (auth()->user()->view_all_guest_post == "on")
                                <div class="tab-pane active" id="requests">
                                    <div class="tab-pane fade show active" id="timeline" role="tabpanel" aria-labelledby="timeline">
                                        <div class="col-xl-12 recent-order-sec">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <h5>Guest Post</h5>
                                                        <table class="table table-bordernone">
                                                            <thead>
                                                                <tr>
                                                                    <th>#id</th>
                                                                    <th>Website Name</th>
                                                                    <th>Company Price</th>
                                                                    <th>Description</th>
                                                                    <th>Special Note</th>
                                                                    <th>Status</th>
                                                                    @if(auth()->user()->type == 'Admin' || auth()->user()->type == 'Moderator')
                                                                        <th>Action</th>
                                                                    @endif
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                @foreach ($request as $user_request)
                                                                <tr>
                                                                    <td>{{ $user_request->id }}</td>
                                                                    <td>
                                                                        <p>{{ $user_request->web_name }}</p>
                                                                    </td>
                                                                    <td>
                                                                        <p>{{ $user_request->company_price }}</p>
                                                                    </td>
                                                                    <td>
                                                                        <p>{{ Str::limit($user_request->web_description, 20, '...') }}
                                                                        </p>
                                                                    </td>
                                                                    <td>
                                                                        <p>{{ Str::limit($user_request->special_note, 20, '...') }}
                                                                        </p>
                                                                    </td>
                                                                    <td>
                                                                        <p>{{ $user_request->status }}</p>
                                                                    </td>
                                                                    @if(auth()->user()->type == 'Admin' || auth()->user()->type == 'Moderator')
                                                                        <td>
                                                                            <a href="{{ route('admin.guest.request.approved', $user_request->id) }}" class="tick"><i class="text-green fa fa-check" title=""></i></a>
                                                                            <a href="{{ route('admin.guest.request.rejected', $user_request->id) }}" class="edit"><i class="text-green fa fa-close"></i></a>
                                                                            <a href="{{ route('admin.guest.delete.request', $user_request->id) }}" class="delete"><i class="text-green fa fa-trash" title="Delete"></i></a>
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <!-- /.tab-pane -->
                            {{-- niche post --}}
                            @if (auth()->user()->view_niches == "on")
                                <div class="tab-pane" id="niche">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <h5>Niche Post</h5>
                                                        <table class="table table-bordernone">
                                                            <thead>
                                                                <tr>
                                                                    <th>#id</th>
                                                                    <th>Website Name</th>
                                                                    <th>Company Price</th>
                                                                    <th>Description</th>
                                                                    <th>Special Note</th>
                                                                    <th>Status</th>
                                                                    @if(auth()->user()->type == 'Admin' || auth()->user()->type == 'Moderator')
                                                                        <th>Action</th>
                                                                    @endif
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                @foreach ($request_niche as $user_niche)
                                                                <tr>
                                                                    <td>{{ $user_niche->id }}</td>
                                                                    <td>
                                                                        <p>{{ $user_niche->web_name }}</p>
                                                                    </td>
                                                                    <td>
                                                                        <p>{{ $user_niche->company_price }}</p>
                                                                    </td>
                                                                    <td>
                                                                        <p>{{ Str::limit($user_niche->web_description, 20, '...') }}
                                                                        </p>
                                                                    </td>
                                                                    <td>
                                                                        <p>{{ Str::limit($user_niche->special_note, 20, '...') }}
                                                                        </p>
                                                                    </td>
                                                                    <td>
                                                                        <p>{{ $user_niche->status }}</p>
                                                                    </td>
                                                                    @if(auth()->user()->type == 'Admin' || auth()->user()->type == 'Moderator')
                                                                        <td>
                                                                            <a href="{{ route('admin.guest.request.approved', $user_niche->id) }}" class="tick"><i class="text-green fa fa-check" title=""></i></a>
                                                                            <a href="{{ route('admin.guest.request.rejected', $user_niche->id) }}" class="edit"><i class="text-green fa fa-close"></i></a>
                                                                            <a href="{{ route('admin.guest.delete.request', $user_niche->id) }}" class="delete"><i class="text-green fa fa-trash" title="Delete"></i></a>
                                                                        </td>
                                                                    @endif    
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if (auth()->user()->view_all_casino_post == "on")
                                <div class="tab-pane" id="casino">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <h5>Casino Post</h5>
                                                        <table class="table table-bordernone">
                                                            <thead>
                                                                <tr>
                                                                    <th>#id</th>
                                                                    <th>Website Name</th>
                                                                    <th>Company Price</th>
                                                                    <th>Description</th>
                                                                    <th>Special Note</th>
                                                                    <th>Status</th>
                                                                    @if(auth()->user()->type == 'Admin' || auth()->user()->type == 'Moderator')
                                                                        <th>Action</th>
                                                                    @endif
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                @foreach ($request_casino as $user_niche)
                                                                <tr>
                                                                    <td>{{ $user_niche->id }}</td>
                                                                    <td>
                                                                        <p>{{ $user_niche->web_name }}</p>
                                                                    </td>
                                                                    <td>
                                                                        <p>{{ $user_niche->company_price }}</p>
                                                                    </td>
                                                                    <td>
                                                                        <p>{{ Str::limit($user_niche->web_description, 20, '...') }}
                                                                        </p>
                                                                    </td>
                                                                    <td>
                                                                        <p>{{ Str::limit($user_niche->special_note, 20, '...') }}
                                                                        </p>
                                                                    </td>
                                                                    <td>
                                                                        <p>{{ $user_niche->status }}</p>
                                                                    </td>
                                                                    @if(auth()->user()->type == 'Admin' || auth()->user()->type == 'Moderator')
                                                                        <td>
                                                                            <a href="{{ route('admin.guest.request.approved', $user_niche->id) }}" class="tick"><i class="text-green fa fa-check" title=""></i></a>
                                                                            <a href="{{ route('admin.guest.request.rejected', $user_niche->id) }}" class="edit"><i class="text-green fa fa-close"></i></a>
                                                                            <a href="{{ route('admin.guest.delete.request', $user_niche->id) }}" class="delete"><i class="text-green fa fa-trash" title="Delete"></i></a>
                                                                        </td>
                                                                    @endif    
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            {{-- end niche --}}
                            <div class="tab-pane" id="about">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header social-header">
                                                <h5 class="f-w-600">
                                                    User Persnol Information<span class="pull-right"><i data-feather="more-vertical"></i></span>
                                                </h5>
                                            </div>
                                            <div class="card-body pt-3">
                                                <div class="row details-about">
                                                    <div class="col-sm-3">
                                                        <div class="your-details">
                                                            <h6 class="f-w-600">Name</h6>
                                                            <p>{{ $user->name }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="your-details your-details-xs">
                                                            <h6 class="f-w-600">Email</h6>
                                                            </h6>
                                                            <p>{{ $user->email }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="your-details">
                                                            <h6 class="f-w-600">Phone</h6>
                                                            <p>{{ $user->phone }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="your-details">
                                                            <h6 class="f-w-600">Gender</h6>
                                                            <p>{{ $user->gender }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row details-about">
                                                    <div class="col-sm-3">
                                                        <div class="your-details">
                                                            <h6 class="f-w-600">Address</h6>
                                                            <p>{{ $user->address }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="your-details your-details-xs">
                                                            <h6 class="f-w-600">Country</h6>
                                                            </h6>
                                                            <p>{{ $user->country }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="your-details">
                                                            <h6 class="f-w-600">Province</h6>
                                                            <p>{{ $user->province }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="your-details">
                                                            <h6 class="f-w-600">Role</h6>
                                                            <p>{{ $user->type }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row details-about">
                                                    <div class="col-sm-3">
                                                        <div class="your-details">
                                                            <h6 class="f-w-600">City</h6>
                                                            <p>{{ $user->city }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="your-details your-details-xs">
                                                            <h6 class="f-w-600">Pending Requests</h6>
                                                            </h6>
                                                            <p>{{ $user->user_request()->where('status', 'pending')->count() }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="your-details">
                                                            <h6 class="f-w-600">Approved Requests</h6>
                                                            <p>{{ $user->user_request()->where('status', 'approved')->count() }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="your-details">
                                                            <h6 class="f-w-600">Rejected Requests</h6>
                                                            <p>{{ $user->user_request()->where('status', 'rejected')->count() }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row details-about">
                                                    <div class="col-sm-12">
                                                        <div class="your-details">
                                                            <h6 class="f-w-600">About</h6>
                                                            <p>{{ $user->about }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.tab-pane -->

                            <div class="tab-pane" id="update-profile">
                                <form class="theme-form" action="{{ route('user.update.profile') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" value="{{ $user->id }}" name="user_id">
                                    <div class="form-icon"><i class="icofont icofont-envelope-open"></i></div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="firstname">Name</label>
                                                <input class="form-control" id="firstname" type="text" placeholder="Name" name="name" value="{{ $user->name }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="email">Email</label>
                                                <input class="form-control" id="email" name="email" type="email" placeholder="Email@gmail.com" value="{{ $user->email }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="imageupload">Profile Image</label>
                                                <input class="form-control form-control-image" id="imageupload" type="file" name="profile">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="imageupload">cover Image</label>
                                                <input class="form-control form-control-image" id="imageupload" type="file" name="cover">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="address">Address</label>
                                                <input class="form-control" id="address" type="text" placeholder="Address" name="address" value="{{ $user->address }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="gender">Gender</label>
                                                <select name="gender" id="gender" class="dropdown-toggle form-control" type="button" data-toggle="dropdown">
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                    <option value="others">Others</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="mobilenumber">Mobile Number</label>
                                                <input class="form-control" id="mobilenumber" type="text" onkeypress="return onlyNumberKey(event)" placeholder="Enter Number" name="mobile" value="{{ $user->phone }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="country">Country</label>
                                                <select name="country" id="country" class="dropdown-toggle form-control" type="button" data-toggle="dropdown">
                                                    <option value="Pakistan">Pakistan</option>
                                                    <option value="India">India</option>
                                                    <option value="France">France</option>
                                                    <option value="Indonatia">Indonatia</option>
                                                    <option value="Affrica">Affrica</option>
                                                    <option value="Canda">Canda</option>
                                                    <option value="Turkey">Turkey</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="city">City</label>
                                                <input type="text" name="city" style="width:100%"  class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="stateprovince">State/Province</label>
                                                <input class="form-control" id="stateprovince" type="text" name="province" placeholder="State/Province" value="{{ $user->province }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="postalzip">Postal/Zip Code</label>
                                                <input class="form-control" id="postalzip" type="text" placeholder="Postal/Zip Code" value="{{ $user->postal }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="col-form-label" for="aboutme">About Me</label>
                                        <textarea class="form-control textarea" name="about" id="aboutme" rows="3" cols="50" placeholder="Your Message">{{ auth()->user()->about }}</textarea>
                                    </div>
                                    <div class="text-sm-end text-center">
                                        <button class="btn text-white bg-lightblack text-centergi">Update</button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="permissions">

                                <style>
                                    .switch_box{
                                    display: -webkit-box;
                                    display: -ms-flexbox;
                                    display: flex;
                                    max-width: 100%;
                                    min-width: 100%;
                                    -webkit-box-pack: center;
                                        -ms-flex-pack: center;
                                            justify-content: center;
                                    -webkit-box-align: center;
                                        -ms-flex-align: center;
                                            align-items: center;
                                    -webkit-box-flex: 1;
                                        -ms-flex: 1;
                                            flex: 1;
                                    }
                                    /* Switch 1 Specific Styles Start */
                                    input[type="checkbox"].switch_1 {
                                        font-size: 30px;
                                        -webkit-appearance: none;
                                        -moz-appearance: none;
                                        appearance: none;
                                        width: 2em;
                                        height: 1em;
                                        background: #ddd;
                                        border-radius: 3em;
                                        position: relative;
                                        cursor: pointer;
                                        outline: none;
                                        -webkit-transition: all .2s ease-in-out;
                                        transition: all .2s ease-in-out;
                                    }

                                    input[type="checkbox"].switch_1:checked{
                                    background: #343a40;
                                    }

                                    input[type="checkbox"].switch_1:checked:after {
                                        left: calc(100% - 1em);
                                    }
                                    input[type="checkbox"].switch_1:after {
                                        position: absolute;
                                        content: "";
                                        width: 1em;
                                        height: 1em;
                                        border-radius: 50%;
                                        background: #fff;
                                        -webkit-box-shadow: 0 0 0.25em rgb(0 0 0 / 30%);
                                        box-shadow: 0 0 0.25em rgb(0 0 0 / 33%);
                                        -webkit-transform: scale(.7);
                                        transform: scale(0.9);
                                        left: 0;
                                        -webkit-transition: all .2s ease-in-out;
                                        transition: all .2s ease-in-out;
                                    }
                                </style>
                                <div class="card">
                                    <form action="{{ route('admin.user.permissions', $user->id) }}" method="post">
                                        @csrf
                                        <div class="card-header bg-dark">Access to user Information</div>
                                        <div class="card-body">
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <div class="wrapper">
                                                        <div class="switch_box box_1">
                                                            <label for="addfund" class="pr-3">User Info</label>
                                                          <input type="checkbox" class="switch_1" id="user_info" name="user_info" value="1" data-style="slow" data-on="Allow" data-off="Deny" data-onstyle="dark" @if ($user->user_info == 'on') checked @endif >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-header bg-dark">Casino Post</div>
                                        <div class="card-body">
                                            <div class="form-row ">
                                                <div class="wrapper col-md-4">
                                                    <div class="switch_box box_1">
                                                        <label for="addfund" class="pr-3">Add Websites</label>
                                                      <input type="checkbox" class="switch_1" id="guest_info" name="add_casino_post" value="1" data-style="slow" data-on="Allow" data-off="Deny" data-onstyle="dark" @if ($user->add_casino_post == 'on') checked @endif >
                                                    </div>
                                                </div>
                                                <div class="wrapper col-md-4">
                                                    <div class="switch_box box_1">
                                                        <label for="addfund" class="pr-3">View Websites</label>
                                                      <input type="checkbox" class="switch_1" id="view_casino_info" name="view_all_casino_post" value="1" data-style="slow" data-on="Allow" data-off="Deny" data-onstyle="dark" @if ($user->view_all_casino_post == 'on') checked @endif>
                                                    </div>
                                                </div>
                                                <div class="modal" id="casinoModel" tabindex="-1" data-backdrop="false" aria-labelledby="exampleModalLabel1" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                      <div class="modal-content">
                                                        <div class="modal-header  bg-green">
                                                          <h5 class="modal-title" id="exampleModalLabel1">Change Permissions Setting</h5>
                                                          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                          </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group row">
                                                                @csrf
                                                                @foreach ($permissionCasino as $permissions)
                                                                    <div class="wrapper col-md-6 mb-3">
                                                                        <div class="switch_box box_1 row">
                                                                            <label for="input-{{$permissions->id}}" class="col-md-8">{{$permissions->name}}</label>
                                                                        <input type="checkbox" class="switch_1 col-md-3" id="input-{{$permissions->id}}" name="ids[]" value="{{$permissions->id}}" data-style="slow" data-on="Allow" data-off="Deny" data-onstyle="dark" @if (in_array($permissions->id, $user_permissions)) checked @endif>
                                                                        {{-- @if ($user->add_guest_post == 'on') checked @endif --}}
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancle</button>
                                                                <input type="submit" value="Save" class="btn bg-lightblack text-white mybutton">
                                                            </div>
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                <div class="wrapper col-md-4">
                                                    <div class="switch_box box_1">
                                                        <label for="addfund" class="pr-3">View Deleted Websites</label>
                                                      <input type="checkbox" class="switch_1" id="deleted_info" name="view_deleted_casino_post" value="1" data-style="slow" data-on="Allow" data-off="Deny" data-onstyle="dark" @if ($user->view_deleted_casino_post == 'on') checked @endif>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-header bg-dark">Guest Post</div>
                                        <div class="card-body">
                                            <div class="form-row ">
                                                <div class="wrapper col-md-4">
                                                    <div class="switch_box box_1">
                                                        <label for="addfund" class="pr-3">Add Websites</label>
                                                      <input type="checkbox" class="switch_1" id="guest_info" name="add_guest_post" value="1" data-style="slow" data-on="Allow" data-off="Deny" data-onstyle="dark" @if ($user->add_guest_post == 'on') checked @endif >
                                                    </div>
                                                </div>
                                                <div class="wrapper col-md-4">
                                                    <div class="switch_box box_1">
                                                        <label for="addfund" class="pr-3">View Websites</label>
                                                      <input type="checkbox" class="switch_1" id="view_Guest_info" name="view_all_guest_post" value="1" data-style="slow" data-on="Allow" data-off="Deny" data-onstyle="dark" @if ($user->view_all_guest_post == 'on') checked @endif>
                                                    </div>
                                                </div>
                                                <div class="modal" id="newPriceModel" tabindex="-1" data-backdrop="false" aria-labelledby="exampleModalLabel1" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                      <div class="modal-content">
                                                        <div class="modal-header  bg-green">
                                                          <h5 class="modal-title" id="exampleModalLabel1">Change Permissions Setting</h5>
                                                          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                          </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group row">
                                                                @csrf
                                                                @foreach ($permission as $permission)
                                                                    <div class="wrapper col-md-6 mb-3">
                                                                        <div class="switch_box box_1 row">
                                                                            <label for="input-{{$permission->id}}" class="col-md-8">{{$permission->name}}</label>
                                                                        <input type="checkbox" class="switch_1 col-md-3" id="input-{{$permission->id}}" name="ids[]" value="{{$permission->id}}" data-style="slow" data-on="Allow" data-off="Deny" data-onstyle="dark" @if (in_array($permission->id, $user_permissions)) checked @endif>
                                                                        {{-- @if ($user->add_guest_post == 'on') checked @endif --}}
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancle</button>
                                                                <input type="submit" value="Save" class="btn bg-lightblack text-white mybutton">
                                                            </div>
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                <div class="wrapper col-md-4">
                                                    <div class="switch_box box_1">
                                                        <label for="addfund" class="pr-3">View Deleted Websites</label>
                                                      <input type="checkbox" class="switch_1" id="deleted_info" name="view_deleted_guest_post" value="1" data-style="slow" data-on="Allow" data-off="Deny" data-onstyle="dark" @if ($user->view_deleted_guest_post == 'on') checked @endif>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-header bg-dark">Niche Permission</div>
                                        <div class="card-body p-4">
                                            <div class="form-row">
                                                <div class="wrapper col-md-4">
                                                    <div class="switch_box box_1">
                                                        <label for="addfund" class="pr-3">Add Websites</label>
                                                      <input type="checkbox" class="switch_1" id="niche_info" name="add_niche" data-style="slow" value="1" data-on="Allow" data-off="Deny" data-onstyle="dark" @if ($user->add_niche == 'on') checked @endif>
                                                    </div>
                                                </div>
                                                <div class="wrapper col-md-4">
                                                    <div class="switch_box box_1">
                                                        <label for="addfund" class="pr-3">View Websites</label>
                                                        <input type="checkbox"  class="switch_1" id="view_niche_info" name="view_niches" data-style="slow"  value="1" data-on="Allow" data-off="Deny" data-onstyle="dark" @if ($user->view_niches == 'on') checked @endif>
                                                    </div>
                                                </div>
                                                <div class="modal" id="nichePriceModel" tabindex="-1" data-backdrop="false" aria-labelledby="exampleModalLabel1" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                      <div class="modal-content">
                                                        <div class="modal-header  bg-green">
                                                          <h5 class="modal-title" id="exampleModalLabel1">Change Permissions Setting</h5>
                                                          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                          </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group row">
                                                                @csrf
                                                                @foreach ($permissionNiche as $np)
                                                                    <div class="wrapper col-md-6 mb-3">
                                                                        <div class="switch_box box_1 row">
                                                                            <label for="input-{{$np->id}}" class="col-md-8">{{$np->name}}</label>
                                                                        <input type="checkbox" class="switch_1 col-md-3" id="input-{{$np->id}}" name="ids[]" value="{{$np->id}}" data-style="slow" data-on="Allow" data-off="Deny" data-onstyle="dark" @if (in_array($np->id, $user_permissions)) checked @endif>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancle</button>
                                                                <input type="submit" value="Save" class="btn bg-lightblack text-white mybutton">
                                                            </div>
                                                        </div>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div class="wrapper col-md-4">
                                                    <div class="switch_box box_1">
                                                        <label for="addfund" class="pr-3">View Deleted Websites</label>
                                                        <input type="checkbox" class="switch_1" id="del_niche_info" name="deleted_niches" data-style="slow" value="1" data-on="Allow" data-off="Deny" data-onstyle="dark" @if ($user->deleted_niches == 'on') checked @endif>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="card-header bg-dark">Categories</div>
                                        <div class="card-body p-4">
                                            <div class="form-row">
                                                <div class="wrapper col-md-4">
                                                    <div class="switch_box box_1">
                                                        <label for="addfund" class="pr-3">Add Category</label>
                                                        <input type="checkbox" class="switch_1" id="category_info" name="add_category" data-style="slow" data-on="Allow" value="1" data-off="Deny" data-onstyle="dark" @if ($user->add_category == 'on') checked @endif>
                                                    </div>
                                                </div>
                                                <div class="wrapper col-md-4">
                                                    <div class="switch_box box_1">
                                                        <label for="addfund" class="pr-3">View Categories</label>
                                                    <input type="checkbox" class="switch_1" id="view_categorie_info" name="view_all_categories" data-style="slow" value="1" data-on="Allow" data-off="Deny" data-onstyle="dark" @if ($user->view_all_categories == 'on') checked @endif>
                                                </div>
                                                </div>
                                            </div>
                                        </div>

                                </div>
                                        <div class="d-flex justify-content-center mt-3">
                                            <button type="submit" class="btn text-white bg-lightblack px-4 px-5 text-center">Update</button>
                                        </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    $( document ).ready(function() {
        $('#view_Guest_info').click(function(){
            if($(this).is(":checked")){
                $("#newPriceModel").modal('show');
            }
            else {
                $("#newPriceModel").modal('hide');
            }
        });

        $('#view_niche_info').click(function(){
            if($(this).is(":checked")){
                $("#nichePriceModel").modal('show');
            }
            else {
                $("#nichePriceModel").modal('hide');
            }
        });

        $('#view_casino_info').click(function(){
            if($(this).is(":checked")){
                $("#casinoModel").modal('show');
            }
            else {
                $("#casinoModel").modal('hide');
            }
        });

    });
</script>
