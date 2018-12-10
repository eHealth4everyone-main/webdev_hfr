@extends("layouts.master")


@section('content-title')
My Recent Requests

@endsection

@section("content")
@if($myrequests->isEmpty())
    <div class="callout callout-success">
        <p>You do not have recent requests..</p>
  </div>
@endif

@foreach($myrequests as $r)

    <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">
              Facility Name: <span class="label label-default"> {{$r->facility_name}}</span> 
             
              @if ($r->action === "CREATE")
                  Request Type: <span class="label label-info"> {{$r->action}}</span>
              @elseif ($r->action === "UPDATE")
                  Request Type: <span class="label label-primary"> {{$r->action}}</span>
              @else
                  Request Type: <span class="label label-danger"> {{$r->action}}</span>                
              @endif

              @if (($r->status_id === 1) or ($r->status_id ===8))
                Status: <span class="label label-warning"> {{$r->status}}</span> 
              @elseif (($r->status_id === 3) or ($r->status_id ===5) or ($r->status_id ===7) or ($r->status_id===10) or ($r->status_id ===12 or ($r->status_id ===12)))
                Status: <span class="label label-danger"> {{$r->status}}</span> 
              @else
                Status: <span class="label label-success"> {{$r->status}}</span>                 
              @endif
          </h3>
      
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>
          <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                      <th>Action</th>
                      <th>Date</th>
                      <th>Action By</th>
                      <th>Remarks</th>      
                    </tr>
                </thead>
                <tbody>
               
                  @foreach($status as $s)
                  <tr>
                      @if(($r->id == $s->hospital_id) and ($r->action == $s->action_type))
                        <td>{{$s->action}}</td>
                        <td>{{$s->created_at}}</td>
                        <td>
                            <Strong>Name: </Strong>{{$s->user}} <br>
                            <Strong>Position: </Strong>{{$s->position}} <br>
                            <Strong>E-mail: </Strong>{{$s->email}} <br>
                            <Strong>Mobile: </Strong>{{$s->mobile}}
                        </td>
                      <td>{{$s->note}}</td>
                      @endif
                  </tr>
                  @endforeach
                </tbody>
              </table>
        </div>
    </div>

@endforeach


@endsection 


@push('bk_script')
 

  <script>
      $(document).ready( function () {


      });
  </script>

@endpush