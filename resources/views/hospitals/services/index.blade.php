@extends("layouts.master")

@section('content-title')
Hospital Services


@endsection

@section("content")
<div class="box">
  <div class="box-body">
    <table id="table1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Service Category</th>
          <th>Service</th>
        </tr>
      </thead>
      <tbody>
        
        @foreach($services as $service)
        <tr>
          <td>{{$service->description}}</td>
          <td>{{$service->name}}</td>
    
        </tr>
        @endforeach
        
      </tbody>
    </table>
    
  </div>
  <!-- /.box-body -->
</div>
<!-- /.box -->
@endsection 


@push('bk_script')


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