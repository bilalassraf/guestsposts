<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Login</title>
  </head>
  <style>
.text-green{
    color:#242939;
}
.text-lightblack
{
  color: #242939 !important;
}
.text-white{
  color: #fff;
}
.bg-green{
    background-color: #242939 !important;
}
.login {
  min-height: 100vh;
}

.bg-image {
  background-image: url('{{ asset('images/login-image.png') }}');
  background-size: cover;
  background-position: center;
}

.login-heading {
  font-weight: 300;
}

.btn-login {
  font-size: 0.9rem;
  letter-spacing: 0.05rem;
  padding: 0.75rem 1rem;
}
.login-form h6 {
    font-size: 14px;
    margin-bottom: 25px;
    color: #999;
}
.login-form .form-group label {
    font-weight: 600;
    text-transform: capitalize;
    margin-bottom: 5px;
}
@font-face {
  font-family: 'Material Icons';
  font-style: normal;
  font-weight: 400;
  src: url(https://example.com/MaterialIcons-Regular.eot); /* For IE6-8 */
  src: local('Material Icons'),
    local('MaterialIcons-Regular'),
    url(https://example.com/MaterialIcons-Regular.woff2) format('woff2'),
    url(https://example.com/MaterialIcons-Regular.woff) format('woff'),
    url(https://example.com/MaterialIcons-Regular.ttf) format('truetype');
}
.material-icons {
  font-family: 'Material Icons';
  font-weight: normal;
  font-style: normal;
  font-size: 24px;  /* Preferred icon size */
  display: inline-block;
  line-height: 1;
  text-transform: none;
  letter-spacing: normal;
  word-wrap: normal;
  white-space: nowrap;
  direction: ltr;

  /* Support for all WebKit browsers. */
  -webkit-font-smoothing: antialiased;
  /* Support for Safari and Chrome. */
  text-rendering: optimizeLegibility;

  /* Support for Firefox. */
  -moz-osx-font-smoothing: grayscale;

  /* Support for IE. */
  font-feature-settings: 'liga';
}
.text-lightblack
{
  color: #242939 !important;
}
.bg-lightblack
{
    background-color: #242939 !important;
}
.text-white{
    color: #fff;
}


/*input[type=text]:focus {
  border: 3px solid #555 !important;
}*/
  </style>
  <body>
    <div class="container-fluid ps-md-0">
        <div class="row g-0">
          <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"></div>
          <div class="col-md-8 col-lg-6">
            <div class="login d-flex align-items-center py-5">
              <div class="container">
                <div class="row">
                  <div class="col-md-9 col-lg-8 mx-auto">
                    <!-- Sign In Form -->
                    <div class="card">
                        <div class="card-body">
                          <form class="theme-form login-form" method="POST" action="{{ route('login') }}">
                            @csrf
                            
                                <h2>Login</h2>
                                <h6>Welcome back! Log in to your account.</h6>
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="material-icons text-lightblack">email</i></span>
                                        <input class="form-control form-material floating {{ $errors->has('password') ? 'has-error' : '' }}" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        @if($errors->any())
                                        <div id="error-box">
                                            <!-- Display errors here -->
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="material-icons text-lightblack">lock</i></span>
                                        <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" required="" placeholder="*********" />
                                        @error('password')
                                        <span class="invalid-feedback" style="disply:block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <p>Don't have account?<a class="ms-2 text-green" href="{{ route('register') }}">Create Account</a></p>
                                    {{-- <a class="link" href="{{ route('password.request') }}">Forgot password?</a> --}}
                                </div>
                                <div class="form-group"><button class="btn bg-lightblack text-white btn-block"  type="submit">Sign in</button></div>
                                <div class="login-social-title">
                                </div>
                            </form>
                        </div>
                      </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
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
