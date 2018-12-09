@extends("layouts.master")


@section('content-title')
My Recent Requests

@endsection

@section("content")

@foreach($myrequests as $r)

    <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">
            Facility Name: <span class="label label-default"> {{$r->facility_name}}</span> 
            Request Type: <span class="label label-default"> {{$r->action}}</span> 
            Status: <span class="label label-default"> {{$r->status}}</span> 
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