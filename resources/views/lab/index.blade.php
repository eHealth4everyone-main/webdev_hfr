@extends("layouts.master")


@section('content-title')
Laboratory Premises

    <a href="/lab/create">
        <button type="button" class="btn btn-primary pull-right">
                Add New Laboratory
        </button>
    </a>
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
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
           
              @foreach($labs as $lab)
              <tr>
                <td>{{$lab->unique_id}}</td>
                <td>{{$lab->facility_name}}</td>
                <td>{{$lab->state}}</td>
                <td>{{$lab->lga}}</td>
                <td>{{$lab->level}}</td>
                <td>{{$lab->ownership}}</td>
                <td>
                        <a href="{{route('lab.show',$lab->id)}}">
                            <button class="btn btn-success btn-sm"  type="button">View</button>
                        </a>
                        <a href="{{route('lab.edit',$lab->id)}}">
                            <button class="btn btn-warning btn-sm"  type="button" > Edit</button>
                        </a>
                      </td>
              </tr>
              @endforeach
              
            </tbody>
          </table>
          

        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
@endsection 

@push('bk_script')

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
