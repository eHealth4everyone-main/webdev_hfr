@extends("layouts.public_master")

@section('kibiti_css')

@endsection

@section('content-title')
  {{-- <h4><p class="text-light-blue">List of Hospitals and Clinics</p></h4>        --}}
  
@endsection

@section("content")   

<div class="box">
    <div class="box-header">
        <form class="form-horizontal"  action="{{route('getfacilities')}}" method="GET">
            @csrf
            <div class="form-group">
               
                <div class="col-sm-4">
                    <select class="form-control select2" id="facilitytype" name="facilitytype" required>
                        <option value="1">Hospitals</option>
                        <option value="2">Laboratories</option>
                        <option value="3">Pharmaceuticals</option>
                        <option value="4">Radiology and Imaging</option>
                    </select>
                </div>
              <div class="col-sm-3">
                  <select class="form-control select2" id="state" name ="state">
                        @include('public.states')
                  </select>
              </div>
              
              <div class="col-sm-4">
                  <select class="form-control select2" id="lga" name="lga">
                      <option value="">--Select LGA--</option>
                  </select>
              </div>

              <div class="col-sm-1">
                  <button type="submit" class="btn btn-success btn-sm pull-right">Search</button>
              </div>

          </div>
        </form>

    </div>
  <div class="box-body">
          <table id="hosp" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Unique ID</th>
                <th>Facility Name</th>
                <th>State</th>
                <th>LGA</th>
                <th>Facility Type</th>
                <th>Ownership</th>
              </tr>
            </thead>
            <tbody>
           
              @foreach($facilities as $fac)
              <tr>
                <td>{{$fac->unique_id}}</td>
                <td>{{$fac->facility_name}}</td>
                <td>{{$fac->state}}</td>
                <td>{{$fac->lga}}</td>
                <td>{{$fac->level}}</td>
                <td>{{$fac->ownership}}</td>
          
              </tr>
              @endforeach
              
            </tbody>
          </table>
      
        </div>
        <!-- /.box-body -->
      </div> 
      <!-- /.box -->
@endsection 

@push('kibiti_scripts')
@include('partials.dynamic_lgas_only')

<script>
    $(document).ready( function () {
      $('#hosp').DataTable( {
        "paging":   true,
        "ordering": true,
        "info":     true,
        "lengthChange": false,
        "searching"   : true,
        "autoWidth"   : false,
        "pageLength": 20,
    } );
  } );
</script>

@endpush