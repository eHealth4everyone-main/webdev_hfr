@extends("layouts.pub.master")

@section('custom_css')

@endsection

@section('content-title')
       
  
@endsection

@section("content")   

<div class="">
     
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

@push('custom_scripts')
@include('partials.dynamic_lgas_only')

<script>
    $(document).ready( function () {
      $('#hosp').DataTable( {
        "paging":   true,
        "ordering": true,
        "info":     true,
        "lengthChange": false,
        "searching"   : false,
        "autoWidth"   : false,
        "pageLength": 25,
    } );
  } );
</script>

@endpush