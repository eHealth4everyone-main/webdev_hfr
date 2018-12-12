@extends("layouts.master")


@section("content")


<form class="form-horizontal" action="{{route('hospitals.store')}}" method="POST">
    @csrf
    
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        {{-- Tab One   --}}
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Signature Elements
                    </a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                    <div class="box-body">
                        
                        <div class="form-group">
                            <label for="cac_reg" class="col-sm-2 control-label">Registration No:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  id="registration_no" name="registration_no" value="{{old('registration_no')}}" placeholder="Corporate Affairs Registration Number">
                            </div>
                            
                            <label class="col-sm-2 control-label">Commencement Date:</label>
                            <div class="col-sm-4">
                                <div class="input-group date" >
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right" id="datepicker" name="start_date" value="{{old('start_date')}}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="reg_fac_name" class="col-sm-2 control-label">Registered Name: <font color="red">*</font> </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  id="facility_name"  name="facility_name" value="{{old('facility_name')}}" placeholder="Registered Facility Name" required>
                            </div>
                            
                            <label for="alt_facility_name" class="col-sm-2 control-label">Alternate Name:</label> 
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  id="alt_facility_name" name="alt_facility_name" value="{{old('alt_facility_name')}}" placeholder="Alternate Facility Name">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-2 control-label">State:<font color="red">*</font> </label></label>
                            <div class="col-sm-4">
                                <select class="form-control select2 dynamic" id="state_id" name ="state_id" data-dependent="lga_id" disabled required>
                                    <option value="">--Select State--</option>
                                    
                                    @foreach($lst_states as $st)
                                        <option value="{{$st->id}}">{{$st->name}}</option>
                                    @endforeach
                                    
                                </select>
                                <input type="hidden" name="state_id" value="{{Auth::user()->state_id}}" />
                            </div>
                            
                            <label class="col-sm-2 control-label">LGA:<font color="red">*</font> </label></label>
                            <div class="col-sm-4">
                                <select class="form-control select2 dynamic" id="lga_id" name="lga_id" data-dependent="ward_id" required>
                                    
                                </select>
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Ward:<font color="red">*</font> </label>
                            <div class="col-sm-10">
                                <select class="form-control select2" id="ward_id" name="ward_id" style="width: 100%;" required>
                                    
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="house_no" class="col-sm-2 control-label">House Number:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  id="house_no" name="house_no" value="{{old('house_no')}}">
                            </div>
                            
                            <label for="street_name" class="col-sm-2 control-label">Street Name:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  id="street_name"  name="street_name" value="{{old('street_name')}}">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="latitude" class="col-sm-2 control-label">Latitude:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  id="latitude" name="latitude"  value="{{old('latitude')}}">
                            </div>
                            
                            <label for="longitude" class="col-sm-2 control-label">Longitude:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  id="longitude" name="longitude" value="{{old('longitude')}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="postal_address" class="col-sm-2 control-label">Postal Address:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  id="postal_address"  name="postal_address" value="{{old('postal_address')}}">
                            </div>
                            
                            <label for="phone_number" class="col-sm-2 control-label">Phone Number:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  id="phone_number" name="phone_number"  value="{{old('phone_number')}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email_address" class="col-sm-2 control-label">Email Address:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  id="email_address" name="email_address" value="{{old('email_address')}}">
                            </div>
                            
                            <label for="website" class="col-sm-2 control-label">Website:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  id="website" name="website" value="{{old('website')}}">
                            </div>
                        </div>
                        
                        
                    <div class="form-group">
                            <label class="col-sm-2 control-label">Days of Operation:</label>
                            <div class="col-sm-10">
                                <select class="form-control select2" name="operational_days[]" multiple="multiple" data-placeholder="Select days of operation"
                                style="width: 100%;">
                                <option value="Monday" >Monday</option>
                                <option value="Tuesday" >Tuesday</option>
                                <option value="Wednesday" >Wednesday</option>
                                <option value="Thursday" >Thursday</option>
                                <option value="Friday" >Friday</option>
                                <option value="Saturday" >Saturday</option>
                                <option value="Sunday" >Sunday</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Hours of Operation:</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control"  id="operational_hours" name="operational_hours" value="" placeholder="24hrs / 08:00AM-06:00PM" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Hospital/ Clinic Level:<font color="red">*</font> </label></label>
                        <div class="col-sm-4">
                            <select class="form-control select2" id="facility_level_id"  name="facility_level_id" style="width: 100%;" required>
                                <option value="">--Select Level of Care--</option>
                                @foreach($lst_level_of_care as $st)
                                <option value="{{$st->id}}">{{$st->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <label id="level_option_label" class="col-sm-2 control-label" style="display:none">Facility Level Options:</label>
                        <div id="level_option_div" class="col-sm-4" style="display:none">
                            <select class="form-control select2" id="facility_level_option_id" name="facility_level_option_id" style="width: 100%;">
                                
                            </select>
                        </div>
                    </div>
                    <div class="form-group" id="specialized_div" style="display:none">
                        <label class="col-sm-2 control-label">Specialized Options:</label>
                        <div class="col-sm-4">
                            <select class="form-control select2" id="facility_level_options_category_id" name="facility_level_options_category_id" style="width: 100%;">
                                
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Ownership:<font color="red">*</font> </label></label>
                        <div class="col-sm-4">
                            <select class="form-control select2" id="ownership_id"  name="ownership_id" style="width: 100%;" required>
                                <option value="">--Select Ownership--</option>
                                @foreach($lst_ownerships as $st)
                                <option value="{{$st->id}}">{{$st->name}}</option>
                                @endforeach
                                
                            </select>
                        </div>
                        <label class="col-sm-2 control-label">Ownership Type:<font color="red">*</font></label>
                        <div class="col-sm-4">
                            <select class="form-control select2" id="ownership_type_id" name="ownership_type_id" style="width: 100%;" required>
                                
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="hs_ownership_details" class="col-sm-2 control-label">Ownership Details:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control"  id="ownership_details" name="ownership_details" value="{{old('ownership_details')}}">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Operation Status:<font color="red">*</font> </label></label>
                        <div class="col-sm-4">
                            <select class="form-control select2" id="operational_status_id" name="operational_status_id" style="width: 100%;" required>
                                <option value="">--Select Operation Status--</option>
                                @foreach($lst_oparational_status as $st)
                                <option value="{{$st->id}}">{{$st->status}}</option>
                                @endforeach
                            </select>
                            
                        </div>
                        <label class="col-sm-2 control-label">Regulatory Status:</label>
                        <div class="col-sm-4">
                            <select class="form-control select2" id="regulatory_status_id" name="regulatory_status_id" style="width: 100%;">
                                <option value="">--Select Regulatory Status--</option>
                                @foreach($lst_regulatory_status as $st)
                                <option value="{{$st->id}}">{{$st->status}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">License Status:</label>
                        <div class="col-sm-4">
                            <select class="form-control select2" id="license_status_id" name="license_status_id" style="width: 100%;">
                                <option value="">--Select License Status--</option>
                                @foreach($lst_license_status as $st)
                                <option value="{{$st->id}}">{{$st->status}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    
  
     {{-- Tab twoServices --}}
     <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading2">
                <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse2" aria-expanded="false" aria-controls="collapse2">
                        Services
                    </a>
                </h4>
            </div>
            <div id="collapse2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading2">
                <div class="panel-body">
                        <div class="form-group">
                                <label class="col-sm-3 control-label">Medical:</label>
                                <div class="col-sm-9">
                                    <select class="form-control select2" name="services[]" multiple="multiple" data-placeholder="Select Service" style="width: 100%;">
                                            @foreach($lst_services as $s)      
                                                @if($s->service_category_id == 1)
                                                        <option value="{{$s->id}}">{{$s->name}}</option>
                                                @endif                                       
                                            @endforeach
                                    </select>
                                </div>
                        </div>
                        <div class="form-group">
                                <label class="col-sm-3 control-label">Surgical:</label>
                                <div class="col-sm-9">
                                        <select class="form-control select2" name="services[]" multiple="multiple" data-placeholder="Select Service" style="width: 100%;">
                                                @foreach($lst_services as $s)      
                                                    @if($s->service_category_id == 2)
                                                            <option value="{{$s->id}}">{{$s->name}}</option>
                                                    @endif                                       
                                                @endforeach
                                        </select>
                                    
                            </div>
                        </div>
                        <div class="form-group">
                                <label class="col-sm-3 control-label">Obstetrics and Gynecology:</label>
                                <div class="col-sm-9">
                                        <select class="form-control select2" name="services[]" multiple="multiple" data-placeholder="Select Service" style="width: 100%;">
                                                @foreach($lst_services as $s)      
                                                    @if($s->service_category_id == 3)
                                                            <option value="{{$s->id}}">{{$s->name}}</option>
                                                    @endif                                       
                                                @endforeach
                                        </select>    
                            </div>
                        </div>
                        <div class="form-group">
                                <label class="col-sm-3 control-label">Pediatrics:</label>
                                <div class="col-sm-9">
                                        <select class="form-control select2" name="services[]" multiple="multiple" data-placeholder="Select Service" style="width: 100%;">
                                                @foreach($lst_services as $s)      
                                                    @if($s->service_category_id == 4)
                                                            <option value="{{$s->id}}">{{$s->name}}</option>
                                                    @endif                                       
                                                @endforeach
                                        </select>
                                    
                            </div>
                        </div>
                        <div class="form-group">
                                <label class="col-sm-3 control-label">Dental:</label>
                                <div class="col-sm-9">
                                        <select class="form-control select2" name="services[]" multiple="multiple" data-placeholder="Select Service" style="width: 100%;">
                                                @foreach($lst_services as $s)      
                                                    @if($s->service_category_id == 5)
                                                            <option value="{{$s->id}}">{{$s->name}}</option>
                                                    @endif                                       
                                                @endforeach
                                        </select>   
                            </div>
                        </div>
                        <div class="form-group">
                                <label class="col-sm-3 control-label">Specific Clinical Service:</label>
                                <div class="col-sm-9">
                                        <select class="form-control select2" name="services[]" multiple="multiple" data-placeholder="Select Service" style="width: 100%;">
                                                @foreach($lst_services as $s)      
                                                    @if($s->service_category_id == 6)
                                                            <option value="{{$s->id}}">{{$s->name}}</option>
                                                    @endif                                       
                                                @endforeach
                                        </select>   
                            </div>
                        </div>
                        <div class="form-group">
                                <label for="hs_no_doctors" class="col-sm-3 control-label">Accidents and Emergency (Number of Beds):</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control input-sm"  id="beds_accidents_emerg" name="beds_accidents_emerg"  value="{{old('beds_accidents_emerg')}}">
                                </div>
                                <label for="hs_no_pharm" class="col-sm-3 control-label">Admission Facilities (Number of Beds) :</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control input-sm"  id="beds_adminission" name="beds_adminission" value="{{old('beds_adminission')}}">
                                </div>
                        </div>
                        <div class="form-group">
                                <label for="hs_no_doctors" class="col-sm-3 control-label">Intensive Care Unit (Number of Beds):</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control input-sm"  id="beds_icu" name="beds_icu"  value="{{old('beds_icu')}}">
                                </div>
                        </div>
                </div>
            </div>
        </div><!-- end here-->

          {{-- Tab three- HR --}}
    <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading3">
                <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse3" aria-expanded="false" aria-controls="collapse3">
                        Human Resources
                    </a>
                </h4>
            </div>
            <div id="collapse3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading3">
                <div class="panel-body">
                    
                    <div class="form-group">
                        <label for="hs_no_doctors" class="col-sm-3 control-label">Medical Doctors:</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control input-sm"  id="doctors" name="doctors"  value="{{old('doctors')}}">
                        </div>
                        <label for="hs_no_pharm" class="col-sm-3 control-label">Pharmacists:</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control input-sm"  id="pharmacists" name="pharmacists" value="{{old('pharmacists')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="hs_no_dentist" class="col-sm-3 control-label">Dentists:</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control input-sm"  id="dentist" name="dentist"  value="{{old('dentist')}}">
                        </div>
                        <label for="hs_no_pharm_tech" class="col-sm-3 control-label">Pharmacy Technicians:</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control input-sm"  id="pharmacy_technicians" name="pharmacy_technicians" value="{{old('pharmacy_technicians')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="hs_no_single_qualified_nurses" class="col-sm-3 control-label">Nurses (Single):</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control input-sm"  id="nurses" name="nurses"  value="{{old('nurses')}}">
                        </div>
                        <label for="hs_no_lab_sc" class="col-sm-3 control-label">Laboratory Scientists:</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control input-sm"  id="lab_scientists" name="lab_scientists" value="{{old('lab_scientists')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="hs_no_single_qualified_midwives" class="col-sm-3 control-label">Midwifes (Single):</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control input-sm"  id="midwifes" name="midwifes"  value="{{old('midwifes')}}">
                        </div>
                        <label for="hs_no_lab_tech" class="col-sm-3 control-label">Laboratory Technicians:</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control input-sm"  id="lab_technicians" name="lab_technicians" value="{{old('lab_technicians')}}">
                        </div>
                    </div> 
                    
                    <div class="form-group">
                        <label for="hs_nurses_midwives" class="col-sm-3 control-label">Nurse/ Midwife (Double):</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control input-sm"  id="nurse_midwife" name="nurse_midwife"  value="{{old('nurse_midwife')}}">
                        </div>
                        <label for="hs_no_health_rec" class="col-sm-3 control-label">Health Records/HIM Officers:</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control input-sm"  id="him_officers" name="him_officers" value="{{old('him_officers')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="hs_no_comm_health_officer" class="col-sm-3 control-label">Community Health Officer:</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control input-sm"  id="community_health_officer" name="community_health_officer"  value="{{old('community_health_officer')}}">
                        </div>
                        <label for="hs_no_comm_health_ext_officer" class="col-sm-3 control-label">Community Health Extension Worker:</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control input-sm"  id="community_extension_workers" name="community_extension_workers" value="{{old('community_extension_workers')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="hs_no_jun_comm_health_ext_off" class="col-sm-3 control-label">Junior Com Health Extension Worker:</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control input-sm"  id="jun_community_extension_worker" name="jun_community_extension_worker"  value="{{old('jun_community_extension_worker')}}">
                        </div>
                        <label for="hs_no_dental_tech" class="col-sm-3 control-label">Dental Technicians:</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control input-sm"  id="dental_technicians" name="dental_technicians" value="{{old('dental_technicians')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="hs_no_env_health_officer" class="col-sm-3 control-label">Environmental Health Officers:</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control input-sm"  id="env_health_officers" name="env_health_officers" value="{{old('env_health_officers')}}">
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- end here-->

              {{-- Tab four- Other Services --}}
              <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading4">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                Other Services
                            </a>
                        </h4>
                    </div>
                    <div id="collapse4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading4">
                        <div class="panel-body">
                                <div class="form-group">
                                        <div class="col-sm-1">  </div>                                        
                                        <div class="col-sm-3">                               
                                                <input type='checkbox'name='onsite_pharmarcy' value='Yes'> Onsite Pharmacy
                                        </div>
                                </div>
                                <div class="form-group">
                                        <div class="col-sm-1">  </div> 
                                        <div class="col-sm-3">                               
                                                <input type='checkbox'name='onsite_laboratory' value='Yes'> Onsite Laboratory
                                        </div>
                                </div>
                                <div class="form-group">
                                        <div class="col-sm-1">  </div> 
                                        <div class="col-sm-3">                               
                                                <input type='checkbox'name='onsite_imaging' value='Yes'> Onsite Imaging/ Radio-Diagnostics Center
                                        </div>
                                </div>
                                <div class="form-group">
                                        <div class="col-sm-1">  </div> 
                                        <div class="col-sm-3">                               
                                                <input type='checkbox'name='mortuary_services' value='Yes'> Mortuary Services
                                        </div> 
                                </div>
                        </div>
                    </div>
                </div><!-- end here-->
</div>

<!-- /.box-body -->
<div class="box-footer">
    <a href="{{route('hospitals.index')}}">
        <button type="button" class="btn btn-warning">Return Back</button>
    </a>
    <button type="submit" class="btn btn-primary pull-right">Send Create Request</button>
</div>
<!-- /.box-footer -->
</form>

@endsection 

@push('bk_script')
@include('partials.dynamic_state_script')
@include('partials.notification')

<script>
    $("#state_id").val({{Auth::user()->state_id}}).change();

    //get lgas
    var stateID= {{Auth::user()->state_id}};
    var _token = $('input[name="_token"]').val();
    $.ajax({
        url:"{{route('getLgaList')}}",
        method:"POST",
        data:{id:stateID, _token:_token},
        success:function(result)
        {
            $('#lga_id').html(result);
        }         
    })
    /* hospital level change */
    $("#facility_level_id").change(function(){
        if($(this).val()=="2") //if secondary
        {    
            $('#facility_level_option_id option').remove();
            $('#level_option_label').hide();
            $('#level_option_div').hide();
            $('#facility_level_option_category_id option').remove();               
            $('#specialized_div').hide();
        }
        else{ //primary or tertiary
            $('#facility_level_option_id option').remove();               
            $('#level_option_div').show();
            $('#level_option_label').show();
            $('#specialized_div').hide();
            $('#facility_level_option_category_id option').remove();               
            
            
            var levelID= $('#facility_level_id').val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url:"{{route('getFacilityLevelOption')}}",
                method:"POST",
                data:{id:levelID, _token:_token},
                success:function(result)
                {
                    $('#facility_level_option_id').html(result);
                }         
            })
        }
    });
    
    /* hospital level option change */
    $("#facility_level_option_id").change(function(){
        if($(this).val()=="5") //if specialized 
        {    
            $('#specialized_div').show();
            
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url:"{{route('getSpecializedOptions')}}",
                method:"POST",
                data:{_token:_token},
                success:function(result)
                {
                    $('#facility_level_options_category_id').html(result);
                }         
            })
        }
        else{ 
            $('#facility_level_option_category_id option').remove();               
            $('#specialized_div').hide();              
        }
    });
    
    //get ownership  type ownership_type_id
    $("#ownership_id").change(function(){
        if($(this).val() != "") //if specialized 
        {    
            var id= $('#ownership_id').val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url:"{{route('getOwnershipType')}}",
                method:"POST",
                data:{ownership_id:id,_token:_token},
                success:function(result)
                {
                    $('#ownership_type_id').html(result);
                }         
            })            
        }
    });
</script>

@endpush