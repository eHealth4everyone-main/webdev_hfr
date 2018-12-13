@extends("layouts.master")


@section('content-title')
Updated Fields (On Progress..)

@endsection

@section("content")

    <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"></h3>
        
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
                              <th>Field</th>
                              <th>Old Value</th>
                              <th>New Value</th>     
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($audits as $attr=>$audit)
                            <tr>                   
                                <td>{{array_search($attr,$lookup)}}</td>
                                <td>{{$audit['old']}}</td>
                                <td>{{$audit['new']}}</td>
                            </tr>
                          @endforeach
                        </tbody>
                </table>
        </div>
    </div>




@endsection 


@push('bk_script')
 

  <script>
      $(document).ready( function () {


      });
  </script>

@endpush