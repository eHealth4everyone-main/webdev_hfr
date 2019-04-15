@extends("layouts.master")


@section('content-title')
DHIS2 Data Exchange Log

@endsection

@section("content")
<div class="box">
  <div class="box-body">
    
    <table id="table1" class="table table-bordered table-striped" style="width:100%">
      <thead>
        <tr>
          <th>ID</th>
          <th>HFR ID</th>
          <th>DHIS UID</th>
          <th>Facility</th>
          <th>Ownership</th>
          <th>Level of Care </th>
          <th>Level of Care Option</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
        
        @foreach($logs as $log)
        <tr>
          <td>{{ $log->id }}</td>
          <td>{{$log->hfr_id}} </td>
          <td>{{$log->dhis_uid}}</td>
          <td>{{$log->facility_status}}</td>
          <td>{{$log->ownership_status}}</td>
          <td>{{$log->level_status}}</td>
          <td>{{$log->level_option_status}}</td>
          <td> {{ Carbon\Carbon::parse($log->created_at)->toFormattedDateString() }}</td>
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
        "info":     true,
        responsive: true,
        "order": [[ 0, "desc" ]],
        "columnDefs": [
              {
                  "targets": [ 0 ],
                  "visible": false
              }
          ]

      } );
  } );
</script>
@endpush