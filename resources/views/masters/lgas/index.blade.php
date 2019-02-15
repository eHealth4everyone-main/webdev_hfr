@extends("layouts.master")


@section('content-title')
Local Government Areas (LGAs)	

@if(auth()->user()->hasPermissionTo(52))
    <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#addModal">
      Add LGA
    </button>
@endif

@endsection

@section("content")
<div class="box">
        <div class="box-body">  
          <table id="table1" class="table table-bordered table-striped" style="width:100%">
            <thead>
              <tr>
                <th>State</th>
                <th>LGA ID</th>
                <th>LGA Name</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
           
              @foreach($lgas as $lga)
              <tr>
                <td>{{$lga->state->name}}</td>
                <td>{{$lga->id}}</td>
                <td>{{$lga->name}}</td>
                <td>
                    @if(auth()->user()->hasPermissionTo(53))
                      <a href="#">
                        <button class="btn btn-warning btn-sm" data-id="{{$lga->id}}" data-name="{{$lga->name}}"  type="button" data-toggle="modal" data-target="#editModal">Edit</button>
                      </a>
                    @endif
                    @if(auth()->user()->hasPermissionTo(54))
                      <a href="#">
                        <button class="btn btn-danger btn-sm" data-id="{{$lga->id}}" type="button" data-toggle="modal" data-target="#deleteModal" > Delete</button>
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

@include('masters.lgas.create')


@push("bk_script")
@include('partials.notification')

<script>
    $(document).ready( function () {
      $('#table1').DataTable( {
        "paging":   true,
        "ordering": true,
        "info":     true
    } );
  } );

  $('#editModal').on('show.bs.modal', function (event) {
      $('#name1').focus();

      var button = $(event.relatedTarget)

      var modal = $(this)
      
      modal.find('.modal-body #id').val(button.data('id'))
      modal.find('.modal-body #name1').val(button.data('name'))
      modal.find('.modal-body #short_code1').val(button.data('code'))

    });
    
    $('#deleteModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) 
      
      var id = button.data('id')
      var modal = $(this)
      modal.find('.modal-body #state_id').val(id)
    })


</script>
@endpush