@extends("layouts.master")


@section('content-title')
States

@endsection

@section("content")
<div class="box">
        <div class="box-body">  
          <table id="table1" class="table table-bordered table-striped" style="width:100%">
            <thead>
              <tr>
                <th>State ID</th>
                <th>State Code</th>
                <th>State </th>
              </tr>
            </thead>
            <tbody>
           
              @foreach($states as $st)
              <tr>
                <td>{{$st->state_id}}</td>
                <td>{{$st->state}}</td>
                <td>{{$st->code}}</td>
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