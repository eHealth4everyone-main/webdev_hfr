<!doctype html>
<html class="no-js" lang="en">
    
<head>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-130161904-1"></script>
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
        
      <!-- Goolge Map Modal -->
        <div class="modal fade" id="googleMapModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"  >
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Facilities in LGA</h4>
                        </div>
                        <div class="modal-body">
                            <div id="googleMap" style="height: 500px; min-width: 500px; max-width: 800px; margin: 0 auto"></div>
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
        </div>

        <!-- Modal Facility Details on google map-->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" style="overflow-y:scroll; height:600px;">
                <div class="modal-content">
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Facility Details</h4>
                    </div>
                    <div class="modal-body">
                                <div class="row">
                                    <label class="col-sm-3 " style="text-align: right;">Unique ID:</label>                            
                                    <div class="col-sm-3" id = "unique_id">
                                    </div>
                                </div>
                                <div class="row">
                                    
                                    <label class="col-sm-3 " style="text-align: right;">Registered No:</label>                            
                                    <div class="col-sm-3" id = "registration_no">
                                    </div>
                                    
                                    <label class="col-sm-3 " style="text-align: right;">Commencement Date:</label>
                                    <div class="col-sm-3" id = "start_date">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <label class="col-sm-3" style="text-align: right;">Registered Name:</label>
                                    <div class="col-sm-3" id = "facility_name">
                                    </div>
                                    
                                    <label for="alt_facility_name" class="col-sm-3 " style="text-align: right;">Alternate Name:</label> 
                                    <div class="col-sm-3" id = "alt_facility_name">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <label class="col-sm-3 " style="text-align: right;">State: </label></label>
                                    <div class="col-sm-3" id = "state">
                                    </div>
                                    
                                    <label class="col-sm-3 " style="text-align: right;">LGA:</label></label>
                                    <div class="col-sm-3" id = "lga">
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <label class="col-sm-3 " style="text-align: right;">Ward:</label>
                                    <div class="col-sm-9" id = "ward">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <label for="house_no" class="col-sm-3 " style="text-align: right;">House Number:</label>
                                    <div class="col-sm-3" id = "house_no">
                                    </div>
                                    
                                    <label for="street_name" class="col-sm-3 " style="text-align: right;">Street Name:</label>
                                    <div class="col-sm-3" id = "street_name">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <label for="latitude" class="col-sm-3 " style="text-align: right;">Latitude:</label>
                                    <div class="col-sm-3" id = "latitude">
                                    </div>
                                    
                                    <label for="longitude" class="col-sm-3 " style="text-align: right;">Longitude:</label>
                                    <div class="col-sm-3" id = "longitude">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="postal_address" class="col-sm-3 " style="text-align: right;">Postal Address:</label>
                                    <div class="col-sm-3" id = "postal_address">
                                    </div>
                                    
                                    <label for="phone_number" class="col-sm-3 " style="text-align: right;">Phone Number:</label>
                                    <div class="col-sm-3" id = "phone_number">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="email_address" class="col-sm-3 " style="text-align: right;">Email Address:</label>
                                    <div class="col-sm-3" id = "email_address">
                                    </div>
                                    
                                    <label for="website" class="col-sm-3 " style="text-align: right;">Website:</label>
                                    <div class="col-sm-3" id = "website">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <label class="col-sm-3 " style="text-align: right;">Days of Operation:</label>
                                    <div class="col-sm-3" id = "operational_days">
                                    </div>
                                    <label class="col-sm-3 " style="text-align: right;">Hours of Operation:</label>
                                    <div class="col-sm-3" id = "operational_hours">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <label class="col-sm-3 " style="text-align: right;">Hospital/ Clinic Level:</label></label>
                                    <div class="col-sm-3" id = "facility_level">
                                    </div>
                                    <label id="level_option_label" class="col-sm-3 " style="text-align: right;" style="display:none">Facility Level Options:</label>
                                    <div  class="col-sm-3" style="display:none" id = "facility_level_option">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <label class="col-sm-3 " style="text-align: right;">Ownership: </label></label>
                                    <div class="col-sm-3" id = "ownership">
                                    </div>
                                    <label class="col-sm-3 " style="text-align: right;">Ownership Type:</label>
                                    <div class="col-sm-3" id = "ownership_type">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <label for="hs_ownership_details" class="col-sm-3 " style="text-align: right;">Ownership Details:</label>
                                    <div class="col-sm-9" id = "ownership_details">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <label class="col-sm-3 " style="text-align: right;">Operation Status:</label></label>
                                    <div class="col-sm-3" id = "operation_status">                           
                                    </div>
                                    <label class="col-sm-3 " style="text-align: right;">Regulatory Status:</label>
                                    <div class="col-sm-3" id = "regulatory_status">                                                       
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-3 " style="text-align: right;">License Status:</label>
                                    <div class="col-sm-3" id = "license_status">                           
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="hs_no_doctors" class="col-sm-3 " style="text-align: right;">Medical Doctors:</label>
                                    <div class="col-sm-3" id = "doctors">
                                    </div>
                                    <label for="hs_no_pharm" class="col-sm-3 " style="text-align: right;">Pharmacists:</label>
                                    <div class="col-sm-3" id = "pharmacists">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="hs_no_dentist" class="col-sm-3 " style="text-align: right;">Dentists:</label>
                                    <div class="col-sm-3" id = "dentist">
                                    </div>
                                    <label for="hs_no_pharm_tech" class="col-sm-3 " style="text-align: right;">Pharmacy Technicians:</label>
                                    <div class="col-sm-3" id = "pharmacy_technicians">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="hs_no_single_qualified_nurses" class="col-sm-3 " style="text-align: right;">Nurses (Single):</label>
                                    <div class="col-sm-3" id = "nurses">
                                    </div>
                                    <label for="hs_no_lab_sc" class="col-sm-3 " style="text-align: right;">Laboratory Scientists:</label>
                                    <div class="col-sm-3" id = "lab_scientists">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="hs_no_single_qualified_midwives" class="col-sm-3 " style="text-align: right;">Midwifes (Single):</label>
                                    <div class="col-sm-3" id = "midwifes">
                                    </div>
                                    <label for="hs_no_lab_tech" class="col-sm-3 " style="text-align: right;">Laboratory Technicians:</label>
                                    <div class="col-sm-3" id = "lab_technicians">
                                    </div>
                                </div> 
                                
                                <div class="row">
                                    <label for="hs_nurses_midwives" class="col-sm-3 " style="text-align: right;">Nurse/ Midwife (Double):</label>
                                    <div class="col-sm-3" id = "nurse_midwife">
                                    </div>
                                    <label for="hs_no_health_rec" class="col-sm-3 " style="text-align: right;">Health Records/HIM Officers:</label>
                                    <div class="col-sm-3" id = "him_officers">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="hs_no_comm_health_officer" class="col-sm-3 " style="text-align: right;">Community Health Officer:</label>
                                    <div class="col-sm-3" id = "community_health_officer">
                                    </div>
                                    <label for="hs_no_comm_health_ext_officer" class="col-sm-3 " style="text-align: right;">Community Health Extension Worker:</label>
                                    <div class="col-sm-3" id = "community_extension_workers">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="hs_no_jun_comm_health_ext_off" class="col-sm-3 " style="text-align: right;">Junior Com Health Extension Worker:</label>
                                    <div class="col-sm-3" id = "jun_community_extension_worker">
                                    </div>
                                    <label for="hs_no_dental_tech" class="col-sm-3 " style="text-align: right;">Dental Technicians:</label>
                                    <div class="col-sm-3" id = "dental_technicians">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="hs_no_env_health_officer" class="col-sm-3 " style="text-align: right;">Environmental Health Officers:</label>
                                    <div class="col-sm-9" id = "env_health_officers">
                                    </div>
                                </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
                </div>
        </div>

         <!-- Show facility details on view click public facility list -->
         <div class="modal fade" id="showFacDetails" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"  >
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Facility Details</h4>
                        </div>
                        <div class="modal-body">
                                <div class="row">
                                    <label class="col-sm-3 " style="text-align: right;">Unique ID:</label>                            
                                    <div class="col-sm-3" id = "unique_id1">
                                    </div>
                                </div>
                                <div class="row">
                                    
                                    <label class="col-sm-3 " style="text-align: right;">Registered No:</label>                            
                                    <div class="col-sm-3" id = "registration_no1">
                                    </div>
                                    
                                    <label class="col-sm-3 " style="text-align: right;">Commencement Date:</label>
                                    <div class="col-sm-3" id = "start_date1">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <label class="col-sm-3" style="text-align: right;">Registered Name:</label>
                                    <div class="col-sm-3" id = "facility_name1">
                                    </div>
                                    
                                    <label for="alt_facility_name" class="col-sm-3 " style="text-align: right;">Alternate Name:</label> 
                                    <div class="col-sm-3" id = "alt_facility_name1">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <label class="col-sm-3 " style="text-align: right;">State: </label></label>
                                    <div class="col-sm-3" id = "state1">
                                    </div>
                                    
                                    <label class="col-sm-3 " style="text-align: right;">LGA:</label></label>
                                    <div class="col-sm-3" id = "lga1">
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <label class="col-sm-3 " style="text-align: right;">Ward:</label>
                                    <div class="col-sm-9" id = "ward1">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <label for="house_no" class="col-sm-3 " style="text-align: right;">House Number:</label>
                                    <div class="col-sm-3" id = "house_no1">
                                    </div>
                                    
                                    <label for="street_name" class="col-sm-3 " style="text-align: right;">Street Name:</label>
                                    <div class="col-sm-3" id = "street_name1">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <label for="latitude" class="col-sm-3 " style="text-align: right;">Latitude:</label>
                                    <div class="col-sm-3" id = "latitude1">
                                    </div>
                                    
                                    <label for="longitude" class="col-sm-3 " style="text-align: right;">Longitude:</label>
                                    <div class="col-sm-3" id = "longitude1">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="postal_address" class="col-sm-3 " style="text-align: right;">Postal Address:</label>
                                    <div class="col-sm-3" id = "postal_address1">
                                    </div>
                                    
                                    <label for="phone_number" class="col-sm-3 " style="text-align: right;">Phone Number:</label>
                                    <div class="col-sm-3" id = "phone_number1">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="email_address" class="col-sm-3 " style="text-align: right;">Email Address:</label>
                                    <div class="col-sm-3" id = "email_address1">
                                    </div>
                                    
                                    <label for="website" class="col-sm-3 " style="text-align: right;">Website:</label>
                                    <div class="col-sm-3" id = "website1">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <label class="col-sm-3 " style="text-align: right;">Days of Operation:</label>
                                    <div class="col-sm-3" id = "operational_days1">
                                    </div>
                                    <label class="col-sm-3 " style="text-align: right;">Hours of Operation:</label>
                                    <div class="col-sm-3" id = "operational_hours1">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <label class="col-sm-3 " style="text-align: right;">Hospital/ Clinic Level:</label></label>
                                    <div class="col-sm-3" id = "facility_level1">
                                    </div>
                                    <label id="level_option_label" class="col-sm-3 " style="text-align: right;" style="display:none">Facility Level Options:</label>
                                    <div  class="col-sm-3" style="display:none" id = "facility_level_option1">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <label class="col-sm-3 " style="text-align: right;">Ownership: </label></label>
                                    <div class="col-sm-3" id = "ownership1">
                                    </div>
                                    <label class="col-sm-3 " style="text-align: right;">Ownership Type:</label>
                                    <div class="col-sm-3" id = "ownership_type1">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <label for="hs_ownership_details" class="col-sm-3 " style="text-align: right;">Ownership Details:</label>
                                    <div class="col-sm-9" id = "ownership_details1">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <label class="col-sm-3 " style="text-align: right;">Operation Status:</label></label>
                                    <div class="col-sm-3" id = "operation_status1">                           
                                    </div>
                                    <label class="col-sm-3 " style="text-align: right;">Regulatory Status:</label>
                                    <div class="col-sm-3" id = "regulatory_status1">                                                       
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-3 " style="text-align: right;">License Status:</label>
                                    <div class="col-sm-3" id = "license_status1">                           
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="hs_no_doctors" class="col-sm-3 " style="text-align: right;">Medical Doctors:</label>
                                    <div class="col-sm-3" id = "doctors1">
                                    </div>
                                    <label for="hs_no_pharm" class="col-sm-3 " style="text-align: right;">Pharmacists:</label>
                                    <div class="col-sm-3" id = "pharmacists1">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="hs_no_dentist" class="col-sm-3 " style="text-align: right;">Dentists:</label>
                                    <div class="col-sm-3" id = "dentist1">
                                    </div>
                                    <label for="hs_no_pharm_tech" class="col-sm-3 " style="text-align: right;">Pharmacy Technicians:</label>
                                    <div class="col-sm-3" id = "pharmacy_technicians1">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="hs_no_single_qualified_nurses" class="col-sm-3 " style="text-align: right;">Nurses (Single):</label>
                                    <div class="col-sm-3" id = "nurses1">
                                    </div>
                                    <label for="hs_no_lab_sc" class="col-sm-3 " style="text-align: right;">Laboratory Scientists:</label>
                                    <div class="col-sm-3" id = "lab_scientists1">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="hs_no_single_qualified_midwives" class="col-sm-3 " style="text-align: right;">Midwifes (Single):</label>
                                    <div class="col-sm-3" id = "midwifes1">
                                    </div>
                                    <label for="hs_no_lab_tech" class="col-sm-3 " style="text-align: right;">Laboratory Technicians:</label>
                                    <div class="col-sm-3" id = "lab_technicians1">
                                    </div>
                                </div> 
                                
                                <div class="row">
                                    <label for="hs_nurses_midwives" class="col-sm-3 " style="text-align: right;">Nurse/ Midwife (Double):</label>
                                    <div class="col-sm-3" id = "nurse_midwife1">
                                    </div>
                                    <label for="hs_no_health_rec" class="col-sm-3 " style="text-align: right;">Health Records/HIM Officers:</label>
                                    <div class="col-sm-3" id = "him_officers1">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="hs_no_comm_health_officer" class="col-sm-3 " style="text-align: right;">Community Health Officer:</label>
                                    <div class="col-sm-3" id = "community_health_officer1">
                                    </div>
                                    <label for="hs_no_comm_health_ext_officer" class="col-sm-3 " style="text-align: right;">Community Health Extension Worker:</label>
                                    <div class="col-sm-3" id = "community_extension_workers1">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="hs_no_jun_comm_health_ext_off" class="col-sm-3 " style="text-align: right;">Junior Com Health Extension Worker:</label>
                                    <div class="col-sm-3" id = "jun_community_extension_worker1">
                                    </div>
                                    <label for="hs_no_dental_tech" class="col-sm-3 " style="text-align: right;">Dental Technicians:</label>
                                    <div class="col-sm-3" id = "dental_technicians1">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="hs_no_env_health_officer" class="col-sm-3 " style="text-align: right;">Environmental Health Officers:</label>
                                    <div class="col-sm-9" id = "env_health_officers1">
                                    </div>
                                </div>
                                <div class="row">
                                        <label  class="col-sm-3 " style="text-align: right;">Services:</label>
                                        <div class="col-sm-9" id = "services1">
                                        </div>
                                </div>
                    </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
        </div>

        
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