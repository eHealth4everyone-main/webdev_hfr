@extends("layouts.master")

@section('content-title')
My Rejected Requests

@endsection

@section("content")
@if(empty($myrequests))
    <div class="callout callout-success">
        <p>You do not have rejected requests</p>
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
          <th>Verification</th>
          <th>Validation</th>
          <th>Publication</th>
      </tr>
    </thead>
    <tbody>
        @foreach($myrequests as $r)
        <tr>
          <td> {{$r->facility_name}} </td>
          <td><span class="label label-default">{{$r->action}} </span></td>

          <td>
              @if ($r->verified_email != "" )
                @if (in_array($r->status_id,[2,9,16,4,11,18,5,12,19,7,14,21])) 
                  <span class="label label-success"> Accepted </span> <br>
                @endif
                @if (in_array($r->status_id,[3,10,17])) 
                  <span class="label label-danger"> Rejected </span> <br>
                @endif
                <Strong>Remarks: </Strong>{{ $r->verify_note }} <br>
                <Strong>Date: </Strong>{{ ($r->verified_at? date('d M Y', strtotime($r->verified_at)) : '') }} <br>   
                <Strong>By: </Strong>{{$r->verified_by}} <br>
                <Strong>E-mail: </Strong>{{$r->verified_email}} <br>
                <Strong>Mobile: </Strong>{{ $r->verified_mobile }} <br>
              @else
                  Pending Verification
              @endif          
         </td>
         <td>
            @if ($r->validated_email != "" )
                @if (in_array($r->status_id,[4,11,18,7,14,21])) 
                  <span class="label label-success"> Accepted </span> <br>
                @endif
                @if (in_array($r->status_id,[5,12,19])) 
                  <span class="label label-danger"> Rejected </span> <br>
                @endif
                <Strong>Remarks: </Strong>{{ $r->validate_note }} <br>
                <Strong>Date: </Strong>{{ ($r->validated_at? date('d M Y', strtotime($r->validated_at)) : '') }} <br>
                <Strong>By: </Strong>{{$r->validated_by}} <br>
                <Strong>E-mail: </Strong>{{ $r->validated_email }} <br>
                <Strong>Mobile: </Strong>{{ $r->validated_mobile }} <br>
            @else
                Pending Validation
            @endif               
        </td>
        <td>
            @if ($r->published_by !="")
                @if (in_array($r->status_id,[6,13,20])) 
                  <span class="label label-success"> Accepted </span> <br>
                @endif
                @if (in_array($r->status_id,[7,14,21])) 
                  <span class="label label-danger"> Rejected </span> <br>
                @endif
                <Strong>Remarks: </Strong>{{ $r->publish_note }} <br>
                <Strong>Date: </Strong>{{ ($r->published_at? date('d M Y', strtotime($r->validated_at)) : '') }} <br>
                <Strong>By: </Strong>{{ $r->published_by }} <br>
                <Strong>E-mail: </Strong>{{ $r->published_email }} <br>
                <Strong>Mobile: </Strong>{{ $r->published_mobile }} <br>
            @else
                Pending Publication
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
        "paging":   true,
        "ordering": true,
        "info":     true
    } );

  });
</script>

@endpush