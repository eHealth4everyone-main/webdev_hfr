@extends("layouts.master")

@section('content-title')
My Pending Requests

@endsection

@section("content")
@if(empty($myrequests))
    <div class="callout callout-success">
        <p>You do not have pending requests</p>
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
        <th>Reviewed By</th>
        <th>Status</th>
       
        @foreach ($myrequests as $r)
            @if (in_array($r->status_id,[3,10]))
              <th>Actions</th>
            @endif
            @break
        @endforeach

      </tr>
    </thead>
    <tbody>
      @foreach($myrequests as $r)
      <tr>
        <td>{{$r->facility_name}}</td>
        <td>{{$r->action}}</td>
        <td>{{$r->created_at}}</td>
        <td>
            @foreach($status as $s)
              @if(($r->id == $s->hospital_id) and ($r->status_id == $s->status_id))
              
                  @if (!in_array($s->status_id,[1,8,15])) 
                        <Strong>Name: </Strong>{{$s->user}} <br>
                        <Strong>E-mail: </Strong>{{$s->email}} <br>
                        <Strong>Mobile: </Strong>{{ $s->mobile }} <br>
                        <Strong>Remarks: </Strong>{{ $s->note }} <br>
                      
                      @break
                  @endif
              
              @endif
            @endforeach
        </td>
        <td>{{$r->status}}</td>

          <td>
            @if (in_array($r->status_id,[3,10]))
              <a href="{{ route('myrequest.edit',$r->id) }}">
                  <button class="btn btn-warning btn-sm"  type="button" >Update Request</button>
              </a>
              <a href="{{route('myrequest.delete',$r->id)}}">
                  <button class="btn btn-danger btn-sm"  type="button" >Delete Request</button>
              </a>
            @endif
    
          </td>
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