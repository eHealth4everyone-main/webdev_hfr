
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
	<link rel="stylesheet" href="{{asset("styles/style-resp.css")}}" type="text/css" media="all" />

  @yield("kibiti_css")
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body >

        
    <div class="container"  id="container">
        <div class="header">
          <div class="coatofarmsdiv">
            <img title="Ministry of Health - Federal Republic Of Nigeria" class="" src="img/logo.png" width="90" height="76" />
          </div>
          <div class="headertext">
            NIGERIA HEALTH FACILITY REGISTRY
            <div class="subheadertext">... a project of the Federal Ministry of Health supported by the United States Agency for International Development</div>
          </div>
          <div class="usaiddiv">
            <img title="United States Agency International Development" class="" src="img/usaid.png"/>
          </div>
        </div>
        <div class="navigation">
            <nav role="navigation" class="navbar navbar-default">
              <div id="navbarCollapse" class="collapse navbar-collapse">
                  <ul class="nav navbar-nav navbar-default">
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
            </nav>
          </div>
      
        {{-- <div class="collapse navbar-collapse pull-right" id="navbar-collapse">
          
         
        </div>	 --}}
      </div>
     	

 
 

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

<!-- ./wrapper -->


<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="{{ asset("dist/js/adminlte.min.js")}}"></script>
<script src="{{asset("dist/js/select2.full.min.js")}}"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script src="{{asset("dist/js/demo.js")}}"></script>
@stack("kibiti_scripts")

</body>

</html>
