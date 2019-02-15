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
        <th>Published By</th>
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
      <td>
          @if ($r->published_by !="")
            <Strong>Name: </Strong>{{ $r->published_by }} <br>
            <Strong>E-mail: </Strong>{{ $r->published_email }} <br>
            <Strong>Mobile: </Strong>{{ $r->published_mobile }} <br>
            <Strong>Date: </Strong>{{ ($r->published_at? date('d M Y', strtotime($r->validated_at)) : '') }} <br>
            <Strong>Remarks: </Strong>{{ $r->publish_note }} <br>
        @else
            Pending
        @endif
      </td>
        <td>
            @if (in_array($r->status_id,[1,8,15]))
                <span class="label label-info"> {{$r->status}}</span>
            @endif
            @if (in_array($r->status_id,[2,4,6,9,11,13,16,18,20]))
                <span class="label label-success"> {{$r->status}}</span>
            @endif
            @if (in_array($r->status_id,[3,5,7,10,12,14,17,19,21]))
               <span class="label label-danger"> {{$r->status}}</span>
            @endif
        </td>

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
            @if ($r->status_id == 17)
                 <a href="#">
                      <button class="btn btn-warning btn-sm"  type="button"  data-toggle="modal" data-target="#delete_resubmit"
                          data-id_del="{{$r->id}}" data-unique_id_del="{{$r->unique_id}}" data-facility_name_del="{{$r->facility_name}}" data-state_id_del="{{$r->state_id}}"> 
                          Resubmit
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

<!-- Modal delete re submit request -->
<div class="modal fade" id="delete_resubmit" tabindex="-1" role="dialog">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Resubmit Delete Request</h4>
                <div class='notifications top-right'></div>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('myrequest.resubmit')}}">
                    @csrf
                    <input type="hidden" id="facility_id" name="facility_id">
                    <input type="hidden" id="facility_name_to_del" name="facility_name_to_del">
                    <input type="hidden" id="state_id_del" name="state_id_del">
                    <input type="hidden"  name="null">


                    <div class="panel-body">
                        
                        <div class="panel-group" id="accordion_d">
                            {{-- panel one --}}
                            <div class="panel panel-default">
                              
                                <div id="collapse1d" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <div class="row">
                                            <label class="col-md-4">Unique_id:</label>
                                            <div class="col-md-8" id="unique_id_del"></div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-4 text-md-right">Facility Name:</label>
                                            <div class="col-md-8" id="facility_name_del">    </div>
                                        </div>
                                      
                                        <div class="row">
                                            <label class="col-md-4">Reason for Delete:<font color="red">*</font></label>
                                            <div class="col-md-8">
                                                <textarea class="form-control" rows="3" name="reason" placeholder="Please enter reason" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                           
                        </div> 
                        
                    </div>
                    
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Re Submit Request</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
                
            </div><!--modal body ends -->
        </div><!--/.modal-content -->
    </div>
</div> <!--/.modal -->


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
    
      $('#delete_resubmit').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var modal = $(this)
        
            modal.find('.modal-body #unique_id_del').text(button.data('unique_id_del'));
            modal.find('.modal-body #facility_name_del').text(button.data('facility_name_del'));
            modal.find('.modal-body #facility_id').val(button.data('id_del'));   
            modal.find('.modal-body #facility_name_to_del').val(button.data('facility_name_del'));
            modal.find('.modal-body #state_id_del').val(button.data('state_id_del'));
          
        });//end
</script>

@endpush