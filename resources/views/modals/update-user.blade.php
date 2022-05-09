<!-- Edit Modal HTML -->

@foreach ($users as $user)
<div id="editUserModal-{{ $user->id }}" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Update Info</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
                    <form class="theme-form login-form" method="post" action="{{route('update.user',$user->id)}}">
                        @csrf
                            @if ($user->email != 'adjhunt@gmail.com')
                                <div class="form-group">
                                    <label>Role</label>
                                    <div class="small-group">
                                        <div class="input-group">
                                            <span class="input-group-text text-green"><i class="fa fa-user"></i></span>
                                            <select class="form-control" placeholder="Enter Your Name" name="type">
                                                <option value="admin">Admin</option>
                                                <option value="user">User</option>
                                                <option value="moderator">Moderator</option>
                                                <option value="outreach_coordinator">Outreach Coordinator</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <input type="hidden" name="type" value="admin">
                            @endif
	                        <div class="form-group">
	                            <label>Your Name</label>
	                            <div class="small-group">
	                                <div class="input-group">
	                                    <span class="input-group-text"><i class="material-icons text-green">account_circle</i></span>
	                                    <input class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name',$user->name) }}" required   placeholder="Enter Your Name" />
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
	                                </div>
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <label>Email Address</label>
	                            <div class="input-group">
	                                <span class="input-group-text"><i class="material-icons text-green">email</i></span>
	                                <input class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email',$user->email) }}" required autocomplete="email" placeholder="Test@gmail.com" />
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>
	                        </div>
							<div class="form-group">
								<label>New Password</label>
								<div class="input-group">
									<span class="input-group-text"><i class="fa fa-lock text-green"></i></span>
									<input class="form-control @error('password') is-invalid @enderror" name="password"  type="password" placeholder="********" />
										@error('password')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
										@enderror
								</div>
							</div>
							<div class="form-group">
								<label>Confirm Password</label>
								<div class="input-group">
									<span class="input-group-text"><i class="fa fa-lock text-green"></i></span>
									<input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation"  placeholder="**********" />
										@error('password_confirmation')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
										@enderror
								</div>
							</div>
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
					<input type="submit" class="btn bg-lightblack text-white" value="Update">
				</div>
			</form>
		</div>
	</div>
</div>
@endforeach
