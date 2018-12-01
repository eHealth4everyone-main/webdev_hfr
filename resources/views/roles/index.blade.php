@extends("layouts.master")

@section('content-title')
User Roles

{{-- <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#createrole">Add Role</button> --}}
<a href="{{route('roles.create')}}">
    <button type="button" class="btn btn-primary pull-right">
            Add Role
    </button>
</a>

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
         
          <td>
            {{-- @if(auth()->user()->hasPermissionTo(21)) --}}
            <a href="#">
              <button class="btn btn-success btn-sm"   type="button" data-toggle="modal" data-target="#showrole"
              data-permissions={{$role->permissions->pluck('name')}}>View</button>
            </a>
            {{-- @endif --}}
            {{-- @if(auth()->user()->hasPermissionTo(22)) --}}
              <a href="{{route('roles.edit',$role->id)}}">
                  <button class="btn btn-warning btn-sm"  type="button" > Edit</button>
              </a>
            {{-- @endif --}}
              
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