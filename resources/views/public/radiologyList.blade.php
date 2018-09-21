@extends("layouts.public_master")


@section('content-title')
       <h4>
        <p class="text-light-blue">List of Radiological and Imaging</p>
      </h4>
@endsection

@section("content")
<div class="box">
        <div class="box-body">
         
      <table id="table1" class="table display" style="width:100%">
            <thead>
              <tr>
                <th>Unique ID</th>
                <th>Facility Name</th>
                <th>State</th>
                <th>LGA</th>
                <th>Ownership</th>
                <th>Category</th>
              
              </tr>
            </thead>
            <tbody>
           
              @foreach($imagings as $im)
              <tr>
                <td>{{$im->unique_id}}</td>
                <td>{{$im->fac_name}}</td>
                <td>{{$im->state}}</td>
                <td>{{$im->lga}}</td>
                <td>{{$im->ownership}}</td>
                @if ($im->category == 1)
                    <td>Standalone</td>
                 @else
                    <td>Institution</td>
                 @endif
       
              </tr>
              @endforeach
              
            </tbody>
          </table>
      
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
@endsection 


@push("kibiti_scripts")
<script>
  $(document).ready( function () {
    $('#table1').DataTable( {
      "paging":   true,
      "ordering": true,
      "info":     true,
      "pageLength": 40,
    } );
  } );
</script>
@endpush