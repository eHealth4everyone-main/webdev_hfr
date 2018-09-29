@extends("layouts.master")


@section('content-title')
Inbox
@endsection

@section("content")

    
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title"></h3>

              <div class="box-tools pull-right">
                <div class="has-feedback">
                  <input type="text" class="form-control input-sm" placeholder="Search Mail">
                  <span class="glyphicon glyphicon-search form-control-feedback"></span>
                </div>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="mailbox-controls">
               
                
                
                <!-- /.pull-right -->
              </div>
              <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped">
                  <tbody>
                      @foreach($messages as $m)
                        <tr>
                            <td><input type="checkbox"></td>
                            <td class="mailbox-name"><a href="">{{$m->name}}</a></td>
                            <td class="mailbox-name">{{$m->email}}</td>
                            <td class="mailbox-subject"><b>{{$m->subject}}</b> -  {{$truncated = str_limit($m->message, 30, ' ...')}}</td>
                            <td class="mailbox-date">{{$m->created_at}}</td>
                            @php
                             
                              $now = Carbon\Carbon::now();
                         
                            
                            @endphp
                            <td> {{ $now->diffForHumans($m->created_at) }}</td>
                        </tr>
                    
                      @endforeach

                  </tbody>
                </table>
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <div class="row">
                
                    @php
                      $perpage = $messages->perpage();
                      $currentpage = $messages->currentpage();
                      $from = ($currentpage-1)*$perpage+1;
                      
                      if ($messages->currentpage() == $messages->lastpage()) {
                        $to = $messages->total();
                      } else {
                        $to = $currentpage*$perpage;
                      }
                    @endphp
               
                    <div class="col-md-6">
                        Showing {{$from}} to {{$to}} of {{$messages->total()}} entries
                       
                    </div>
                    <div class="col-md-6">
                        <div class="pull-right">
                            {{$messages->links()}}                  
                        </div>
                    </div>

              </div>
            </div>
          </div>
          <!-- /. box -->
 
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