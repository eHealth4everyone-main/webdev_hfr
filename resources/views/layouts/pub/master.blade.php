<!doctype html>
<html class="no-js" lang="en">
    
<head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Nigeria Health Facility Registry</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
        
		<!-- favicon
		============================================ -->		
        <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
		
		<!-- Google Fonts
		============================================ -->		
        <link href='https://fonts.googleapis.com/css?family=Raleway:400,300,500,600,700,800' rel='stylesheet' type='text/css'>
	   
		<!-- Bootstrap CSS
		============================================ -->		
        <link rel="stylesheet" href="{{asset("design/css/bootstrap.min.css")}}">
        
		<!-- Color Swithcer CSS
		============================================ -->
        <link rel="stylesheet" href="{{asset("design/css/color-switcher.css")}}">
        
		<!-- Fontawsome CSS
		============================================ -->
        <link rel="stylesheet" href="{{asset("design/css/font-awesome.min.css")}}">
        
		<!-- Owl Carousel CSS
		============================================ -->
        <link rel="stylesheet" href="{{asset("design/css/owl.carousel.css")}}">
        
		<!-- jquery-ui CSS
		============================================ -->
        <link rel="stylesheet" href="{{asset("design/css/jquery-ui.css")}}">
        
		<!-- Meanmenu CSS
		============================================ -->
        <link rel="stylesheet" href="{{asset("design/css/meanmenu.min.css")}}">
        
		<!-- Animate CSS
		============================================ -->
        <link rel="stylesheet" href="{{asset("design/css/animate.css")}}">
        
	        
		<!-- Metarial Iconic Font CSS
		============================================ -->
        <link rel="stylesheet" href="{{asset("design/css/material-design-iconic-font.css")}}">
        <link rel="stylesheet" href="{{asset("design/css/material-design-iconic-font.min.css")}}">
        
		<!-- Slick CSS
		============================================ -->
        <link rel="stylesheet" href="{{asset("design/css/slick.css")}}">
        
		<!-- Style CSS
		============================================ -->
        <link rel="stylesheet" href="{{asset("design/style.css")}}">
        
		<!-- Color CSS
		============================================ -->
        <link rel="stylesheet" href="{{asset("design/css/color.css")}}">
        
		<!-- Responsive CSS
		============================================ -->
        <link rel="stylesheet" href="{{asset("design/css/responsive.css")}}">
        <link rel="stylesheet" href="{{asset("/dist/css/select2.min.css")}}">
	
        @yield("custom_css")
     
    </head>
    <body>
     
        <!--Main Wrapper Start-->
        <div class="as-mainwrapper">
            <!--Bg White Start-->
            <div class="bg-white">
                <!--Header Area Start-->
                <header>
                    <div class="header-top bg-green effect-blue">
                        <div class="container">
                                <div class="row">
                                        <div class="col-lg-7 col-md-6 col-sm-5 hidden-xs">
                                            <a href=""><img src="/img/logo.png"  width="50" height="50" alt="FMOH"></a>
                                            <span>    &nbsp;&nbsp; FEDERAL MINISTRY OF HEALTH</span>
                                         
                                        </div>
                                        <div class="col-lg-5 col-md-6 col-sm-7 col-xs-12">
                                            <div class="header-top-right">
                                                    <div class="content"><a href="{{route('about')}}"> About</a></div>
                                                    <div class="content"><a href="{{route('open_contact_form')}}"> Contact Us</a></div>
                                                <div class="content"><a href="{{route('admin_home')}}"><i class="zmdi zmdi-account"></i> My Account</a>
                                
                                                </div>
                                               
                                            </div>
                                        </div>
                                </div>
                        </div>
                    </div>
                    <div class="header-logo-menu sticker">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-3 col-sm-12">
                                        <div class="logo">
                                                {{-- <a href=""><img src="/img/nigeriahfr.png"  width="" height="50" alt="FMOH"></a> --}}
                                                <h3 style="color:black">Nigeria</h3>
                                                <h5 style="color:DarkGreen"> Health Facility Registry (HFR)</h5>
                
                                        </div>
                                        
                                </div>
                                <div class="col-md-9">
                                    <div class="mainmenu-area pull-right">
                                        <div class="mainmenu hidden-sm hidden-xs">
                                            <nav>
                                                <ul id="nav">
                                                    <li class="current"><a href="{{route('home')}}">Home</a>
                                                    </li>
                                                    
                                                    <li><a >Statistics</a>
                                                        <ul class="sub-menu">
                                                            <li><a href="{{route('statistics')}}">Summary Tables</a></li>
                                                            <li><a href="{{route('statistics_charts')}}">Summary Charts</a></li>
                                                        <li><a href="{{route('population_index')}}">Population Index</a></li>
                                                        </ul>
                                                    </li>
                                                    <li><a href="{{route('listhosp')}}">Facilities List</a> </li>
                                                    <li><a href="{{route('openRegistrationForm')}}">Data Downloads</a> </li>
                                                    <li><a href="{{route('public_resources')}}">Resources</a></li>
                                      
                                                </ul>
                                            </nav>
                                        </div>
                                        <ul class="header-search">
                                            <li class="search-menu">
                                                <i id="toggle-search" class="zmdi zmdi-search-for"></i>
                                            </li>
                                        </ul>
                                        <!--Search Form-->
                                        <div class="search">
                                            <div class="search-form">
                                                <form id="search-form" action="{{route('searchHospitals')}}" method="GET">
                                                    <input type="search" placeholder="Search hospital and clinics..." name="facility_name" />
                                                    <button type="submit">
                                                        <span><i class="fa fa-search"></i></span>
                                                    </button>
                                                </form>                                
                                            </div>
                                        </div>
                                        <!--End of Search Form-->
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>  
                      
                </header>
                <!--End of Header Area-->
             <!--Breadcrumb Banner Area Start-->
                <div class="breadcrumb-banner-area">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                          
                            </div>
                        </div>
                    </div>
                </div>
                <!--End of Breadcrumb Banner Area-->
               
                   
                        @yield("content")
                    
                
                <!--End of Text Area-->
              
              
                <!--Footer Area Start-->
                <footer class="footer-area">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 col-sm-7">
                                <span>Copyright &copy; FMOH 2018. All Right Reserved </span>
                            </div>
                            <div class="col-md-4">
                                
                            </div>
                            <div class="col-md-2 col-sm-2">
                                    <span>Version 2.0 </span>
                            </div>
                            
                        </div>
                    </div>
                </footer>
                <!--End of Footer Area-->
            </div>   
            <!--End of Bg White--> 
        </div>    
        <!--End of Main Wrapper Area--> 
        
      
        
		<!-- jquery
		============================================ -->		
        <script src="{{asset("design/js/vendor/jquery-1.12.4.min.js")}}"></script>
        
		<!-- bootstrap JS
		============================================ -->		
        <script src="{{asset("design/js/bootstrap.min.js")}}"></script>
              
		<!-- meanmenu JS
		============================================ -->		
        <script src="{{asset("design/js/jquery.meanmenu.js")}}"></script>
		
		<!-- wow JS
		============================================ -->		
        <script src="{{asset("design/js/wow.min.js")}}"></script>
        
		<!-- owl.carousel JS
		============================================ -->		
        <script src="{{asset("design/js/owl.carousel.min.js")}}"></script>
        
		<!-- scrollUp JS
		============================================ -->		
        <script src="{{asset("design/js/jquery.scrollUp.min.js")}}"></script>
        
		<!-- Waypoints JS
		============================================ -->		
        <script src="{{asset("design/js/waypoints.min.js")}}"></script>
        
		<!-- Counterup JS
		============================================ -->		
        <script src="{{asset("design/js/jquery.counterup.min.js")}}"></script>
        
		<!-- Slick JS
		============================================ -->		
        <script src="{{asset("design/js/slick.min.js")}}"></script>
        
        
		<!-- Textilate JS
		============================================ -->		
        <script src="{{asset("design/js/textilate.js")}}"></script>
        
		<!-- Lettering JS
		============================================ -->		
        <script src="{{asset("design/js/lettering.js")}}"></script>
        
        
		<!-- Mail Chimp JS
		============================================ -->		
        <script src="{{asset("design/js/jquery.ajaxchimp.min.js")}}"></script>
        
		<!-- plugins JS
		============================================ -->		
        <script src="{{asset("design/js/plugins.js")}}"></script>
        
		<!-- StyleSwitch JS
		============================================ -->	
        <script src="{{asset("design/js/styleswitch.js")}}"></script>
        
	    <!-- main JS
		============================================ -->		
        <script src="{{asset("design/js/main.js")}}"></script>
        <script src="{{asset("dist/js/select2.full.min.js")}}"></script>

        <script>
    
            $('.select2').select2() 

        </script>

        @stack("custom_scripts")
    </body>

</html>