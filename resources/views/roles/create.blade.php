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
                            <label for="descr" class="col-md-2 col-form-label text-md-right">Description</label>
                            <div class="col-md-10">
                                    <input id="descr" type="text" class="form-control" name="description" required>
                            <span class="text-danger">
                                <strong id="descr-error"></strong>
                            </span>
                            </div>
                         </div>  
                        <div class="form-group row">
                                <label for="perm" class="col-md-2 col-form-label text-md-right">{{ __('Permissions') }}</label>
                                <div class="col-md-10">
                                <select class="form-control" id="perm" name="perm[]" multiple="multiple" data-placeholder="Select Permissions" style="width: 100%;" required>
                                    {{-- @foreach($permissions as $perms)
                                        <option value="{{$perms->name}}">{{$perms->name}}</option>
                                    @endforeach --}}
                                    <optgroup label="Hospitals Module" id="hosp">
                                        <option value="1">View-Hospital</option>
                                        <option value="2">Edit-Hospital</option>
                                        <option value="3">Add-Hospital</option>
                                        <option value="4">Delete-Hospital</option>
                                    </optgroup>
                                    <optgroup label="Laboratory Module" id="lab">
                                         <option value="5">View-Laboratory</option>
                                        <option value="6">Edit-Laboratory</option>
                                        <option value="7">Add-Laboratory</option>
                                        <option value="8">Delete-Laboratory</option>
                                    </optgroup>
                                    <optgroup label="Pharmacys Module" id="pharm">
                                         <option value="9">View-Pharmacy</option>
                                        <option value="10">Edit-Pharmacy</option>
                                        <option value="11">Add-Pharmacy</option>
                                        <option value="12">Delete-Pharmacy</option>
                                    </optgroup>
                                    <optgroup label="Radiology Module" id="rad">
                                         <option value="13">View-Radiology</option>
                                        <option value="14">Edit-Radiology</option>
                                        <option value="15">Add-Radiology</option>
                                        <option value="16">Delete-Radiology</option>
                                    </optgroup>
                                    <optgroup label="Roles & Users" id="user">
                                        <option value="21">View-Role</option>
                                        <option value="22">Edit-Role</option>
                                        <option value="23">Add-Role</option>
                                        <option value="24">Delete-Role</option>
                                        <option value="17">View-User</option>
                                        <option value="18">Edit-User</option>
                                        <option value="19">Add-User</option>
                                        <option value="20">Delete-User</option>
                                    </optgroup>
                                    <optgroup label="Resources Module" id="resources">
                                         <option value="25">View-Resources</option>
                                        <option value="26">Add-Resources</option>
                                        <option value="27">Delete-Resources</option>
                                    </optgroup>
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
   