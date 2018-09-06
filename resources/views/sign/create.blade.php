@extends("layouts.master")

@section('content-title')
<h4> <p class="text-aqua">New Health Facility</p></h4>
@endsection

@section("content")

<div class="box">
    {{-- <div class="box-header with-border">
        <h4> <p class="text-aqua">New Health Facility</p></h4>
    </div> --}}
    <!-- /.box-header -->
    <!-- form start -->
    
</div>
{{-- ** Erros and messages --}}
  
{{-- ***** end of error messages dispay --}}

<form class="form-horizontal" action="/sign" method="POST">
    @csrf
    
    
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        {{-- Tab One   --}}
        <div class="panel panel-primary">
            <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Signature Data
                    </a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                    <div class="box-body">
                        
                        <div class="form-group">
                            <label for="cac_reg" class="col-sm-2 control-label">Registration No:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  id="cac_reg" name="cac_reg" value="" placeholder="Corporate Affairs Registration Number">
                            </div>
                            
                            <label class="col-sm-2 control-label">Commencement Date:</label>
                            <div class="col-sm-4">
                                <div class="input-group date" >
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right" id="datepicker" name="comm_date">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="reg_fac_name" class="col-sm-2 control-label">Registered Name: <font color="red">*</font> </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  id="reg_fac_name"  name="reg_fac_name" value="" placeholder="Registered Facility Name">
                            </div>
                            
                            <label for="alt_facility_name" class="col-sm-2 control-label">Alternate Name:</label> 
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  id="alt_facility_name" name="alt_facility_name" value="" placeholder="Alternate Facility Name">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-2 control-label">State:<font color="red">*</font> </label></label>
                            <div class="col-sm-4">
                                <select class="form-control select2 dynamic" id="state" name ="state" data-dependent="lga">
                                    <option value="">--Choose one--</option>
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
                            
                            <label class="col-sm-2 control-label">LGA:<font color="red">*</font> </label></label>
                            <div class="col-sm-4">
                                <select class="form-control select2 dynamic" id="lga" name="lga" data-dependent="ward">
                                    <option value="">--Select LGA--</option>
                                </select>
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Ward:</label>
                            <div class="col-sm-10">
                                <select class="form-control select2" id="ward" name="ward" style="width: 100%;">
                                    <option value="">--Select Ward--</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="house_no" class="col-sm-2 control-label">House Number:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  id="house_no" name="house_no" value="">
                            </div>
                            
                            <label for="street_name" class="col-sm-2 control-label">Street Name:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  id="street_name"  name="street_name" value="">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="latitude" class="col-sm-2 control-label">Latitude:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  id="latitude" name="latitude"  value="">
                            </div>
                            
                            <label for="longitude" class="col-sm-2 control-label">Longitude:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  id="longitude" name="longitude" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="postal_address" class="col-sm-2 control-label">Postal Address:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  id="postal_address"  name="postal_address" value="">
                            </div>
                            
                            <label for="phone_number" class="col-sm-2 control-label">Phone Number:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  id="phone_number" name="phone_number"  value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email_address" class="col-sm-2 control-label">Email Address:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  id="email_address" name="email_address" value="">
                            </div>
                            
                            <label for="website" class="col-sm-2 control-label">Website:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  id="website" name="website" value="">
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
                            <select class="form-control select2" id="hr_operation" name="hr_operation" style="width: 100%;">
                                <option value="">--Choose one--</option>
                                <option value="24 hours">24 hours</option>
                                <option value="Period Range">Period Range</option>
                            </select>
                        </div>
                        <label class="col-sm-2 control-label">Period range:</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control"  id="operational_hours" name="operational_hours" value="" placeholder="08:00AM-06:00PM" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Hospital/ Clinic Level:<font color="red">*</font> </label></label>
                        <div class="col-sm-4">
                            <select class="form-control select2" id="hs_level"  name="hs_level" style="width: 100%;">
                                <option value="">--Choose one--</option>
                                <option value="1">Primary</option>
                                <option value="2">Secondary</option>
                                <option value="3">Tertiary</option>
                            </select>
                        </div>
                        <label id="fac_option1" class="col-sm-2 control-label" style="display:none">Facility Level Options:</label>
                        <div id="fac_option2" class="col-sm-4" style="display:none">
                            <select class="form-control select2" id="hs_level_option" name="hs_level_option" style="width: 100%;">
                                <option value="">--Choose one--</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" id="specialized" style="display:none">
                        <label class="col-sm-2 control-label">Specialized Hospital:</label>
                        <div class="col-sm-4">
                            <select class="form-control select2" id="hs_sp_option" name="hs_sp_option" style="width: 100%;">
                                <option value="">Select One</option>
                                <option  value="Ophthalmological Center">Ophthalmological Center</option>
                                <option  value="ENT/Otorhinolaryngology Center">ENT/Otorhinolaryngology Center</option>
                                <option  value="Orthopedic Center">Orthopedic Center</option>
                                <option  value="Neuropsychiatric Hospital">Neuropsychiatric Hospital</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Ownership:<font color="red">*</font> </label></label>
                        <div class="col-sm-4">
                            <select class="form-control select2" id="hs_ownership"  name="hs_ownership" style="width: 100%;">
                                <option value="">--Choose one--</option>
                                <option value="1">Public</option>
                                <option value="2">Private</option>
                            </select>
                        </div>
                        <label class="col-sm-2 control-label">Ownership Type:</label>
                        <div class="col-sm-4">
                            <select class="form-control select2" id="hs_ownership_type" name="hs_ownership_type" style="width: 100%;">
                                <option value="">--Choose one--</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="hs_ownership_details" class="col-sm-2 control-label">Ownership Details:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control"  id="hs_ownership_details" name="hs_ownership_details" value="">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Operation Status:<font color="red">*</font> </label></label>
                        <div class="col-sm-4">
                            <select class="form-control select2" id="hs_op_status" name="hs_op_status" style="width: 100%;">
                                <option value="">--Choose one--</option>
                                <option value="1">Operational</option>
                                <option value="2">Pending Operation - Under construction</option>
                                <option value="3">Pending Operation - Construction complete</option>
                                <option value="4">Closed (Temporary)</option>
                                <option value="5">Closed (Permanent)</option>
                                <option value="6">Unknown</option>
                            </select>
                        </div>
                        <label class="col-sm-2 control-label">Regulatory Status:</label>
                        <div class="col-sm-4">
                            <select class="form-control select2" id="hs_reg_status" name="hs_reg_status" style="width: 100%;">
                                <option value="">--Choose one--</option>
                                <option value="1">Provisionally Registered</option>
                                <option value="2">Registered</option>
                                <option value="3">Registration Suspended</option>
                                <option value="4">Registration Cancelled</option>
                                <option value="5">Unknown</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">License Status:</label>
                        <div class="col-sm-4">
                            <select class="form-control select2" id="hs_lic_status" name="hs_lic_status" style="width: 100%;">
                                <option value="">--Choose one--</option>
                                <option value="1">Licensed</option>
                                <option value="2">Not Licensed</option>
                                <option value="3">Unknown</option>
                            </select>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    
    
    {{-- Tab Three Services --}}
    <div class="panel panel-primary">
        <div class="panel-heading" role="tab" id="headingThree">
            <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    Hospital Services
                </a>
            </h4>
        </div>
        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
            <div class="panel-body">
                
                @include('sign.services')
                
            </div>
        </div>
    </div>
    {{-- Tab Four- HR --}}
    <div class="panel panel-primary">
        <div class="panel-heading" role="tab" id="headingThree">
            <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseThree">
                    Human Resource
                </a>
            </h4>
        </div>
        <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
            <div class="panel-body">
                
                <div class="form-group">
                    <label for="hs_no_doctors" class="col-sm-3 control-label">Medical Doctors:</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control input-sm"  id="hs_no_doctors" name="hs_no_doctors"  value="0">
                    </div>
                    <label for="hs_no_pharm" class="col-sm-3 control-label">Pharmacists:</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control input-sm"  id="hs_no_pharm" name="hs_no_pharm" value="0">
                    </div>
                </div>
                <div class="form-group">
                    <label for="hs_no_dentist" class="col-sm-3 control-label">Dentists:</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control input-sm"  id="hs_no_dentist" name="hs_no_dentist"  value="0">
                    </div>
                    <label for="hs_no_pharm_tech" class="col-sm-3 control-label">Pharmacy Technicians:</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control input-sm"  id="hs_no_pharm_tech" name="hs_no_pharm_tech" value="0">
                    </div>
                </div>
                <div class="form-group">
                    <label for="hs_no_single_qualified_nurses" class="col-sm-3 control-label">Nurses (Single):</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control input-sm"  id="hs_no_single_qualified_nurses" name="hs_no_single_qualified_nurses"  value="0">
                    </div>
                    <label for="hs_no_lab_sc" class="col-sm-3 control-label">Laboratory Scientists:</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control input-sm"  id="hs_no_lab_sc" name="hs_no_lab_sc" value="0">
                    </div>
                </div>
                <div class="form-group">
                    <label for="hs_no_single_qualified_midwives" class="col-sm-3 control-label">Midwifes (Single):</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control input-sm"  id="hs_no_single_qualified_midwives" name="hs_no_single_qualified_midwives"  value="0">
                    </div>
                    <label for="hs_no_lab_tech" class="col-sm-3 control-label">Laboratory Technicians:</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control input-sm"  id="hs_no_lab_tech" name="hs_no_lab_tech" value="0">
                    </div>
                </div> 
                
                <div class="form-group">
                    <label for="hs_nurses_midwives" class="col-sm-3 control-label">Nurse/ Midwife (Double):</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control input-sm"  id="hs_nurses_midwives" name="hs_nurses_midwives"  value="0">
                    </div>
                    <label for="hs_no_health_rec" class="col-sm-3 control-label">Health Records/HIM Officers:</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control input-sm"  id="hs_no_health_rec" name="hs_no_health_rec" value="0">
                    </div>
                </div>
                <div class="form-group">
                    <label for="hs_no_comm_health_officer" class="col-sm-3 control-label">Community Health Officer:</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control input-sm"  id="hs_no_comm_health_officer" name="hs_no_comm_health_officer"  value="0">
                    </div>
                    <label for="hs_no_comm_health_ext_officer" class="col-sm-3 control-label">Community Health Extension Worker:</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control input-sm"  id="hs_no_comm_health_ext_officer" name="hs_no_comm_health_ext_officer" value="0">
                    </div>
                </div>
                <div class="form-group">
                    <label for="hs_no_jun_comm_health_ext_off" class="col-sm-3 control-label">Junior Com Health Extension Worker:</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control input-sm"  id="hs_no_jun_comm_health_ext_off" name="hs_no_jun_comm_health_ext_off"  value="0">
                    </div>
                    <label for="hs_no_dental_tech" class="col-sm-3 control-label">Dental Technicians:</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control input-sm"  id="hs_no_dental_tech" name="hs_no_dental_tech" value="0">
                    </div>
                </div>
                <div class="form-group">
                    <label for="hs_no_env_health_officer" class="col-sm-3 control-label">Environmental Health Officers:</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control input-sm"  id="hs_no_env_health_officer" name="hs_no_env_health_officer" value="0">
                    </div>
                </div>
            </div>
        </div>
    </div><!-- end here-->
    {{-- Tab five --}}
    <div class="panel panel-primary">
        <div class="panel-heading" role="tab" id="headingThree">
            <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseThree">
                    HIS Identifiers
                </a>
            </h4>
        </div>
        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
            <div class="panel-body">
                
                
                
                <div class="form-group">
                    <label for="hs_dhis_ident" class="col-sm-2 control-label">DHIS Identifier:</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control input-sm"  id="hs_dhis_ident" name="hs_dhis_ident"  value="">
                    </div>
                    <label for="hs_datim_ident" class="col-sm-2 control-label">DATIM Identifier:</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control input-sm"  id="hs_datim_ident" name="hs_datim_ident" value="">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="hs_lmis_ident" class="col-sm-2 control-label">LMIS Identifier:</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control input-sm"  id="hs_lmis_ident" name="hs_lmis_ident" value="">
                    </div>
                    <label for="hs_hris_ident" class="col-sm-2 control-label">HRIS Identifier:</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control input-sm"  id="hs_hris_ident" name="hs_hris_ident" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="hs_ennrims_ident" class="col-sm-2 control-label">eNNRIMS Identifier:</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control input-sm"  id="hs_ennrims_ident" name="hs_ennrims_ident" value="">
                    </div>
                </div>
                
                
            </div>
        </div>
    </div><!--end here -->
    
</div>

<!-- /.box-body -->
<div class="box-footer">
    <a href="/sign">
        <button type="button" class="btn btn-danger">Cancel</button>
    </a>
    <button type="submit" class="btn btn-primary pull-right">Submit Record</button>
</div>
<!-- /.box-footer -->
</form>

@endsection 

@push('bk_script')
    @include('partials.dynamic_state_script')
    @include('partials.notification')
    @include('sign.scripts')
@endpush