@extends("layouts.public_master")

@section('kibiti_css')

@endsection

@section('content-title')
       
  
@endsection

@section("content")   
<div class="box">
    
    <div class="box-body">
        <form class="form-horizontal"  action="{{route('getfacilities')}}" method="GET">
            @csrf
            <div class="form-group">
               
                <div class="col-sm-4">
                    <select class="form-control select2" id="facilitytype" name="facilitytype" required>
                        <option value="">--Facility Type--</option>
                        <option value="1">Hospitals</option>
                        <option value="2">Laboratories</option>
                        <option value="3">Pharmaceuticals</option>
                        <option value="4">Radiology and Imaging</option>
                    </select>
                </div>
              <div class="col-sm-2">
                  <select class="form-control select2" id="state" name ="state">
                      <option value="">--Select State--</option>
                      <option value='01' > Abia</option>
                      <option value='02' > Adamawa</option>
                      <option value='03' > Akwa Ibom</option>
                      <option value='04' > Anambra</option>
                      <option value='05' > Bauchi</option>
                      <option value='06' > Bayelsa</option>
                      <option value='07' > Benue</option>
                      <option value='08' > Borno</option>
                      <option value='09' > Cross River</option>
                      <option value='10' > Delta</option>
                      <option value='11' > Ebonyi</option>
                      <option value='12' > Edo</option>
                      <option value='13' > Ekiti</option>
                      <option value='14' > Enugu</option>
                      <option value='37' > FCT</option>
                      <option value='15' > Gombe</option>
                      <option value='16' > Imo</option>
                      <option value='17' > Jigawa</option>
                      <option value='18' > Kaduna</option>
                      <option value='19' > Kano</option>
                      <option value='20' > Katsina</option>
                      <option value='21' > Kebbi</option>
                      <option value='22' > Kogi</option>
                      <option value='23' > Kwara</option>
                      <option value='24' > Lagos</option>
                      <option value='25' > Nasarawa</option>
                      <option value='26' > Niger</option>
                      <option value='27' > Ogun</option>
                      <option value='28' > Ondo</option>
                      <option value='29' > Osun</option>
                      <option value='30' > Oyo</option>
                      <option value='31' > Plateau</option>
                      <option value='32' > Rivers</option>
                      <option value='33' > Sokoto</option>
                      <option value='34' > Taraba</option>
                      <option value='35' > Yobe</option>
                      <option value='36' > Zamfara</option>
                  </select>
              </div>
              
              <div class="col-sm-2">
                  <select class="form-control select2" id="lga" name="lga">
                      <option value="">--Select LGA--</option>
                  </select>
              </div>
             
              <div class="col-sm-2">
                 
              </div>
              <div class="col-sm-2">
                  <button type="submit" class="btn btn-success pull-right">Search</button>
              </div>
            
          </div>
        </form>

    </div>

</div>
<div class="">
        <h5><p class="text-light-blue">
            @if ($type === 1)
                List of Hospitals and Clinics
            @elseif ($type === 2)
                List of Laboratories
            @elseif($type === 3)
                List of Pharmacies
            @elseif($type === 4)
                List of Radiologies/Imaging facilities
            @endif
        </p></h5> 
    </div>
<div class="box">

  <div class="box-body">
          <table id="hosp" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Unique ID</th>
                <th>Facility Name</th>
                <th>State</th>
                <th>LGA</th>
                @if (($type === 1)||($type === 2))
                    <th>Facility Level</th>
                @endif
               
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
                
                @if (($type === 1)||($type === 2))
                    <td>{{$fac->level}}</td>
                @endif
               
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
        "pageLength": 25,
    } );
  } );
</script>

@endpush