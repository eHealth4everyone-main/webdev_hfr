
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>HFR | Nigeria</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
  <link rel="stylesheet" href="{{ asset("dist/css/font-awesome/css/font-awesome.min.css")}}" >
  <link rel="stylesheet" href="{{ asset("dist/css/ionicons/css/ionicons.min.css")}}">
  <link rel="stylesheet" href="{{ asset("dist/css/AdminLTE.min.css")}}">
  <link rel="stylesheet" href="{{ asset("dist/css/bootstrap-datepicker.min.css")}}">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link rel="stylesheet" href="{{ asset("dist/css/skins/skin-green.min.css")}}">
  @yield("kibiti_css")
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-green layout-top-nav">
<div class="wrapper">

  <header class="main-header">
    
    <nav class="navbar navbar-static-top">
     
      <div class="container">
          <div class="row">
              <div class="col-md-2">
                  {{-- <img class="img-responsive center-block" src="/img/logo.png" title="Nigeria Health Facility Registry" /> --}}
                  {{-- <img class="img-responsive" src="/img/logo.png" class="img-circle" alt="FMOH Logo"> --}}
              </div>
              <div class="col-md-8">
                  <h2 class="text-center"><p> NIGERIA HEALTH FACILITY REGISTRY </p></h2>
                 
              </div>
              <div class="col-md-2"></div>
          </div>
     
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
            <ul class="nav navbar-nav">
              <li><a href="{{route('home')}}">Home</a></li>
              <li><a href="{{route('about')}}">About</a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Facility List <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="{{route('listhosp')}}">Hospitals</a></li>
                  <li><a href="{{route('listlab')}}">Laboratories</a></li>
                  <li><a href="{{route('listpharmacy')}}">Pharmaceuticals</a></li>
                  <li><a href="{{route('listradiology')}}">Radiology and Imaging</a></li>
                </ul>
              </li>
              <li><a href="#">Statistics</a></li>
              <li><a href="#">Facility Search</a></li>
            <li><a href="{{route('public_resources')}}">Resources</a></li>
              <li><a href="#">Contact us</a></li>
              <li><a href="{{route('admin_home')}}">Login</a></li>

            </ul>
         
      </div>

      
        </div>

    </nav>
 
 
  </header>
  <!-- Full Width Column -->
  <div class="box">
    <div class="container">
      <!-- Content Header (Page header) -->
      <section class="content-header">
         @yield("content-title")
      </section>

      <!-- Main content -->
      <section class="content">
      
          @yield("content")
          
      </section>
      <!-- /.content -->
    </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="container">
      <div class="pull-right hidden-xs">
        <b>Version</b> 2.0.0
      </div>
      <strong>Copyright &copy; 2017-2018 <a href="http://health.gov.ng/">MOH</a>.</strong> All rights
      reserved.
    </div>
    <!-- /.container -->
  </footer>
</div>
<!-- ./wrapper -->


<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="{{ asset("dist/js/adminlte.min.js")}}"></script>
<script src="{{asset("dist/js/select2.full.min.js")}}"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script src="{{asset("dist/js/demo.js")}}"></script>
<script src="{{ asset("dist/js/fastclick.js")}}"></script>
@stack("kibiti_scripts")

</body>

</html>
