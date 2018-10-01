  <div class="modal fade" id="changepass" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Change Password</h4>
              <div class='notifications top-right'></div>
            </div>
            <div class="modal-body">
              
                <div class="panel-body">
                    <form method="POST" action="{{ route('changePassword') }}">
                        @csrf
    
                        <div class="form-group row">
                            <label for="current_password" class="col-md-4 col-form-label text-md-right">Current Password</label>
    
                            <div class="col-md-8">
                                <input type="password" class="form-control" name="current_password" id="current_password" required autofocus>
    
                                <span class="text-danger">
                                    <strong id="firstname-error"></strong>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                                <label for="new_password" class="col-md-4 col-form-label text-md-right">New Password</label>
    
                                <div class="col-md-8">
                                    <input  type="password" class="form-control" name="new_password"  id="new_password"  required>
    
                                    <span class="text-danger">
                                        <strong id="lastname-error"></strong>
                                    </span>
                                </div>
                            </div>
    
                            <div class="form-group row">
                                    <label for="username" class="col-md-4 col-form-label text-md-right">Confirm New Password</label>
        
                                    <div class="col-md-8">
                                        <input  type="password" class="form-control" name="new_password_confirmation" id="new_password_confirmation"  required>
        
                                        <span class="text-danger">
                                            <strong id="username-error"></strong>
                                        </span>
                                    </div>
                            </div>
            
                        <div class="pull-right">
                            
                            <button type="submit" id="save" class="btn btn-success">Change Password</button>
                        </div>
                    </form>
                </div>
    
              
            </div>
        
          </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->