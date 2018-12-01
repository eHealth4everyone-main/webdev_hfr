 
  <!-- Left side column. contains the sidebar -->
   <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <!-- search form -->
            <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                <li>
                    <a target="_blank" rel="noopener noreferrer" href="{{route('home')}}">
                        <i class="fa fa-home"></i> 
                        <span>Public Home</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin_home')}}">
                        <i class="fa fa-dashboard"></i> 
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="treeview"> 
                    <a href="#">
                        <i class="fa fa-gears"></i>
                        <span>Masters</span>
                        <span class="pull-right-container">
                            <span class="label label-success pull-right">7</span>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('states.index')}}"><i class="fa fa-gear"></i> States</a></li>
                        <li><a href="{{route('lgas.index')}}"><i class="fa fa-gear"></i> LGAs</a></li>
                        <li><a href="{{route('wards.index')}}"><i class="fa fa-gear"></i> Wards</a></li>
                        <li><a href="{{route('hospServices.index')}}"><i class="fa fa-gear"></i> Hospital Services</a></li>
                        <li><a href="{{route('service.index')}}"><i class="fa fa-gear"></i> Imaging Services</a></li>
                        <li><a href="{{route('equip.index')}}"><i class="fa fa-gear"></i> Laboratory Equipments</a></li>
                        <li><a href="{{route('certification.index')}}"><i class="fa fa-gear"></i> Laboratory Certification</a></li>
                    </ul>
                </li>
                <li> 
                    <a href="{{route('hospitals.index')}}">
                        <i class="fa fa-h-square"></i>
                        <span>Hospitals and Clinics</span>
                    </a>
                </li>
                <li> 
                <a href="{{route('pharmacies.index')}}">
                        <i class="fa fa-medkit"></i>
                        <span>Pharmaceutical Premises</span>
                    </a>
                </li>
                <li> 
                <a href="{{route('laboratory.index')}}">
                        <i class="fa fa-stethoscope"></i>
                        <span>Laboratory Premises</span>
                    </a>
                </li>
                <li> 
                    <a href="{{route('imaging.index')}}">
                        <i class="fa fa-hospital-o"></i>
                        <span>Radiological Premises</span>
                    </a>
                </li>

                <li> 
                    <a href="{{route('getMessages')}}">
                        <i class="fa  fa-comments"></i>
                        <span>Messages</span>
                    </a>
                </li>
                <li> 
                    <a href="{{route('downloadList')}}">
                        <i class="fa  fa-download"></i>
                        <span>Download Requests</span>
                    </a>
                </li>
            
                <li  class="treeview"> 
                    <a href="#">
                        <i class="fa fa-users"></i>
                        <span>User Management</span>
                        <span class="pull-right-container">
                                <span class="label label-success pull-right">2</span>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                            <li><a href="{{route('roles.index')}}"><i class="fa fa-user-secret"></i>Roles</a></li>
                            <li><a href="{{route('users.index')}}"><i class="fa fa-user"></i>Users</a></li>
                    </ul>
                </li>
                <li> 
                    <a href="{{route('resources')}}">
                        <i class="fa  fa-folder"></i>
                        <span>Resources</span>
                    </a>
                </li>
          
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>
