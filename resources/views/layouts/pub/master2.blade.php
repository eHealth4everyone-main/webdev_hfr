<!doctype html>
<html class="no-js" lang="en">
    
<head>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-130161904-1"></script>
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-130161904-1');
        </script>

        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Nigeria Health Facility Registry</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
        
		<!-- favicon
		============================================ -->		
        <link rel="shortcut icon" type="image/x-icon" href="{{asset("favicon.ico")}}">
		
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
                                            {{-- <a href=""><img src="/img/logo.png"  width="50" height="50" alt="FMOH"></a> --}}
                                            <span><h4> NIGERIA Health Facility Registry (HFR)</h4></span>
                                        </div>
                                        <div class="col-lg-5 col-md-6 col-sm-7 col-xs-12">
                                            <div class="header-top-right">
                                                    <div class="content"><a href="{{route('about')}}"> About</a></div>
                                                    <div class="content"><a href="{{route('open_contact_form')}}"> Contact Us</a></div>
                                                <div class="content"><a href="/login"><i class="zmdi zmdi-account"></i> My Account</a>
                                
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
                                                <a href="{{route('home')}}"> 
                                                    <img src="{{asset('img/new_logo.png')}}"  alt="FMOH">
                                                </a>               
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
                           <!--Footer Widget Area Start-->
                           <div class="footer-widget-area">
                                <div class="container">
                                    <div class="row">
                                  
                                        <div class="col-md-8">
                                            <div class="single-footer-widget">
                                                <h3>Nigeria HFR PARTNERS</h3>
                                                <div class="instagram-image">
                                                       
                                                        <div class="footer-img">
                                                            <img src="{{asset('img/nigeria_logo.jpg')}}" height="70" width="70" alt="FMOH">
                                                        </div>
                                                        <div class="footer-img">
                                                                <img src="{{asset('img/usaid.png')}}" height="70" width="70" alt="USAID">
                                                        </div>
                                                        <div class="footer-img">
                                                                <img src="{{asset('img/measure.jpg')}}" height="70" width="70" alt="MEASURE Evaluation">
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 hidden-sm">
                                                <div class="single-footer-widget">
                                                    <h3>Useful Links</h3>
                                                    <ul class="footer-list">
                                                        <li><a target="_blank" rel="noopener noreferrer" href="http://health.gov.ng/">Federal Ministry of Health</a></li>
                                                        <li><a target="_blank" rel="noopener noreferrer" href="http://nphcda.gov.ng"> NPHCDA</a></li>
                                                        <li><a target="_blank" rel="noopener noreferrer" href="https://dhis2nigeria.org.ng">Nigeria DHIS2</a></li>
                                                        
                                                    </ul>
                                                </div>
                                        </div>

                                    </div>
                                </div>
                        </div>
              
                <!--Footer Area Start-->
                <footer class="footer-area">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 col-sm-7">
                                <span>Copyright &copy; 2018 <a href="http://health.gov.ng/">Federal Ministry of Health</a>. All Right Reserved </span>
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
        

