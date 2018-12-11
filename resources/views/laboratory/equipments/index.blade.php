@extends("layouts.master")

@section('content-title')
Laboratory Equipments

@if(auth()->user()->hasPermissionTo(40))
  <button type="button" class="btn btn-info pull-right" data-toggle="modal" data-target="#myModal">
    New Equipment
  </button>  
@endif

@endsection

@section("content")
<div class="box">
  <div class="box-body">
    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Equipment</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        
        @foreach($equip as $eq)
        <tr>
          <td>{{$eq->id}}</td>
          <td>{{$eq->name}}</td>
          <td>
              @if(auth()->user()->hasPermissionTo(41))
                <a href="#">
                  <button class="btn btn-warning btn-sm" data-id="{{$eq->id}}" data-service="" type="button" data-toggle="modal" data-target="#editModal">Edit</button>
                </a>
              @endif
              @if(auth()->user()->hasPermissionTo(42))
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
  $('#editModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    
    var id = button.data('id')
    var service=button.data('service')

    var modal = $(this)
    
    modal.find('.modal-body #service').val(service)
    modal.find('.modal-body #id').val(id)
  })

  $('#deleteModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    
    var id = button.data('id')
    var modal = $(this)
    modal.find('.modal-body #id').val(id)
  })
</script>
@endsection