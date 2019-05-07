@extends("layouts.master")

@section('content-title')
Users
@if(auth()->user()->hasPermissionTo(18))
  <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#register">Register User</button>
@endif

@endsection

@section("content")

<div class="box box-default ">
    <div class="box-header with-border">
      <h3 class="box-title">Search</h3>
  
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
      </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="box-header with-border">
            <form class="form-horizontal"  action="{{route('users.search')}}" method="GET">
                @csrf
                
            <div class="form-group">
                  <label class="col-sm-2 control-label">State Permission:</label>
                  <div class="col-md-2">
                          <select class="form-control select2"  class="form-control" id="state" name="state"  required data-width="100%">
                              @if (Auth::user()->state_id == 1 )
                                  <option value="1">All States</option>    
                              @endif
                                  @foreach(getAssignedState() as $s)
                                      <option value="{{$s->id}}">{{$s->name}}</option>
                                  @endforeach
                          </select>
                  </div>
                  <label class="col-sm-1 control-label">Role :</label>
                  <div class="col-md-3">
                          <select class="form-control select2"  class="form-control" id="role_id" name="role_id"   data-width="100%">
                              <option value="0">--Select Role--</option>  
                                  @foreach(getRoles() as $s)
                                      <option value="{{$s->id}}">{{$s->name}}</option>
                                  @endforeach
                          </select>
                  </div>
                  <label class="col-sm-1 control-label">Status :</label>
                  <div class="col-md-2">
                          <select class="form-control select2"  class="form-control" id="status" name="status"   data-width="100%">
                              <option value="">--Select Status--</option>  
                              <option value="-1">In Active</option>    
                              <option value="1">Active</option>     
                              <option value="0">Blocked</option>                              
                          </select>
                  </div>
  
                  <div class="col-sm-1">
                          <button type="submit" class="btn btn-success pull-right  btn-block btn-sm">Search</button>
                  </div> 
              </div>
    
            </form>
        </div>
            
    </div>
    
  </div>


<div class="box">

  <div class="box-body">
   

    <table id="table1" class="table table-bordered table-striped" style="width:100%">
      <thead>
        <tr>
          <th>Name</th>
          <th>E-mail</th>
          <th>Mobile</th>
          <th>Role</th>
          <th>State Permission</th>
          <th>LGA Permission</th>
          <th>Status</th>
          <th>Organisation</th>    
          <th>Position</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($users as $user)
        <tr>
          <td>{{$user->firstname}} {{$user->lastname}}</td>
          <td>{{$user->email}}</td>
          <td>{{$user->mobile}}</td>
          <td>{{ implode(", ", $user->getRoleNames()->toArray()) }}</td>
          <td>
              @if ($user->state_id == 1)
                  All States
              @else
                  {{ $user->state->name}}
              @endif
          </td>
          <td>
              @if ($user->lga_id == 1)
                  All LGAs
              @else
                  {{ $user->lga->name}}
              @endif
          </td>
          <td>
              @if ($user->status == 1)
                <span class="label label-success"> Active</span>
              @endif
              @if ($user->status == 0)
                <span class="label label-danger"> Blocked</span>
              @endif
              @if ($user->status == -1)
                <span class="label label-default"> Inactive</span>
              @endif
          </td>
          <td>{{$user->organisation}}</td>
          <td>{{$user->job_title}}</td>
          <td>
    
            @if(auth()->user()->hasPermissionTo(19))
              <a href="#">
                <button class="btn btn-warning btn-sm" data-fname="{{$user->firstname}}" data-lname="{{$user->lastname}}"
                    data-username="{{$user->username}}" data-email="{{$user->email}}" data-id="{{$user->id}}" data-role="{{ implode(", ", $user->getRoleNames()->toArray()) }}"
                    data-job="{{$user->job_title}}" data-org="{{$user->organisation}}" data-mobile="{{$user->mobile}}" data-state_id="{{$user->state_id}}" data-lga_id="{{$user->lga_id}}"
                    type="button" data-toggle="modal" data-target="#editUser">Edit</button>
              </a>
            @endif
            @if(auth()->user()->hasPermissionTo(20))
                @if ($user->status == 1)
                  <a href="#">
                    <button class="btn btn-danger btn-sm"  type="button" data-toggle="modal" data-target="#disableUser" data-id="{{$user->id}}" data-status="{{$user->status}}"  data-fname="{{$user->firstname}}"  data-lname="{{$user->lastname}}">Block</button>
                  </a>
                @endif
                @if ($user->status == 0)
                <a href="#">
                  <button class="btn btn-primary btn-sm"  type="button" data-toggle="modal" data-target="#disableUser" data-id="{{$user->id}}" data-status="{{$user->status}}"  data-fname="{{$user->firstname}}"  data-lname="{{$user->lastname}}">Activate</button>
                </a>
                @endif
                @if ($user->status == -1)
                <a href="#">
                  <button class="btn btn-danger btn-sm"  type="button" data-toggle="modal" data-target="#deleteUser" data-id="{{$user->id}}"   data-fname="{{$user->firstname}}"  data-lname="{{$user->lastname}}">Delete</button>
                </a>
                @endif
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
@include('users.block')
@include('users.delete')

  
@endsection 
  
