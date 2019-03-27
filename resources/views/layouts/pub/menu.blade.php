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
                        <li><a >Facilities List</a>
                            <ul class="sub-menu">
                                <li><a href="{{route('list.hospitals')}}">Hospitals & Clinics</a></li>
                                <li><a href="{{route('list.pharmacy')}}">Pharmaceuticals</a></li>
                                <li><a href="{{route('list.laboratory')}}">Laboratories </a></li>
                                <li><a href="{{route('list.imaging')}}">Radiologies/Imagings</li>
                            </ul>
                        </li>
                     
                        <li><a href="{{route('openRegistrationForm')}}">Data Downloads</a> </li>
                        <li><a href="{{route('public_resources')}}">Resources</a></li>
                        <li><a href="{{route('latest.updates')}}">Reports</a></li>
          
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