@extends("layouts.public_master")

@section('kibiti_css')

@endsection

@section('content-title')
  <h4><p class="text-light-blue">List of Hospitals and Clinics</p></h4>       

@endsection

@section("content")   
<div class="box">
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
                <td>{{$fac->sig_unique_id}}</td>
                <td>{{$fac->reg_fac_name}}</td>
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

<script>
    $(document).ready( function () {
      $('#hosp').DataTable( {
        "paging":   true,
        "ordering": true,
        "info":     true,
        "lengthChange": false,
        "searching"   : true,
        "autoWidth"   : false,
        "pageLength": 40,
    } );
  } );
</script>

@endpush