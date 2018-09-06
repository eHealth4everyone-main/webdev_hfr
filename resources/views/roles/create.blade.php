  <div class="modal fade" id="createrole" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Create Role</h4>
              <div class='notifications top-right'></div>
            </div>
            <div class="modal-body">
              
                <div class="panel-body">
                    <form method="POST" action="{{ route('addrole') }}">
                        @csrf             
    
                        <div class="form-group row">
                                <label for="role" class="col-md-2 col-form-label text-md-right">{{ __('Role') }}</label>
                                <div class="col-md-10">
                                        <input id="role" type="text" class="form-control" name="role" required autofocus>
                                <span class="text-danger">
                                    <strong id="role-error"></strong>
                                </span>
                                </div>
                        </div>      
                        <div class="form-group row">
                                <label for="perm" class="col-md-2 col-form-label text-md-right">{{ __('Permissions') }}</label>
                                <div class="col-md-10">
                                <select class="form-control select2" id="perm" name="perm[]" multiple="multiple" data-placeholder="Select Permissions" style="width: 100%;" required>
                                    @foreach($permissions as $perms)
                                        <option value="{{$perms->name}}">{{$perms->name}}</option>
                                    @endforeach
                                </select>
                                </div>
                                <span class="text-danger">
                                    <strong id="perm-error"></strong>
                                </span>
                        </div>
                        <div class="pull-right">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="save" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>      
                                              
                   
            </div>
    
              
            </div>
               
            <div class="modal-footer">
              
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->
   