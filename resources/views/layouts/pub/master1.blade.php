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
        
		<!-- Modernizr JS
		============================================ -->		
       
        @yield("kibiti_css")
     
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        
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
                                    <span>FEDERAL MINISTRY OF HEALTH</span>
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
                                        {{-- <a href=""><img src="/img/logo.png"  width="50" height="50" alt="FMOH"></a> --}}
                                       
                                        <h3> NIGERIA HFR</h3>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="mainmenu-area pull-right">
                                        <div class="mainmenu hidden-sm hidden-xs">
                                            <nav>
                                                <ul id="nav">
                                                    <li class="current"><a href="{{route('home')}}">Home</a>
                                                    </li>
                                                    
                                                    <li><a href="">Statistics</a>
                                                        <ul class="sub-menu">
                                                            <li><a href="{{route('statistics')}}">Tables</a></li>
                                                            <li><a href="{{route('statistics_charts')}}">Charts</a></li>
                                                     
                                                        </ul>
                                                    </li>
                                                    <li><a href="{{route('listhosp')}}">Facilities List</a> </li>
                                                    <li><a href="{{route('downloadfm')}}">Data Downloads</a> </li>
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
                                                <form id="search-form" action="#">
                                                    <input type="search" placeholder="Search here..." name="search" />
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
           
                <!--Text Area Start-->
                <div class="text-area pt-110 pb-100">
                    <div class="container">
                        @yield("content")
                    </div>
                </div>
                <!--End of Text Area-->
              
                <!--Footer Widget Area Start-->
                <div class="footer-widget-area">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-3 col-sm-4">
                                <div class="single-footer-widget">
                                    <div class="footer-logo">
                                        <a href="index.html"><img src="img/logo/footer.png" alt=""></a>
                                    </div>
                                    <p>NIgeria HFR </p>
                                  
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-4">
                                <div class="single-footer-widget">
                                    <h3>GET IN TOUCH</h3>
                                    <a href="tel:555-555-1212"><i class="fa fa-phone"></i>555-555-1212</a>
                                    <span><i class="fa fa-envelope"></i>info@example.com</span>
                                    <span><i class="fa fa-globe"></i>www.educat.com</span>
                                    <span><i class="fa fa-map-marker"></i>ur address goes here,street.</span>
                                </div>
                            </div>
                            <div class="col-md-3 hidden-sm">
                                <div class="single-footer-widget">
                                    <h3>Useful Links</h3>
                                    <ul class="footer-list">
                                        <li><a href="#">f</a></li>
                                        
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-4">
                                <div class="single-footer-widget">
                                    <h3>PARTNERS</h3>
                                    <div class="instagram-image">
                                      
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End of Footer Widget Area-->
                <!--Footer Area Start-->
                <footer class="footer-area">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 col-sm-7">
                                <span>Copyright &copy; FMOH 2018. All right reserved </span>
                            </div>
                            
                        </div>
                    </div>
                </footer>
                <!--End of Footer Area-->
            </div>   
            <!--End of Bg White--> 
        </div>    
        <!--End of Main Wrapper Area--> 
        
        <!-- Color Switcher -->
        <div class="ec-colorswitcher">
            <a class="ec-handle" href="#"><i class="zmdi zmdi-settings"></i></a>
            <h3>Style Switcher</h3>
            <div class="ec-switcherarea">
                <h6>Select Layout</h6>
                <div class="layout-btn">
                    <a href="#" class="ec-boxed"><span>Boxed</span></a>
                    <a href="#" class="ec-wide"><span>Wide</span></a>
                </div>
                <h6>Chose Color</h6>
                <ul class="ec-switcher">
                    <li><a href="#" class="cs-color-1 styleswitch" data-rel="color-one"></a></li>
                    <li><a href="#" class="cs-color-2 styleswitch" data-rel="color-two"></a></li>
                    <li><a href="#" class="cs-color-3 styleswitch" data-rel="color-three"></a></li>
                    <li><a href="#" class="cs-color-4 styleswitch" data-rel="color-four"></a></li>
                    <li><a href="#" class="cs-color-5 styleswitch" data-rel="color-five"></a></li>
                    <li><a href="#" class="cs-color-6 styleswitch" data-rel="color-six"></a></li>
                    <li><a href="#" class="cs-color-7 styleswitch" data-rel="color-seven"></a></li>
                    <li><a href="#" class="cs-color-8 styleswitch" data-rel="color-eight"></a></li>
                    <li><a href="#" class="cs-color-9 styleswitch" data-rel="color-nine"></a></li>
                    <li><a href="#" class="cs-color-10 styleswitch" data-rel="color-ten"></a></li>
                </ul>
                <div class="ec-pattren">
                    <h6>Chose Pattren</h6>
                    <div class="pattren-wrap">
                        <a href="#" data-rel="pattren1" class="styleswitch"><img src="img/ec-pattren/pattren1.jpg" alt=""></a>
                        <a href="#" data-rel="pattren2" class="styleswitch"><img src="img/ec-pattren/pattren2.jpg" alt=""></a>
                        <a href="#" data-rel="pattren3" class="styleswitch"><img src="img/ec-pattren/pattren3.jpg" alt=""></a>
                        <a href="#" data-rel="pattren4" class="styleswitch"><img src="img/ec-pattren/pattren4.jpg" alt=""></a>
                        <a href="#" data-rel="pattren5" class="styleswitch"><img src="img/ec-pattren/pattren5.jpg" alt=""></a>
                    </div>
                </div>
                <div class="ec-background">
                    <h6>Chose Background</h6>
                    <div class="background-wrap">
                        <a href="#" data-rel="background1" class="styleswitch"><img src="img/ec-background/bg-1.jpg" alt=""></a>
                        <a href="#" data-rel="background2" class="styleswitch"><img src="img/ec-background/bg-2.jpg" alt=""></a>
                        <a href="#" data-rel="background3" class="styleswitch"><img src="img/ec-background/bg-3.jpg" alt=""></a>
                        <a href="#" data-rel="background4" class="styleswitch"><img src="img/ec-background/bg-4.jpg" alt=""></a>
                        <a href="#" data-rel="background5" class="styleswitch"><img src="img/ec-background/bg-5.jpg" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Color Switcher end -->	
        
        
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

        @stack("kibiti_scripts")
    </body>

</html>