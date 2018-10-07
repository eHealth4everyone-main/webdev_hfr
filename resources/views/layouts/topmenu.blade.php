 <!-- Collect the nav links, forms, and other content for toggling -->
 <div class="collapse navbar-collapse" id="navbar1">
    <ul class="nav navbar-nav navbar-default">
        <li><a href="{{route('home')}}">Home</a></li>
        <li><a href="{{route('about')}}">About</a></li>
        <li><a href="{{route('statistics')}}">Statistics</a></li>
        <li><a href="{{route('statistics_charts')}}">Charts</a></li>
        <li><a href="{{route('listhosp')}}">Facilities List</a></li>
    
        <li><a href="{{route('downloadfm')}}">Data Downloads</a></li>
        <li><a href="{{route('public_resources')}}">Resources</a></li>
        <li><a href="{{route('open_contact_form')}}">Contact us</a></li>
        <li><a href="{{route('admin_home')}}">Administrator</a></li>

        
        {{-- <form class="navbar-form navbar-right " action="{{route('search')}}" role="search">
          @csrf
          <select class="form-control input-sm" id="facilitytype1" name="facilitytype" required>
              <option value="1">Hospitals</option>
              <option value="2">Laboratories</option>
              <option value="3">Pharmaceuticals</option>
              <option value="4">Radiology and Imaging</option>
          </select>
            <div class="input-group input-group-sm" >
               
                <input type="text" name="fac_name" class="form-control" placeholder="Facility name" required>
                    <span class="input-group-btn">
                      <button type="submit" class="btn btn-success btn-flat">Search</button>
                    </span>
              </div>
        </form> --}}

      </ul>
</div><!-- /.navbar-collapse -->