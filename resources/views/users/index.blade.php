@extends("layouts.master")

@section('content-title')
Users

<button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#register">Register User</button>


@endsection

@section("content")
<div class="box">
  {{-- <div class="box-header">
    <h3 class="box-title">Users</h3>
  </div> --}}
  <!-- /.box-header -->
 
  <div class="box-body">
    <table id="table1" class="table table-bordered table-striped" style="width:100%">
      <thead>
        <tr>
          <th>Firstname</th>
          <th>Lastname</th>
          <th>Username</th>
          <th>E-mail</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($users as $user)
        <tr>
          <td>{{$user->firstname}}</td>
          <td>{{$user->lastname}}</td>
          <td>{{$user->username}}</td>
          <td>{{$user->email}}</td>
          <td>{{$user->status}}</td>
          <td>
            <a href="#">
              <button class="btn btn-success btn-sm" data-fname="{{$user->firstname}}" data-lname="{{$user->lastname}}"
                  data-username="{{$user->username}}" data-email="{{$user->email}}" data-role="{{$user->getRoleNames()}}"
                   data-job="{{$user->job_title}}" data-org="{{$user->organisation}}"
                   type="button" data-toggle="modal" data-target="#view">View</button>
            </a>
            <a href="#">
              <button class="btn btn-warning btn-sm" data-fname="{{$user->firstname}}" data-lname="{{$user->lastname}}"
                  data-username="{{$user->username}}" data-email="{{$user->email}}" data-id="{{$user->id}}" data-role="{{$user->getRoleNames()}}"
                   data-job="{{$user->job_title}}" data-org="{{$user->organisation}}"
                   type="button" data-toggle="modal" data-target="#editUser">Edit</button>
            </a>
            
              @if ($user->status === "Active")
                <a href="#">
                  <button class="btn btn-danger btn-sm"  type="button" data-toggle="modal" data-target="#disableUser" data-id="{{$user->id}}" data-status="{{$user->status}}">Deactive</button>
                </a>
              @endif
              @if ($user->status === "De-Activated")
              <a href="#">
                <button class="btn btn-primary btn-sm"  type="button" data-toggle="modal" data-target="#disableUser" data-id="{{$user->id}}" data-status="{{$user->status}}">Activate</button>
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
  
@include('users.adduser')
@include('users.edituser')
@include('users.delete')
@include('users.show') 
  
@endsection 
  
@push("bk_script")

@include('partials.notification')

<script>
  $(document).ready(function(){
    $('#table1').DataTable( {
        "paging":   true,
        "ordering": true,
        "info":     true
    } );
  
 
      //edit user
      $('#editUser').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var fname = button.data('fname')
        var lname=button.data('lname')
        var username=button.data('username')
        var email=button.data('email')
        var job=button.data('job') 
        var org=button.data('org')   
        var role=button.data('role')  
        var id=button.data('id')    
        var modal = $(this)
   
        modal.find('.modal-body #firstname1').val(fname);
        modal.find('.modal-body #lastname1').val(lname);
        modal.find('.modal-body #username1').val(username);
        modal.find('.modal-body #email1').val(email);
        modal.find('.modal-body #job1').val(job);
        modal.find('.modal-body #organisation1').val(org);
        modal.find('.modal-body #role1').val(role).change();
        modal.find('.modal-body #UserID').val(id);
      });//end edit



      //delete
      $('#disableUser').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) 
      var id = button.data('id')
      var status=button.data('status')
      var modal = $(this)
      modal.find('.modal-body #userid').val(id)
      modal.find('.modal-body #status').val(status)
      })//end

      //view user
    $('#view').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var fname = button.data('fname')
      var lname=button.data('lname')
      var username=button.data('username')
      var email=button.data('email')
      var role=button.data('role')
      var job=button.data('job') 
      var org=button.data('org')      
      var modal = $(this)
   
      modal.find('.modal-body #firstname').text(fname);
      modal.find('.modal-body #lastname').text(lname);
      modal.find('.modal-body #username').text(username);
      modal.find('.modal-body #email').text(email);
      modal.find('.modal-body #job').text(job);
      modal.find('.modal-body #organisation').text(org);
      modal.find('.modal-body #userrole').text(role);
    });//end


  });
</script>

@endpush