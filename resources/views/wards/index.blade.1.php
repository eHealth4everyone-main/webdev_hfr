@extends("layouts.master")


@section('content-title')
Wards	
<a href="">
    <button type="button" class="btn btn-info pull-right">
            Create Ward
    </button>
</a>
@endsection

@section("content")
<div class="box">
        <div class="box-body">  
          <table id="table1" class="table table-bordered table-striped" style="width:100%">
            <thead>
              <tr>
                <th>Ward</th>
                <th>State</th>
                <th>LGA</th>
              </tr>
            </thead>
            <tbody>
           
              @foreach($wards as $ward)
              <tr>
                <td>{{$ward->ward}}</td>
                <td>{{$ward->state}}</td>
                <td>{{$ward->lga}}</td>
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