@extends("layouts.master")

@section('bk_css')

@endsection

@section('content-title')
Hospitals and Clinics Facilities

<a href="{{route('hospitals.create')}}">
        <button type="button" class="btn btn-primary pull-right">
                New Hospital or Clinic
        </button>
    </a>
@endsection

@section("content")
<div class="box">
    <div class="box-header with-border">
    <form class="form-horizontal"  action="{{route('searchHospitalsAdmin')}}" method="post">
                @csrf
                <div class="form-group">
                   
                  <div class="col-sm-3">
                        <select class="form-control select2" id="state_id" name ="state_id">
                                <option value="">--Select State--<option>
                                @foreach($lst_states as $st)
                                    <option value="{{$st->id}}">{{$st->name}}</option>
                                @endforeach
                        </select>
                  </div>
                  
                  <div class="col-sm-3">
                      <select class="form-control select2" id="lga_id" name="lga_id">
                         
                      </select>
                  </div>
             
    
                  <div class="col-sm-4" >
                    <input class="form-control input-sm" type="text" name="facility_name" id="facility_name" class="form-control" placeholder="hospital/clinic name">
                  </div>
    
                  <div class="col-sm-2">
                      <button type="submit" class="btn btn-success pull-right btn-sm">Search</button>
                  </div>
    
              </div>
            </form>
</div>

        <div class="box-body">
          
          <table id="table1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>State</th>
                <th>LGA</th>
                <th>Ward</th>
                <th>Unique ID</th>
                <th>Facility Name</th>
                <th>Facility Level</th>
                <th>Ownership</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
           
              @foreach($facilities as $fac)
              <tr>
                  <td>{{$fac->state}}</td>
                  <td>{{$fac->lga}}</td>
                  <td>{{$fac->ward}}</td>
                  <td>{{$fac->unique_id}}</td>
                  <td>{{$fac->facility_name}}</td>
                  <td>{{$fac->facility_level}}</td>
                  <td>{{$fac->ownership}}</td>
                  <td>
                      <a href="{{route('hospitals.show',$fac->id)}}">
                            <button class="btn btn-success btn-sm"  type="button">View</button>
                          </a>
                          <a href="{{route('hospitals.edit',$fac->id)}}">
                            <button class="btn btn-warning btn-sm"  type="button" > Edit</button>
                          </a>
                        </td>
                  </tr>
              @endforeach
              
            </tbody>
          </table>
       

      </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <div class="row">
            
                @php
                  $perpage = $facilities->perpage();
                  $currentpage = $facilities->currentpage();
                  $from = ($currentpage-1)*$perpage+1;
                  
                  if ($facilities->currentpage() == $facilities->lastpage()) {
                    $to = $facilities->total();
                  } else {
                    $to = $currentpage*$perpage;
                  }
                @endphp
           
                <div class="col-md-4">
                    Showing {{$from}} to {{$to}} of {{$facilities->total()}} entries
                   
                </div>
                <div class="col-md-8">
                    <div class="pull-right">
                        {{$facilities->links()}}                  
                    </div>
                </div>

          </div>
        </div>

  </div>
      <!-- /.box -->
@endsection 


@push('bk_script')
  @include('partials.dynamic_state_script')

  <script>
      $(document).ready( function () {


      });
  </script>

@endpush