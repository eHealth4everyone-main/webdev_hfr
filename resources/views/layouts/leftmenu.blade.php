 
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
                            <span class="label label-success pull-right">6</span>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="/equipments"><i class="fa fa-gear"></i> Laboratory Equipments</a></li>
                        <li><a href="/cert"><i class="fa fa-gear"></i> Laboratory Certification</a></li>
                        <li><a href="/iservice"><i class="fa fa-gear"></i> Imaging Services</a></li>
                        <li><a href="/states"><i class="fa fa-gear"></i> States</a></li>
                        <li><a href="/lga"><i class="fa fa-gear"></i> LGAs</a></li>
                        <li><a href="/wards"><i class="fa fa-gear"></i> Wards</a></li>
                    </ul>
                </li>
                <li> 
                    <a href="{{route('hospitals.index')}}">
                        <i class="fa fa-h-square"></i>
                        <span>Hospitals and Clinics</span>
                    </a>
                </li>
                <li> 
                    <a href="/pharma">
                        <i class="fa fa-medkit"></i>
                        <span>Pharmaceutical Premises</span>
                    </a>
                </li>
                <li> 
                    <a href="/lab">
                        <i class="fa fa-stethoscope"></i>
                        <span>Laboratory Premises</span>
                    </a>
                </li>
                <li> 
                    <a href="/imaging">
                        <i class="fa fa-hospital-o"></i>
                        <span>Radiological Premises</span>
                    </a>
                </li>

                <li> 
                    <a href="/messages">
                        <i class="fa  fa-comments"></i>
                        <span>Messages</span>
                    </a>
                </li>
                <li> 
                    <a href="/download/list">
                        <i class="fa  fa-download"></i>
                        <span>Downloads</span>
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
                            <li><a href="/roles"><i class="fa fa-user-secret"></i>Roles</a></li>
                            <li><a href="/users"><i class="fa fa-user"></i>Users</a></li>
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
