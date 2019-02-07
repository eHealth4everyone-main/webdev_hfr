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

<div class="box-body">
  <table id="table1" class="table table-bordered table-striped" style="width:100%">
    <thead>
      <tr>
        <th>Facility Name</th>
        <th>Request Type</th>
        <th>Verified By</th>
        <th>Validated By</th>
        <th>Status</th>
       
        @foreach ($myrequests as $r)
            @if (in_array($r->status_id,[1,3,8,10]))
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
        <td>
            @if ($r->verified_email != "" )
              <Strong>Name: </Strong>{{$r->verified_by}} <br>
              <Strong>E-mail: </Strong>{{$r->verified_email}} <br>
              <Strong>Mobile: </Strong>{{ $r->verified_mobile }} <br>
              <Strong>Remarks: </Strong>{{ $r->verify_note }} <br>
              <Strong>Date: </Strong>{{ ($r->verified_at? date('d M Y', strtotime($r->verified_at)) : '') }} <br>   
            @else
                Pending
            @endif
                       
        </td>
        <td>
            @if ($r->validated_email != "" )
                <Strong>Name: </Strong>{{$r->validated_by}} <br>
                <Strong>E-mail: </Strong>{{ $r->validated_email }} <br>
                <Strong>Mobile: </Strong>{{ $r->validated_mobile }} <br>
                <Strong>Date: </Strong>{{ ($r->validated_at? date('d M Y', strtotime($r->validated_at)) : '') }} <br>
                <Strong>Remarks: </Strong>{{ $r->validate_note }} <br>
            @else
                Pending
            @endif              
      </td>
    
        <td>{{$r->status}}</td>

          <td>
            @if (in_array($r->status_id,[1,3,8,10]))
                <a href="{{ route('myrequest.edit',$r->id) }}">
                    <button class="btn btn-warning btn-sm"  type="button" >Update Request</button>
                </a>
                <a href="#">
                    <button class="btn btn-danger btn-sm"  type="button"  data-toggle="modal" data-target="#delete"
                      data-id="{{$r->id}}" data-status="{{$r->status_id}}"> 
                      Delete Request
                  </button>
                </a>
            @endif

            @if (in_array($r->status_id,[15,17]))
                <a href="#">
                    <button class="btn btn-danger btn-sm"  type="button"  data-toggle="modal" data-target="#delete"
                      data-id="{{$r->id}}" data-status="{{$r->status_id}}"> 
                      Delete Request
                  </button>
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

 
<!-- Modal delete record -->
<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
       
      <form action="{{route('myrequest.delete')}}" method="POST">
          @csrf

          <div class="modal-body">
              <p class="text-center">
                Are you sure you want to delete this request?
              </p>
                <input type="hidden" id="hosp_id" name="hosp_id" >  
                <input type="hidden" id="status_id" name="status_id" >  
                <input type="hidden" id="null" name="null" >   

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">No</button>
            <button type="submit" class="btn btn-warning btn-sm">Yes</button>
          </div>
        </form>
        
      </div>
    </div>
</div> 
  

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

<script>
   //delete modal
   $('#delete').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) 
       
        var modal = $(this)
        modal.find('.modal-body #hosp_id').val(button.data('id'));
        modal.find('.modal-body #status_id').val(button.data('status'));
    })//end
      
</script>

@endpush