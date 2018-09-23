 <!-- Collect the nav links, forms, and other content for toggling -->
 <div class="collapse navbar-collapse" id="navbar1">
    <ul class="nav navbar-nav navbar-default">
        <li><a href="{{route('home')}}">Home</a></li>
        <li><a href="{{route('about')}}">About</a></li>
        <li><a href="{{route('statistics')}}">Statistics</a></li>
        <li><a href="{{route('statistics_charts')}}">Charts</a></li>
        <li><a href="{{route('listhosp')}}">Facilities List</a></li>
    
        <li><a href="#">Data Downloads</a></li>
        <li><a href="{{route('public_resources')}}">Resources</a></li>
        <li><a href="#">Contact us</a></li>
        <li><a href="{{route('admin_home')}}">Administrator</a></li>

        <form class="navbar-form navbar-right" action="{{route('search')}}" role="search">
          @csrf
            <div class="form-group">
              <input type="text" name="fac_name" class="form-control" placeholder="Enter facility name to" required>
            </div>
            <button type="submit" class="btn btn-default">Search</button>
        </form>

      </ul>
</div><!-- /.navbar-collapse -->