<!-- Show facility details on view click public facility list -->
<div class="modal fade" id="view_details" tabindex="-1" role="dialog">
        <div class="modal-dialog " role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Facility Details</h4>
              <div class='notifications top-right'></div>
            </div>
            <div class="modal-body">
              
                <div class="panel-body">
                   
                        <div class="panel-group" id="accordion">
                          {{-- panel one --}}
                          <div class="panel panel-default">
                            <div class="panel-heading">
                              <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Identity</a>
                              </h4>
                            </div>
                            <div id="collapse1" class="panel-collapse collapse in">
                              <div class="panel-body">
                                  <div class="row">
                                      <label class="col-md-4">Unique_id:</label>
                                      <div class="col-md-8" id="unique_id"></div>
                                  </div>
                                  <div class="row">
                                      <label class="col-md-4">Registration No:</label>
                                      <div class="col-md-8" id="registration_no"></div>
                                  </div>
                                  <div class="row">
                                    <label class="col-md-4 text-md-right">Facility Name:</label>
                                    <div class="col-md-8" id="facility_name">    </div>
                                  </div>
                                  <div class="row">
                                      <label class="col-md-4 text-md-right">Alternate Name:</label>
                                      <div class="col-md-8" id="alt_facility_name">    </div>
                                  </div>
                                  <div class="row">
                                      <label class="col-md-4 text-md-right">Start Date:</label>
                                      <div class="col-md-8" id="start_date">    </div>
                                  </div>
                                  <div class="row">
                                      <label class="col-md-4 text-md-right">Ownership:</label>
                                      <div class="col-md-8" id="ownership">    </div>
                                  </div>
                                  <div class="row">
                                      <label class="col-md-4 text-md-right">Ownership Type:</label>
                                      <div class="col-md-8" id="ownership_type">    </div>
                                  </div>
                                  <div class="row">
                                      <label class="col-md-4 text-md-right">Ownership Details:</label>
                                      <div class="col-md-8" id="ownership_details">    </div>
                                  </div>
                                  <div class="row">
                                      <label class="col-md-4 text-md-right">Facility Level:</label>
                                      <div class="col-md-8" id="facility_level">    </div>
                                  </div>
                                  <div class="row">
                                      <label class="col-md-4 text-md-right">Facility Level Option:</label>
                                      <div class="col-md-8" id="facility_level_option">    </div>
                                  </div>
                                  <div class="row">
                                      <label class="col-md-4 text-md-right">Days of Operation:</label>
                                      <div class="col-md-8" id="operational_days">   </div>
                                  </div>
                                  <div class="row">
                                      <label class="col-md-4 text-md-right">Hours of Operation:</label>
                                      <div class="col-md-8" id="operational_hours">   </div>
                                  </div>
                            </div>
                            </div>
                          </div>
                          {{-- panel two --}}
                          <div class="panel panel-default">
                            <div class="panel-heading">
                              <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Location</a>
                              </h4>
                            </div>
                            <div id="collapse2" class="panel-collapse collapse">
                              <div class="panel-body">
                                  <div class="row">
                                      <label class="col-md-4">State:</label>
                                      <div class="col-md-8" id="state"></div>
                                  </div>
                                  <div class="row">
                                      <label class="col-md-4">LGA:</label>
                                      <div class="col-md-8" id="lga"></div>
                                  </div>
                                  <div class="row">
                                      <label class="col-md-4">Ward:</label>
                                      <div class="col-md-8" id="ward"></div>
                                  </div>
                                  <div class="row">
                                      <label class="col-md-4">House No:</label>
                                      <div class="col-md-8" id="house_no"></div>
                                  </div>      
                                  <div class="row">
                                      <label class="col-md-4">Street Name:</label>
                                      <div class="col-md-8" id="street_name"></div>
                                  </div>
                                  <div class="row">
                                      <label class="col-md-4">Longitude:</label>
                                      <div class="col-md-8" id="longitude"></div>
                                  </div>
                                  <div class="row">
                                      <label class="col-md-4">Latitude:</label>
                                      <div class="col-md-8" id="latitude"></div>
                                  </div>
                                  <div class="row">
                                      <label class="col-md-4">Address:</label>
                                      <div class="col-md-8" id="postal_address"></div>
                                  </div>
                              </div>
                            </div>
                          </div>
                          {{-- panel 3 --}}
                          <div class="panel panel-default">
                            <div class="panel-heading">
                              <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">Contacts</a>
                              </h4>
                            </div>
                            <div id="collapse3" class="panel-collapse collapse">
                              <div class="panel-body">
                                  <div class="row">
                                      <label class="col-md-4">Phone Number:</label>
                                      <div class="col-md-8" id="phone_number"></div>
                                  </div>
                                  <div class="row">
                                      <label class="col-md-4">Emai Address:</label>
                                      <div class="col-md-8" id="email_address"></div>
                                  </div>
                                  <div class="row">
                                      <label class="col-md-4">Website:</label>
                                      <div class="col-md-8" id="website"></div>
                                  </div>
                              </div>
                            </div>
                          </div>
                          {{-- panel four --}}
                          <div class="panel panel-default">
                              <div class="panel-heading">
                                <h4 class="panel-title">
                                  <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">Status</a>
                                </h4>
                              </div>
                              <div id="collapse4" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="row">
                                        <label class="col-md-4">Operational Status:</label>
                                        <div class="col-md-8" id="operation_status"></div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-4">Regulatory Status:</label>
                                        <div class="col-md-8" id="regulatory_status"></div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-4">License Status:</label>
                                        <div class="col-md-8" id="license_status"></div>
                                    </div>
                                </div>
                              </div>
                            </div>
                            {{-- panel five --}}
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                  <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse5">Personnel</a>
                                  </h4>
                                </div>
                                <div id="collapse5" class="panel-collapse collapse">
                                  <div class="panel-body">
                                      <div class="row">
                                          <label class="col-md-6">No. of Doctors:</label>
                                          <div class="col-md-6" id="doctors"></div>
                                      </div>
                                      <div class="row">
                                          <label class="col-md-6">No. of Pharmacists:</label>
                                          <div class="col-md-6" id="pharmacists"></div>
                                      </div>
                                      <div class="row">
                                          <label class="col-md-6">No. of Dentists:</label>
                                          <div class="col-md-6" id="dentist"></div>
                                      </div>
                                      <div class="row">
                                          <label class="col-md-6">No. Pharmacy Technicians:</label>
                                          <div class="col-md-6" id="pharmacy_technicians"></div>
                                      </div>
                                      <div class="row">
                                          <label class="col-md-6">No. of Nurses:</label>
                                          <div class="col-md-6" id="nurses"></div>
                                      </div>
                                      <div class="row">
                                          <label class="col-md-6">No. of Midwifes:</label>
                                          <div class="col-md-6" id="midwifes"></div>
                                      </div>
                                      <div class="row">
                                          <label class="col-md-6">No. of Nurses/Midwifes:</label>
                                          <div class="col-md-6" id="nurse_midwife"></div>
                                      </div>
                                      <div class="row">
                                          <label class="col-md-6">No. of Lab Technicians:</label>
                                          <div class="col-md-6" id="lab_technicians"></div>
                                      </div>
                                      <div class="row">
                                          <label class="col-md-6">No. of Lab Scientits:</label>
                                          <div class="col-md-6" id="lab_scientists"></div>
                                      </div>
                                      <div class="row">
                                          <label class="col-md-6">Health Records/HIM Officers:</label>
                                          <div class="col-md-6" id="him_officers"></div>
                                      </div>
                                      <div class="row">
                                          <label class="col-md-6">No. of Community Health Officer:</label>
                                          <div class="col-md-6" id="community_health_officer"></div>
                                      </div>
                                      <div class="row">
                                          <label class="col-md-6">No. of Community Health Extension Worker:</label>
                                          <div class="col-md-6" id="community_extension_workers"></div>
                                      </div>
                                      <div class="row">
                                          <label class="col-md-6">No. of Junior Com Health Extension Worker:</label>
                                          <div class="col-md-6" id="jun_community_extension_worker"></div>
                                      </div>
                                      <div class="row">
                                          <label class="col-md-6">No. of Dental Technicians:</label>
                                          <div class="col-md-6" id="dental_technicians"></div>
                                      </div>
                                      <div class="row">
                                          <label class="col-md-6">No. of Environmental Health Officers:</label>
                                          <div class="col-md-6" id="env_health_officers"></div>
                                      </div>
                                  </div>
                                </div>
                              </div>
                              {{-- pane six --}}
                              <div class="panel panel-default">
                                  <div class="panel-heading">
                                    <h4 class="panel-title">
                                      <a data-toggle="collapse" data-parent="#accordion" href="#collapse6">Services</a>
                                    </h4>
                                  </div>
                                  <div id="collapse6" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <div class="row">
                                            <label class="col-md-6">Onsite Laboratory:</label>
                                            <div class="col-md-6" id="onsite_laboratory"></div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-6">Onsite Imaging:</label>
                                            <div class="col-md-6" id="onsite_imaging"></div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-6">Onsite Pharmacy:</label>
                                            <div class="col-md-6" id="onsite_pharmarcy"></div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-6">Mortuary Services:</label>
                                            <div class="col-md-6" id="mortuary_services"></div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-6">Beds Accidents and Emergency:</label>
                                            <div class="col-md-6" id="beds_accidents_emerg"></div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-6">Beds Admission Facilities:</label>
                                            <div class="col-md-6" id="beds_adminission"></div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-6">Beds ICU:</label>
                                            <div class="col-md-6" id="beds_icu"></div>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                        </div> 
                     

                </div>
               
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
           </div>
          </div><!-- /.modal-content -->
    </div><!--/.modal-dialog -->
</div><!-- end modal -->






        
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