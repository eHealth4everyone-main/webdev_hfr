<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>HFR | Nigeria</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset("dist/css/font-awesome/css/font-awesome.min.css")}}" >
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset("dist/css/ionicons/css/ionicons.min.css")}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset("dist/css/AdminLTE.min.css")}}">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{ asset("dist/css/bootstrap-datepicker.min.css")}}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset("/dist/css/select2.min.css")}}">
    <!--data tables -->
    <link rel="stylesheet"   href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
    
    
    @yield("bk_css")
    <link rel="stylesheet" href="{{ asset("dist/css/skins/skin-green.min.css")}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
        <body class="hold-transition skin-green sidebar-mini">
            <!-- Site wrapper -->
            <div class="wrapper">
                
                <header class="main-header">
                    <!-- Logo -->
                    <a href="{{route('home')}}" class="logo">
                        <!-- mini logo for sidebar mini 50x50 pixels -->
                        <span class="logo-mini"><b>H</b>FR</span>
                        <!-- logo for regular state and mobile devices -->
                        <span class="logo-lg"><b>HFR </b>Administration</span>
                    </a>
                    <!-- Header Navbar: style can be found in header.less -->
                    <nav class="navbar navbar-static-top">
                        <!-- Sidebar toggle button-->
                        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </a>
                        
                        <div class="navbar-custom-menu">
                            <ul class="nav navbar-nav">
                                <!-- Messages: style can be found in dropdown.less-->
                                
                                
                                <!-- User Account: style can be found in dropdown.less -->
                                <li class="dropdown user user-menu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <img src="../../dist/img/boxed-bg.jpg" class="user-image" alt="User Image">
                                        <span class="hidden-xs"> {{Auth::user()->firstname .' '.Auth::user()->lastname}}</span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <!-- User image -->
                                        <li class="user-header">
                                            <img src="../../dist/img/boxed-bg.jpg" class="img-circle" alt="User Image">
                                            <p>
                                                {{Auth::user()->firstname .' '.Auth::user()->lastname}}
                                            </p>
                                            
                                        </li>
                                        <!-- Menu Body -->
                                        
                                        <!-- Menu Footer-->
                                        <li class="user-footer">
                                            <div class="pull-left">
                                                <a >
                                                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#user_profile">Profile</button>
                                                    
                                                </a>
                                            </div>
                                            <div class="pull-right">
                                                <a class="btn btn-default btn-flat" href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                                Sign out
                                            </a>
                                        </div>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                    
                                </ul>
                            </li>
                            <!-- Control Sidebar Toggle Button -->
                            
                        </ul>
                    </div>
                    
                </nav>
            </header>
            
            <!-- =============================================== -->
            
            @include('layouts.leftmenu')
            
            <!-- =============================================== -->
            
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        @yield("content-title")
                    </h1>
                    
                </section>
                
                <!-- Main content -->
                <section class="content">
                    @yield("content")
                    
                    @include('users.profile')
                </section>
                <!-- /.content -->
                
            </div>
            <!-- /.content-wrapper -->
            
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 2.4.0
                </div>
                <strong>Copyright &copy; 2017-2018 <a href="http://health.gov.ng/">MOH</a>.</strong> All rights
                reserved.
            </footer>           
            
        </div>
        <!-- ./wrapper -->
        
        <!-- jQuery 3 -->
        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset("dist/js/adminlte.min.js")}}"></script>
        <!-- bootstrap datepicker -->
        <script src="{{asset("dist/js/bootstrap-datepicker.min.js")}}"></script>
        <!-- SlimScroll -->
        <script src="{{asset("dist/js/select2.full.min.js")}}"></script>
        <!-- data tables -->
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="{{asset("dist/js/demo.js")}}"></script>
        <!-- FastClick -->
        <script src="{{ asset("dist/js/fastclick.js")}}"></script>
        
        
        
        <script>
            $(document).ready(function () {
                $('.sidebar-menu').tree()
            })
        </script>
        
        @stack("bk_script")
        
        <script>
            $(function () {
                //Initialize Select2 Elements
                $('.select2').select2()
                
                //Date picker
                $('#datepicker').datepicker({
                    autoclose: true
                })                                                   
            })
        </script>
    </body>
    </html>
    