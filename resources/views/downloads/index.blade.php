@extends("layouts.master")


@section('content-title')
Guest Data Downloads


@endsection

@section("content")
<div class="box">
  <div class="box-body">
    
    <table id="table1" class="table table-bordered table-striped" style="width:100%">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Organisation</th>
          <th>Designation</th>
          <th>Country</th>
          <th>Purpose of Data</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
        
        @foreach($downloads as $d)
        <tr>
          <td>{{$d->firstname}} {{$d->lastname}}</td>
          <td>{{$d->email}}</td>
          <td>{{$d->organisation}}</td>
          <td>{{$d->designation}}</td>
          <td>{{$d->country}}</td>
          <td>{{$d->purpose}}</td>
          <td>{{$d->created_at}}</td>
        </tr>
        @endforeach
      </tbody>

      <tfoot>
    
      </tfoot>
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