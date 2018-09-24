@extends("layouts.master")


@section('content-title')
Radiological Premises

    <a href="/imaging/create">
        <button type="button" class="btn btn-primary pull-right">
                Add Radiological Facility
        </button>
    </a>
@endsection

@section("content")
<div class="box">
        <div class="box-body">
         
      <table id="table1" class="table table-bordered table-striped" style="width:100%">
            <thead>
              <tr>
                <th>Unique ID</th>
                <th>Facility Name</th>
                <th>State</th>
                <th>LGA</th>
                <th>Ownership</th>
                <th>Category</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
           
              @foreach($imagings as $im)
              <tr>
                <td>{{$im->unique_id}}</td>
                <td>{{$im->facility_name}}</td>
                <td>{{$im->state}}</td>
                <td>{{$im->lga}}</td>
                <td>{{$im->ownership}}</td>
                @if ($im->category == 1)
                    <td>Standalone</td>
                 @else
                    <td>Institution</td>
                 @endif
                <td>
                        <a href="{{route('imaging.show',$im->id)}}">
                          <button class="btn btn-success btn-sm"  type="button">View</button>
                        </a>
                        <a href="{{route('imaging.edit',$im->id)}}">
                          <button class="btn btn-warning btn-sm"  type="button" >Edit</button>
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


@push("bk_script")
<script>
  $(document).ready( function () {
    $('#table1').DataTable( {
      "paging":   true,
      "ordering": true,
      "info":     true
    } );
  } );
</script>
@endpush