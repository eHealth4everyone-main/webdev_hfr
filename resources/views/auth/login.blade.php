<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>HFR | Nigeria</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset("dist/css/bootstrap.min.css")}}" >
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset("dist/css/font-awesome/css/font-awesome.min.css")}}" >
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset("dist/css/ionicons/css/ionicons.min.css")}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset("dist/css/AdminLTE.min.css")}}">
  
  
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  </head>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div>
        <img class="img-responsive center-block" src="/img/logo.png" title="Nigeria Health Facility Registry" />
      </div>
      <div class="login-logo">
        <span class="text-center"><h3>Nigeria Health Facility Registry</h3></span>
      </div>
      <!-- /.login-logo -->
      <div class="panel">
        

        <div class="panel-body">
               <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                @csrf

                <div>
                    <p class="login-box-msg"><strong>Sign in to continue</strong></p>
                </div>
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>
                    </div>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            {{ $errors->first('email') }}
                        </span>
                     @endif
                </div>
                         
                <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                        <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
                    </div>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            {{ $errors->first('password') }}
                        </span>
                     @endif
                </div>
                <div class="row">
                  <div class="col-xs-8"></div>
                  <!-- /.col -->
                  <div class="col-xs-4">
                    <button type="submit" class="btn btn-success btn-block">Sign In</button>
                  </div>
                  <!-- /.col -->
                </div>

                <div class="form-group">
                    <a href="#">I forgot my password</a><br>
                </div>
              </form>
        </div>
       
        
        
        
        
      </div>
      <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->
    
    <!-- jQuery 3 -->
    <script src="{{ asset("dist/js/jquery.min.js")}}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset("dist/js/bootstrap.min.js")}}"></script>
    
    <script>
      
    </script>
  </body>
  </html>
  