@extends("layouts.master")

@section('bk_css')

@endsection

@section('content-title')
Hospitals and Clinics Facilities

    <a href="/sign/create">
        <button type="button" class="btn btn-primary pull-right">
                Add New Hospital
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
                <th>Facility Type</th>
                <th>Ownership</th>
                <th>Actions</th>
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
                <td>
                    <a href="{{route('sign.show',$fac->id)}}">
                          <button class="btn btn-success btn-sm"  type="button">View</button>
                        </a>
                        <a href="{{route('sign.edit',$fac->id)}}">
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
        "autoWidth"   : false,
   
    } );
  } );
</script>

@endpush