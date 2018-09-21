@extends("layouts.public_master")



@section('content-title')

@endsection

@section("content")
<div class="box">
  <div class="box-body">

          <table id="table1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Unique ID</th>
                <th>Facility Name</th>
                <th>State</th>
                <th>LGA</th>
                <th>Facility level</th>
                <th>Ownership</th>
              
              </tr>
            </thead>
            <tbody>
           
              @foreach($labs as $lab)
              <tr>
                <td>{{$lab->sig_unique_id}}</td>
                <td>{{$lab->reg_fac_name}}</td>
                <td>{{$lab->state}}</td>
                <td>{{$lab->lga}}</td>
                <td>{{$lab->level}}</td>
                <td>{{$lab->ownership}}</td>
       
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
      $('#table1').DataTable( {
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
