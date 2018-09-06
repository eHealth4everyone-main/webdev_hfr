  <div class="modal fade" id="user_profile" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">User Profile</h4>
              <div class='notifications top-right'></div>
            </div>
            <div class="modal-body">
              
                <div class="panel-body">
                    <form method="POST" action="{{ route('updateuser') }}" >
                        @csrf
                        @method("PUT")

                        <div class="form-group row">
                            <label for="firstname1" class="col-md-4 col-form-label text-md-right">{{ __('Fist Name') }}</label>
    
                            <div class="col-md-8">
                                <input id="firstname1" type="text" class="form-control" name="firstname" value="{{ old('firstname') }}" required autofocus>
    
                                <span class="text-danger">
                                    <strong id="firstname-error1"></strong>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                                <label for="lastname1" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>
    
                                <div class="col-md-8">
                                    <input id="lastname1" type="text" class="form-control" name="lastname" value="{{ old('lastname') }}" required>
    
                                    <span class="text-danger">
                                        <strong id="lastname-error1"></strong>
                                    </span>
                                </div>
                            </div>
    
                            <div class="form-group row">
                                    <label for="username1" class="col-md-4 col-form-label text-md-right">{{ __('User Name') }}</label>
        
                                    <div class="col-md-8">
                                        <input id="username1" type="text" class="form-control" name="username" value="{{ old('username') }}" disabled>
        
                                        <span class="text-danger">
                                            <strong id="username-error1"></strong>
                                        </span>
                                    </div>
                            </div>
    
                        <div class="form-group row">
                            <label for="email1" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
    
                            <div class="col-md-8">
                                <input id="email1" type="email" class="form-control" name="email" value="{{ old('email') }}" disabled>
    
                                <span class="text-danger">
                                     <strong id="email-error1"></strong>
                                </span>
                            </div>
                        </div>
    
                        <div class="form-group row">
                                <label for="role1" class="col-md-4 col-form-label text-md-right">{{ __('User Role') }}</label>
                                <div class="col-md-8">
                                        <select class="form-control select2"  class="form-control" id="role1" name="role" required data-width="100%">
                                                <option value="">--Select Role--</option>
                                                <option value="1">Admin</option>
                                        </select>
                                <span class="text-danger">
                                    <strong id="role-error1"></strong>
                                </span>
                                </div>
                               
                        </div>
                        <div class="form-group row">
                                <label for="state1" class="col-md-4 col-form-label text-md-right">{{ __('State') }}</label>
                                <div class="col-md-8">
                                        <select class="form-control select2" id="state1" name ="state" data-width="100%">
                                                <option value="">--Select State--</option>
                                                <option value='01' > Abia</option>
                                                <option value='02' > Adamawa</option>
                                                <option value='03' > Akwa Ibom</option>
                                                <option value='04' > Anambra</option>
                                                <option value='05' > Bauchi</option>
                                                <option value='06' > Bayelsa</option>
                                                <option value='07' > Benue</option>
                                                <option value='08' > Borno</option>
                                                <option value='09' > Cross River</option>
                                                <option value='10' > Delta</option>
                                                <option value='11' > Ebonyi</option>
                                                <option value='12' > Edo</option>
                                                <option value='13' > Ekiti</option>
                                                <option value='14' > Enugu</option>
                                                <option value='37' > FCT</option>
                                                <option value='15' > Gombe</option>
                                                <option value='16' > Imo</option>
                                                <option value='17' > Jigawa</option>
                                                <option value='18' > Kaduna</option>
                                                <option value='19' > Kano</option>
                                                <option value='20' > Katsina</option>
                                                <option value='21' > Kebbi</option>
                                                <option value='22' > Kogi</option>
                                                <option value='23' > Kwara</option>
                                                <option value='24' > Lagos</option>
                                                <option value='25' > Nasarawa</option>
                                                <option value='26' > Niger</option>
                                                <option value='27' > Ogun</option>
                                                <option value='28' > Ondo</option>
                                                <option value='29' > Osun</option>
                                                <option value='30' > Oyo</option>
                                                <option value='31' > Plateau</option>
                                                <option value='32' > Rivers</option>
                                                <option value='33' > Sokoto</option>
                                                <option value='34' > Taraba</option>
                                                <option value='35' > Yobe</option>
                                                <option value='36' > Zamfara</option>
                                            </select>
                                </div>
                                <input id="UserID" name="UserID" type="hidden">
                        </div>
           
               
                    </form>
                </div>

            </div>
               
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button id="update" class="btn btn-primary">Update</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->