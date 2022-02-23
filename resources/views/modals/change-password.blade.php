<!-- Edit Modal HTML -->

<div id="changePasswordModal-{{$user->id}}" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Update Info</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
                    <form class="theme-form login-form" method="post" action="{{route('admin.update.user.password',$user->id)}}">
                        @csrf
	                        <div class="form-group">
	                            <label>New Password</label>
	                            <div class="input-group">
	                                <span class="input-group-text"><i class="fa fa-lock text-green"></i></span>
	                                <input class="form-control @error('password') is-invalid @enderror" name="password" required type="password" placeholder="********" />
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
	                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required placeholder="**********" />
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
