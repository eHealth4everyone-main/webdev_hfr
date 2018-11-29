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
                <th>Name</th>
                <th>Code </th>
              </tr>
            </thead>
            <tbody>
           
              @foreach($states as $st)
              <tr>
                <td>{{$st->id}}</td>
                <td>{{$st->name}}</td>
                <td>{{$st->short_code}}</td>
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