@push("bk_script")

@include('partials.notification')
<script src="{{asset("dist/Inputmask5/jquery.inputmask.js")}}"></script>


<script>
  $(document).ready(function(){
    $('#table1').DataTable( {
        "paging":   true,
        "ordering": true,
        "info":     true,
        responsive: true
    } );
  
    $('[data-mask]').inputmask();


      //populate lga after state change
      $('#state_id').change(function(){
            if($(this).val() != '')
            {
                var stateID= $('#state_id').val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{route('getLgaList')}}",
                    method:"POST",
                    data:{id:stateID, _token:_token},
                    success:function(result)
                    {
                        $('#lga_id').html(result);
                        $('#lga_id').prepend('<option value="1">All LGAs</option>');
                    }         
                })
            }
        });
        
         //if fill lga after state change for edit modal
        $('#state_id1').change(function(){
              if($(this).val() != '')
              {
                  var stateID= $('#state_id1').val();
                  var _token = $('input[name="_token"]').val();
                  $.ajax({
                      url:"{{route('getLgaList')}}",
                      method:"POST",
                      data:{id:stateID, _token:_token},
                      success:function(result)
                      {
                          $('#lga_id1').html(result);
                          $('#lga_id1').prepend('<option value="1">All LGAs</option>');
                      }         
                  })
              }
          });
 
      //edit user

      $('#editUser').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var fname = button.data('fname')
        var lname=button.data('lname')
        var username=button.data('username')
        var email=button.data('email')
        var mobile=button.data('mobile')
        var state_id=button.data('state_id')
        var lga_id=button.data('lga_id')
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
        modal.find('.modal-body #mobile1').val(mobile).change();
        modal.find('.modal-body #UserID').val(id);
        modal.find('.modal-body #state_id1').val(state_id).change();

        var _token = $('input[name="_token"]').val();
              $.ajax({
                  url:"{{route('getRoleID')}}",
                  method:"POST",
                  data:{role:role, _token:_token},
                  success:function(result)
                  {
                      $('#role1').val(result).change();
                  }         
              })

        // if(state_id == 1)
        // {
        //     $('#lga_id1').prepend('<option value="1">All LGAs</option>');
        //     $('#lga_id1').val(lga_id).change();
        // }
        // else{
              var _token = $('input[name="_token"]').val();
              $.ajax({
                  url:"{{route('getLgaList')}}",
                  method:"POST",
                  data:{id:state_id, _token:_token},
                  success:function(result)
                  {
                      $('#lga_id1').html(result);
                      $('#lga_id1').prepend('<option value="1">All LGAs</option>');
                      $('#lga_id1').val(lga_id).change();
                  }         
              })
        // }

 
      });//end edit



      //block user
      $('#disableUser').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget) 
          var id = button.data('id')
          var status=button.data('status')
          var modal = $(this)
          modal.find('.modal-body #userid').val(id)
          modal.find('.modal-body #status').val(status)

          if(status == 1){
            var message =  "Are you sure you want to block '".concat(button.data('fname')," ",button.data('lname'), "'?") ;
            modal.find('.modal-body #message').text(message)
          }
          if(status == 0){
            var message =  "Are you sure you want to activate user '".concat(button.data('fname')," ",button.data('lname'), "'?") ;
            modal.find('.modal-body #message').text(message)
          }

      })//end

    //delete user
    $('#deleteUser').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget) 
          var id = button.data('id')
          var modal = $(this)
          modal.find('.modal-body #user').val(id)

          var message =  "Are you sure you want to delete '".concat(button.data('fname')," ",button.data('lname'), "' account?") ;
          modal.find('.modal-body #message_del').text(message)
            
      })//end


  });
</script>

@endpush