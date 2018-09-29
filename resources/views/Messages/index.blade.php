@extends("layouts.master")


@section('content-title')


@endsection

@section("content")

    
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Inbox</h3>

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
                        </tr>
                    
                      @endforeach

                  </tbody>
                </table>
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer no-padding">
              <div class="mailbox-controls">
              
                <div class="pull-right">
                  1-50/200
                  <div class="btn-group">
                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
                  </div>
                  <!-- /.btn-group -->
                </div>
                <!-- /.pull-right -->
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