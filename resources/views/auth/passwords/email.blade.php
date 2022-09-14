{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('fonts/icomoon/style.css')}}">

    <link rel="stylesheet" href="{{asset('login_css/owl.carousel.min.css')}}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('login_css/bootstrap.min.css')}}">
    
    <!-- Style -->
    <link rel="stylesheet" href="{{asset('login_css/style.css')}}">

    <style>
      @media (max-width:768px){
        div#img-box {
          display: none;
        }
      }
    </style>

    <title>Reset Password</title>
  </head>
  <body>
  

  <div class="d-lg-flex half">
    <div class="bg order-1 order-md-2" id="img-box" style="background-image: url('../images/img1.jpg');"></div>
    <div class="contents order-2 order-md-1">

      <div class="container">
        <div class="row align-items-center justify-content-center">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
          <div class="col-md-9">
            <h3>Reset Password to <strong style="color: #fb771a;">Outreach Freaks</strong> Account</h3>
            <p class="mb-4">Welcome back! Reset Password to your account.</p>
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
              <div class="form-group first">
                <label for="username">Email Address</label>
                <input type="text" class="form-control {{ $errors->has('password') ? 'has-error' : '' }}" placeholder="your-email@gmail.com" id="username" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                  @if($errors->any())
                    <div id="error-box"><!-- Display errors here --></div>
                  @endif 
              </div>
              
              <input type="submit" value="Send Password Reset Link" class="btn btn-block btn-primary">
            </form>
          </div>
        </div>
      </div>
    </div>  
  </div>

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  @if (Session::has('error'))
      @if(config('sweetalert.animation.enable'))
          <link rel="stylesheet" href="{{ config('sweetalert.animatecss') }}">
      @endif
      @if (config('sweetalert.alwaysLoadJS') === false && config('sweetalert.neverLoadJS') === false)
          <script src="{{ $cdn ?? asset('vendor/sweetalert/sweetalert.all.js')  }}"></script>
      @endif
      <script>
          Swal.fire("{!! Session::pull('error') !!}");
      </script>
  @endif
  </body>
</html>