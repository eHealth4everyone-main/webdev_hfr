@extends("layouts.public_master")



@section('content-title')
<div class="container">
  <div class="row">
      <div class="col-md-10">
          <h4><p class="text-light-blue">List of Laboratories</p></h4> 
      </div>
      <div class="col-md-2">
        <a href="">
          <button type="button" class="btn btn-info">Excel</button>
        </a>
        <a href="">
        <button type="button" class="btn btn-primary">PDF</button>
        </a>
    </div>

</div>
</div>
@endsection

@section("content")

<div class="container">
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
    
      <!-- /.box -->
@endsection 

@push('kibiti_scripts')

<script>
    $(document).ready( function () {
      $('#table1').DataTable( {
        "paging":   true,
        "ordering": true,
        "info":     true,
        "lengthChange": true,
        "searching"   : true,
        "autoWidth"   : false
    } );
  } );
</script>

@endpush
