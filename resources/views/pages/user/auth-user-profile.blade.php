@extends('layouts.default')
<style type="text/css">
.card-primary.card-outline {
    border-top: 3px solid #00695B !important;
}
button.btn.btn-primary.bg-green.text-centergi {
}
button.btn.btn-primary.bg-green.text-centergi {
    width: 26%;
    float: right;
}
</style>
<script>
    function onlyNumberKey(evt) {
          var ASCIICode = (evt.which) ? evt.which : evt.keyCode
          if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
              return false;
          return true;
      }
</script>
@section('user')
    <section class="content content-wrapper p-4">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img  rounded-circle" src="{{asset('public/'.$user->profile)}}"  height="100px" width="100px">
                </div>

                <h3 class="profile-username text-center">{{$user->name}}</h3>

                <p class="text-muted text-center">{{$user->email}}</p>
                <div class="text-center">
                </div>
                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b class="text-green">Approved Sites</b> <a class="float-right">{{$user->user_request()->where('status','approved')->count()}}</a>
                  </li>
                  <li class="list-group-item">
                    <b class="text-green">Pending Sites</b> <a class="float-right">{{$user->user_request()->where('status','pending')->count()}}</a>
                  </li>
                  <li class="list-group-item">
                    <b class="text-green">Total Sites</b> <a class="float-right">{{$user->user_request()->count()}}</a>
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
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#requests" data-toggle="tab">Site Requests</a></li>
                  <li class="nav-item"><a class="nav-link" href="#about" data-toggle="tab">About</a></li>
                  <li class="nav-item"><a class="nav-link" href="#update-profile" data-toggle="tab">Update Profile</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane active" id="requests">
                <div class="tab-pane fade show active" id="timeline" role="tabpanel" aria-labelledby="timeline">
                <div class="col-xl-12 recent-order-sec">
                <div class="card">
                  <div class="card-body">
                    <div class="table-responsive">
                      <h5>User Requests</h5>
                      <table class="table table-bordernone">
                        <thead>
                          <tr>
                            <th>#id</th>
                            <th>Website Name</th>
                            <th>Company Price</th>
                            <th>Description</th>
                            <th>Special Note</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>

                          @foreach ($request as $user_request)
                                <tr>
                                    <td>{{$user_request->id}}</td>
                                    <td><p>{{$user_request->web_name}}</p></td>
                                    <td><p>{{$user_request->company_price}}</p></td>
                                    <td><p>{{Str::limit($user_request->web_description,20,'...')}}</p></td>
                                    <td><p>{{Str::limit($user_request->special_note,20,'...')}}</p></td>
                                    <td><p>{{$user_request->status}}</p></td>
                                    <td>
                                        <a href="{{ route('admin.niche.approved' ,$user_request->id) }}" class="tick"><i class="text-green fa fa-check" title=""></i></a>
                                        <a href="{{ route('admin.niche.rejected' ,$user_request->id)}}" class="edit"><i class="text-green fa fa-close"></i></a>
                                        <a href="{{ route('admin.niche.deleted'  ,$user_request->id) }}" class="delete"><i class="text-green fa fa-trash" title="Delete"></i></a>
                                    </td>
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
                  <!-- /.tab-pane -->
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
	                                                    <h6 class="f-w-600">Email</h6></h6>
	                                                    <p>{{ $user->email}}</p>
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
	                                                    <h6 class="f-w-600">Country</h6></h6>
	                                                    <p>{{ $user->country}}</p>
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
	                                                    <h6 class="f-w-600">Pending Requests</h6></h6>
	                                                    <p>{{ $user->user_request()->where('status','pending')->count()}}</p>
	                                                </div>
	                                            </div>
                                                <div class="col-sm-3">
	                                                <div class="your-details">
	                                                    <h6 class="f-w-600">Approved Requests</h6>
	                                                    <p>{{ $user->user_request()->where('status','approved')->count()}}</p>
	                                                </div>
	                                            </div>
                                                <div class="col-sm-3">
	                                                <div class="your-details">
	                                                    <h6 class="f-w-600">Rejected Requests</h6>
	                                                    <p>{{ $user->user_request()->where('status','rejected')->count()}}</p>
	                                                </div>
	                                            </div>
	                                        </div>
                                            <div class="row details-about">
                                                <div class="col-sm-12">
	                                                <div class="your-details">
	                                                    <h6 class="f-w-600">About</h6>
	                                                    <p>{{ $user->about}}</p>
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
                    <form class="theme-form" action="{{route('user.update.profile')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                    <div class="form-icon"><i class="icofont icofont-envelope-open"></i></div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="firstname">Name</label>
                                                    <input class="form-control" id="firstname" type="text" placeholder="Name" name="name" value="{{auth()->user()->name}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="email">Email</label>
                                                    <input class="form-control" id="email" name="email" type="email" placeholder="Email@gmail.com" value="{{auth()->user()->email}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="imageupload">Profile Image</label>
                                                    <input class="form-control profile-image" id="imageupload" type="file" name="profile">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="imageupload">cover Image</label>
                                                    <input class="form-control cover-image" id="imageupload" type="file" name="cover">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="address">Address</label>
                                                    <input class="form-control" id="address" type="text" placeholder="Address" name="address" value="{{auth()->user()->address}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="gender">Gender</label>
                                                        <select name="gender"  id="gender" class="dropdown-toggle form-control" type="button" data-toggle="dropdown">
                                                            <option value="Male">Male</option>
                                                            <option value="Female">Female</option>
                                                            <option value="others">Others</option>
                                                        </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="mobilenumber">Mobile Number</label>
                                                    <input class="form-control" id="mobilenumber" type="text" onkeypress="return onlyNumberKey(event)" placeholder="Enter Number" name="mobile" value="{{auth()->user()->phone}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="country">Country</label>
                                                        <select name="country"  id="country" class="dropdown-toggle form-control" type="button" data-toggle="dropdown">
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
                                                        <select name="city"  id="city" class="dropdown-toggle form-control" type="button" data-toggle="dropdown">
                                                            <option value="1">Item 1</option>
                                                            <option value="2">Item 2</option>
                                                        </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="stateprovince">State/Province</label>
                                                    <input class="form-control" id="stateprovince" type="text" name="province" placeholder="State/Province" value="{{auth()->user()->province}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="postalzip">Postal/Zip Code</label>
                                                    <input class="form-control" id="postalzip" type="text" placeholder="Postal/Zip Code" value="{{auth()->user()->postal}}">
                                                </div>
                                            </div>
                                        </div>
                                    <div class="mb-3">
                                        <label class="col-form-label" for="aboutme">About Me</label>
                                        <textarea class="form-control textarea" name="about" id="aboutme" rows="3" cols="50" placeholder="Your Message">{{auth()->user()->about}}</textarea>
                                    </div>
                                    <div class="text-sm-end text-center">
                                        <button class="btn btn-primary bg-green text-centergi">Update</button>
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
