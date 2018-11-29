@extends("layouts.master")

@section('content-title')
Imaging Services

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#myModal">
  Add Service
</button>

@endsection

@section("content")
<div class="box">
  <div class="box-body">
    <table id="table1" class="table table-striped table-bordered" style="width:100%">
      <thead>
        <tr>
          <th>Service name</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        
        @foreach($services as $service)
        <tr>
          <td>{{$service->name}}</td>
          
          <td>
            <a href="#">
              <button class="btn btn-warning btn-sm" data-id="{{$service->id}}" data-service="{{$service->name}}" type="button" data-toggle="modal" data-target="#editModal">Edit</button>
            </a>
            <a href="#">
              <button class="btn btn-danger btn-sm" data-id="{{$service->id}}" type="button" data-toggle="modal" data-target="#deleteModal" > Delete</button>
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


@include('imaging.service.create')
@include('imaging.service.edit')
@include('imaging.service.delete')

@push('bk_script')
@include('partials.notification_md')

<script>
  $(document).ready(function(){
    $('#table1').DataTable( {
      "paging":   true,
      "ordering": true,
      "info":     true
    } );

    $("#save").click(function(){
      var _token = $('input[name="_token"]').val();
      $( '#service-error' ).html( "" );

      $.ajax({
        url: "{{route('service.store')}}",
        method: 'post',
        data: {service: $('#service').val(), _token:_token },
        
        success: function(result){
          if(result.errors){
                if(result.errors.service){
                    $( '#service-error' ).html(result.errors.service[0]);
                }
          }

          if(result.success){
            $.notify({
              message: result.success
            },{
              type: 'success',
              delay: 1000,
              offset:{
                  y:60,
                  x:20
              },
           });
           $('#myModal').modal('hide');
          }
         

          },


        });
      });

   $('#editModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      
      var id = button.data('id')
      var service=button.data('service')
      
      var modal = $(this)
      
      modal.find('.modal-body #service').val(service)
      modal.find('.modal-body #id').val(id)
    });
    
    $('#deleteModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) 
      
      var id = button.data('id')
      var modal = $(this)
      modal.find('.modal-body #id').val(id)
    })

  });

  </script>
@endpush