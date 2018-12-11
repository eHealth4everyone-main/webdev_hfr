@extends("layouts.master")

@section('content-title')
Laboratory Certification

@if(auth()->user()->hasPermissionTo(44))
  <button type="button" class="btn btn-info pull-right" data-toggle="modal" data-target="#myModal">
    New Certification
  </button>  
@endif

@endsection

@section("content")
<div class="box">
  <div class="box-body">
    <table id="example1" class="table table-bordered table-striped" style="width:100%">
      <thead>
        <tr>
          {{-- <th>ID</th> --}}
          <th>Certificate</th>
          <th>Certificate Type</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        
        @foreach($cert as $eq)
        <tr>
          <td>{{$eq->name}}</td>
          <td>{{$eq->type}}</td>

          <td>
              @if(auth()->user()->hasPermissionTo(45))
                <a href="#">
                  <button class="btn btn-warning btn-sm" data-id="{{$eq->id}}" data-service="" type="button" data-toggle="modal" data-target="#editModal">Edit</button>
                </a>
              @endif
              @if(auth()->user()->hasPermissionTo(46))
                <a href="#">
                  <button class="btn btn-danger btn-sm" data-id="{{$eq->id}}" type="button" data-toggle="modal" data-target="#deleteModal" > Delete</button>
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
@endsection 
@section('bk_script')
<script>

</script>
@endsection