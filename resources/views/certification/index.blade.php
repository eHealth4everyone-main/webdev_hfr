@extends("layouts.master")

@section('content-title')
Laboratory Certification

<!-- Button trigger modal -->
<button type="button" class="btn btn-info pull-right" data-toggle="modal" data-target="#myModal">
  New Certification
</button>  

@endsection

@section("content")
<div class="box">
  <div class="box-body">
    <table id="example1" class="table table-bordered table-striped">
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
          {{-- <td>{{$eq->lc_id}}</td> --}}
          <td>{{$eq->lc_name}}</td>
          <td>
          @if($eq->lc_cert_type==1)
            National
          @else
            International
          @endif
         </td>

          <td>
            <a href="#">
              <button class="btn btn-warning btn-sm" data-id="{{$eq->lab_eq_id}}" data-service="" type="button" data-toggle="modal" data-target="#editModal">Edit</button>
            </a>
            <a href="#">
              <button class="btn btn-danger btn-sm" data-id="{{$eq->lab_eq_id}}" type="button" data-toggle="modal" data-target="#deleteModal" > Delete</button>
            </a>
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