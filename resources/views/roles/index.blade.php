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
          <th>Role Name</th>
          <th>Description</th>
          {{-- <th>Permissions</th> --}}
          <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($roles as $role)
        <tr>
            <td>{{$role->name}}</td>
            <td>{{$role->description}}</td>
            {{-- <td>{{$role->permissions->implode('name', ', ')}} </td> --}}
            <td>
              @if(auth()->user()->hasPermissionTo(21))
                <a href="#">
                  <button class="btn btn-success btn-sm"   type="button" data-toggle="modal" data-target="#showrole"
                  data-permissions={{$role->permissions->pluck('name')}}>View</button>
                </a>
              @endif
              @if(auth()->user()->hasPermissionTo(22))
                  <a href="#">
                    <button class="btn btn-warning btn-sm"  type="button" data-toggle="modal" data-roleid={{$role->id}} 
                        data-name={{$role->name}} data-descr={{$role->description}} data-permissions={{$role->permissions->pluck('name')}} data-target="#editrole">Edit</button>
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
@include('roles.show')

@push("bk_script")
@include('partials.notification')

<script>
 $(document).ready(function(){
    $('#table1').DataTable( {
        "paging":   true,
        "ordering": true,
        "info":     true
    } );

  
    $('#perm').multiselect({
            enableClickableOptGroups: true,
            enableCollapsibleOptGroups: true,
            enableFiltering: true,
            includeSelectAllOption: true,
            maxHeight: 300
    });
    $('#perm1').multiselect({
            enableClickableOptGroups: true,
            enableCollapsibleOptGroups: true,
            enableFiltering: true,
            includeSelectAllOption: true,
            maxHeight: 300
    });

    //edit role
    $('#editrole').on('show.bs.modal', function (event) {
            var modal = $(this)      
            var button = $(event.relatedTarget) 

            var id=button.data('roleid') 
            var name=button.data('name')  
            var descr=button.data('descr')
            var permissions= button.data('permissions')  

            modal.find('.modal-body #role1').val(name);
            modal.find('.modal-body #descr1').val(descr);
            modal.find('.modal-body #RoleID').val(id);
            modal.find('.modal-body #perm1').val(permissions).change();
    });//end edit
 
 //show role
    $('#showrole').on('show.bs.modal', function (event) {
            var modal = $(this)      
            var button = $(event.relatedTarget) 
            var permissions= button.data('permissions')  
            
            $( "#perms" ).text();        

            jQuery.each( permissions, function( i, val ) {
              
              $( "#perms" ).append('<span class="label label-default">'+ val +'</span> &nbsp');
              // //list 5 elements then break
              // if (i > 1 && (i % 5 === 0)) {
              //   $( "#perms" ).append('<p>');                
              // }
            });
    });//end edit


  });
</script>

@endpush