 <!-- Collect the nav links, forms, and other content for toggling -->
 <div class="collapse navbar-collapse" id="navbar1">
    <ul class="nav navbar-nav navbar-default">
        <li><a href="{{route('home')}}">Home</a></li>
        <li><a href="{{route('about')}}">About</a></li>
        <li><a href="#">Statistics</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Facilities List <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="{{route('listhosp')}}">Hospitals</a></li>
            <li><a href="{{route('listlab')}}">Laboratories</a></li>
            <li><a href="{{route('listpharmacy')}}">Pharmaceuticals</a></li>
            <li><a href="{{route('listradiology')}}">Radiology and Imaging</a></li>
          </ul>
        </li>
    
        <li><a href="#">Data Downloads</a></li>
        <li><a href="{{route('public_resources')}}">Resources</a></li>
        <li><a href="#">Contact us</a></li>
        <li><a href="{{route('admin_home')}}">Administrator</a></li>

      </ul>
</div><!-- /.navbar-collapse -->