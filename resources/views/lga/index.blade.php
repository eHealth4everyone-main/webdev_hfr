@extends("layouts.master")


@section('content-title')
Local Government Areas (LGAs)	


@endsection

@section("content")
<div class="box">
        <div class="box-body">  
          <table id="table1" class="table table-bordered table-striped" style="width:100%">
            <thead>
              <tr>
                <th>State</th>
                <th>LGA ID</th>
                <th>LGA Name</th>
              </tr>
            </thead>
            <tbody>
           
              @foreach($lgas as $lga)
              <tr>
                <td>{{$lga->state}}</td>
                <td>{{$lga->lgaid}}</td>
                <td>{{$lga->lga}}</td>
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