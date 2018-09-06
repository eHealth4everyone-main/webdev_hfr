@extends("layouts.master")

@section('content-title')
    User Roles

    <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#createrole">Add Role</button>
   
@endsection

@section("content")
<div class="box">
      <div class="box-body">
          {{-- {{auth()->user()->getRoleNames()}}<br>
         
          {{auth()->user()->hasPermissionTo(5)}} --}}
         
      <table id="table1" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th>SN</th>
          <th>Name</th>
          <th>Permissions</th>
          <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($roles as $role)
        <tr>
            <td>{{$role->id}}</td>
            <td>{{$role->name}}</td>
            <td>{{$role->permissions->implode('name', ', ')}} </td>
            <td>
              @if(auth()->user()->hasPermissionTo(35))
                <a href="#">
                  <button class="btn btn-success btn-sm"  type="button">View</button>
                </a>
              @endif
              @if(auth()->user()->hasPermissionTo(36))
                  <a href="#">
                    <button class="btn btn-warning btn-sm"  type="button"data-toggle="modal" data-roleid={{$role->id}} 
                        data-name={{$role->name}} data-permissions={{$role->permissions->pluck('name')}} data-target="#editrole">Edit</button>
                  </a>
              @endif
             
            </td>
        </tr>
        </tr>
        @endforeach
    
        </tbody>
      </table>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
@endsection 

@include('roles.create')
@include('roles.edit')

@push("bk_script")
@include('partials.notification')

<script>
 $(document).ready(function(){
    $('#table1').DataTable( {
        "paging":   true,
        "ordering": true,
        "info":     true
    } );
    
   
    //edit role
    $('#editrole').on('show.bs.modal', function (event) {
            var modal = $(this)      
            var button = $(event.relatedTarget) 

            var id=button.data('roleid') 
            var name=button.data('name')  
            var permissions= button.data('permissions')  

            modal.find('.modal-body #role1').val(name);
            modal.find('.modal-body #RoleID').val(id);
            modal.find('.modal-body #perm1').val(permissions).change();
          });//end edit

  });
</script>

@endpush