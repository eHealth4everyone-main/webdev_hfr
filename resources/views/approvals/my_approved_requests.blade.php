@extends("layouts.master")

@section('content-title')
My Approved Requests

@endsection

@section("content")
@if(empty($myrequests))
    <div class="callout callout-success">
        <p>You do not have approved requests</p>
  </div>
@endif



@if(!empty($myrequests))

<div class="box">
  {{-- <div class="box-header">
    <h3 class="box-title">Users</h3>
  </div> --}}
  <!-- /.box-header -->
<div class="box-body">
  <table id="table1" class="table table-bordered table-striped" style="width:100%">
    <thead>
      <tr>
          <th>Facility Name</th>
          <th>Request Type</th>
          <th>Request Date</th>
          <th>Status</th>
          <th>Published By</th>
          <th>Published Date</th>
      </tr>
    </thead>
    <tbody>
        @foreach($myrequests as $r)
        <tr>
          <td>{{$r->facility_name}}</td>
          <td>{{$r->action}}</td>
          <td>{{$r->created_at}}</td>
          <td>{{$r->status}}</td>
  
          @foreach($status as $s)
            @if(($r->id == $s->hospital_id) and ($r->status_id == $s->status_id))
                
                  <td>
                      <Strong>Name: </Strong>{{$s->user}} <br>
                      <Strong>E-mail: </Strong>{{$s->email}} <br>
                      <Strong>Mobile: </Strong>{{ $s->mobile }} <br>
                      <Strong>Remarks: </Strong>{{ $s->note }} <br>
                  </td>
                  <td>{{$s->created_at}}</td>
              
            @endif
          @endforeach
    
          </tr>
          @endforeach
        
      </tbody>
    </table>
    
  </div>
  <!-- /.box-body -->
</div>
<!-- /.box -->
@endif

 
  

@endsection 
  
@push("bk_script")

@include('partials.notification')


<script>
  $(document).ready(function(){
    $('#table1').DataTable( {
        "paging":   false,
        "ordering": true,
        "info":     true
    } );
  
     


  });
</script>

@endpush