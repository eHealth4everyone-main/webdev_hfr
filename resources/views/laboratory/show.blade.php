@extends("layouts.master")

@section('content-title')
<h4> <p class="text-aqua">Unique ID: {{$labs->sig_unique_id}}</p></h4>
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

<form class="form-horizontal" action="/lab" method="POST">
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
                                <input type="text" class="form-control"  id="cac_reg" name="cac_reg" value="{{$labs->cac_reg}}" placeholder="Corporate Affairs Registration Number">
                            </div>
                            
                            <label class="col-sm-2 control-label">Commencement Date:</label>
                            <div class="col-sm-4">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right" id="datepicker"  value="{{$labs->comm_date}}" name="comm_date">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="reg_fac_name" class="col-sm-2 control-label">Registered Name: <font color="red">*</font> </label>
                            <div class="col-sm-4">
                            <input type="text" class="form-control"  id="reg_fac_name"  name="reg_fac_name" value="{{$labs->reg_fac_name}}" placeholder="Registered Facility Name">
                            </div>
                            
                            <label for="alt_facility_name" class="col-sm-2 control-label">Alternate Name:</label> 
                            <div class="col-sm-4">
                            <input type="text" class="form-control"  id="alt_facility_name" name="alt_facility_name" value="{{$labs->alt_facility_name}}" placeholder="Alternate Facility Name">
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
                            <input type="text" class="form-control"  id="house_no" name="house_no" value="{{$labs->house_no}}">
                            </div>
                            
                            <label for="street_name" class="col-sm-2 control-label">Street Name:</label>
                            <div class="col-sm-4">
                            <input type="text" class="form-control"  id="street_name"  name="street_name" value="{{$labs->street_name}}">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="latitude" class="col-sm-2 control-label">Latitude:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  id="latitude" name="latitude"  value="{{$labs->latitude}}">
                            </div>
                            
                            <label for="longitude" class="col-sm-2 control-label">Longitude:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  id="longitude" name="longitude" value="{{$labs->longitude}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="postal_address" class="col-sm-2 control-label">Postal Address:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  id="postal_address"  name="postal_address" value="{{$labs->postal_address}}">
                            </div>
                            
                            <label for="phone_number" class="col-sm-2 control-label">Phone Number:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  id="phone_number" name="phone_number"  value="{{$labs->phone_number}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email_address" class="col-sm-2 control-label">Email Address:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  id="email_address" name="email_address" value="{{$labs->email_address}}">
                            </div>
                            
                            <label for="website" class="col-sm-2 control-label">Website:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  id="website" name="website" value="{{$labs->website}}">
                            </div>
                        </div>
                        
                        
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Days of Operation:</label>
                            <div class="col-sm-10">
                                <select class="form-control select2" id="opsdays" name="operational_days[]" multiple="multiple" data-placeholder="Select days of operation"
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
                            <input type="text" class="form-control"  id="operational_hours" name="operational_hours" value="{{$labs->operational_hours}}" placeholder="08:00AM-06:00PM" disabled>
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
                        <input type="text" class="form-control"  id="hs_ownership_details" name="hs_ownership_details" value="{{$labs->lab->lb_owner_dt}}">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Operation Status:<font color="red">*</font> </label></label>
                        <div class="col-sm-4">
                            <select class="form-control select2" id="hs_op_status" name="hs_op_status" style="width: 100%;">
                                <option value="">--Choose one--</option>
                                <option value="1">Functional</option>
                                <option value="2">Sealed</option>
                                <option value="3">Under Renovation</option>
                                <option value="4">Under Surveillance</option>
                            </select>
                        </div>
                        <label class="col-sm-2 control-label">Regulatory Status:</label>
                        <div class="col-sm-4">
                            <select class="form-control select2" id="hs_reg_status" name="hs_reg_status" style="width: 100%;">
                                <option value="">--Choose one--</option>
                                <option value="1">Registered</option>
                                <option value="2">Not Registered</option>
                                <option value="3">Unknown</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Accreditation Status:</label>
                        <div class="col-sm-4">
                            <select class="form-control select2" id="lb_acc_status" name="lb_acc_status" style="width: 100%;">
                                <option value="">--Choose one--</option>
                                <option value="1">Accredited</option>
                                <option value="2">Not Acrredited</option>
                                <option value="3">Unknown</option>
                            </select>
                        </div>
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
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Laboratory Level:<font color="red">*</font> </label></label>
                        <div class="col-sm-4">
                            <select class="form-control select2" id="hs_level"  name="hs_level" style="width: 100%;">
                                <option value="">--Choose one--</option>
                                <option value="1">Primary</option>
                                <option value="2">Secondary</option>
                                <option value="3">Tertiary</option>
                            </select>
                        </div>
                        <label class="col-sm-2 control-label">Institution/Stand Alone:<font color="red">*</font> </label>
                        <div class="col-sm-4">
                            <select class="form-control select2" id="lb_state" name="lb_state" style="width: 100%;">
                                <option value="">--Choose one--</option>
                                <option value="1">Institution</option>
                                <option value="2">Standalone</option>
                            </select>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>
    
    {{-- Tab Four- HR --}}
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingThree">
            <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseThree">
                    Service Elements
                </a>
            </h4>
        </div>
        <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
            <div class="panel-body">
                
                <div class="form-group">
                
                    <label class="col-sm-2 control-label">Laboratory Number:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control"  id="lb_reg_num" name="lb_reg_num" value="{{$labs->lab->lb_reg_num}}" placeholder="Public/Private Medical Laboratory Number">                    
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Laboratory Certification:</label></label>
                    <div class="col-sm-3">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="national" id="national"> National
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="international" id="international"> International
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="form-group" id="nat1">
                    <label class="col-sm-2 control-label">National Certification:</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="nat_cert" name="nat_cert" style="width: 100%;">
                                <option value="">--Choose one--</option>
                        </select>                 
                    </div>
                </div>
                <div class="form-group" id="nat2">
                    <label class="col-sm-2 control-label">Certification Date:</label>
                    <div class="col-sm-4">
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" id="datepicker1" name="lb_dt_cert_ng" value="{{$labs->lab->lb_dt_cert_ng}}">
                        </div>
                    </div>
                    <label class="col-sm-2 control-label">Expiration Date:</label>
                    <div class="col-sm-4">
                        <div class="input-group date" >
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" id="datepicker2" name="lb_dt_exp_cert_ng" value="{{$labs->lab->lb_dt_exp_cert_ng}}">
                        </div>
                    </div>
                </div>
                
                <div class="form-group" id="int1">
                    <label class="col-sm-2 control-label">International Certification:</label>
                    <div class="col-sm-10">  
                        <select class="form-control" id="int_cert" name="int_cert" style="width: 100%;">
                                <option value="">--Choose one--</option>
                        </select>                  
                    </div>
                </div>
                <div class="form-group" id="int2">
                    <label class="col-sm-2 control-label">Certification Date:</label>
                    <div class="col-sm-4">
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                        <input type="text" class="form-control pull-right" id="datepicker3" name="lb_dt_cert_int" value="{{$labs->lab->lb_dt_cert_int}}">
                        </div>
                    </div>
                    <label class="col-sm-2 control-label">Expiration Date:</label>
                    <div class="col-sm-4">
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" id="datepicker4" name="lb_dt_exp_cert_int" value="{{$labs->lab->lb_dt_exp_cert_int}}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">External Quality Assurance Enrolment:</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="lb_enrol" name="lb_enrol" style="width: 100%;">
                            <option value="">--Choose one--</option>
                            <option value="1">Enrolled</option>
                            <option value="2">Not Enrolled</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Specialized Laboratory Equipment:</label>
                    <div class="col-sm-10">
                        <select class="form-control select2" id="lab_equip" name="lab_equip[]" multiple="multiple" style="width: 100%;">
                            <option value="">--Choose one--</option>
                            
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label">Laboratory Scientists:</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control"  id="lb_hr" name="lb_hr" value="{{$labs->lab->lb_hr}}">                    
                    </div>
                    <label class="col-sm-2 control-label">Laboratory Technicians:</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control"  id="lb_lab_tech" name="lb_lab_tech" value="{{$labs->lab->lb_lab_tech}}">                    
                    </div>
                </div>
                
            </div>
        </div>
    </div><!-- end here-->
    
    
</div>

<!-- /.box-body -->
<div class="box-footer">
    <a href="/lab">
        <button type="button" class="btn btn-danger">Return Back</button>
    </a>
</div>
<!-- /.box-footer -->
</form>

@endsection 

@push('bk_script')
@include('partials.dynamic_state_script')

<script>
    $(document).ready(function () {
        //Date picker
        $('#datepicker1').datepicker({
            autoclose: true            
        })
        $('#datepicker2').datepicker({
            autoclose: true            
        })
        $('#datepicker3').datepicker({
            autoclose: true            
        })
        $('#datepicker4').datepicker({
            autoclose: true            
        })

        //fill lab equipments
        var vals = "{{$labs->lab->lb_eq_id}}";
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url:"{{route('lab.fetchEquips')}}",
            method:"POST",
            data:{_token:_token},
            success:function(result)
            {
                $('#lab_equip').html(result);
                $('#lab_equip').val(vals.split(','));
            }         
        })
        //fill certification national
        $.ajax({
            url:"{{route('lab.fetchCert')}}",
            method:"POST",
            data:{type:1,_token:_token},
            success:function(result)
            {
                $('#nat_cert').html(result);
                $("#nat_cert").val("{{$labs->lab->lb_cert_ng_type}}");
            }         
        })
         //fill certification international
         $.ajax({
            url:"{{route('lab.fetchCert')}}",
            method:"POST",
            data:{type:2,_token:_token},
            success:function(result)
            {
                $('#int_cert').html(result);
                $("#int_cert").val("{{$labs->lab->lb_cert_int_type}}");
            }         
        })
      //fill lgas
      var state1 = "{{$labs->state}}";
        var lga1 = "{{$labs->lga}}";
        $("#state").val(state1);

      if(state1 != '')
        {
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url:"{{route('sign.fetchLga')}}",
                method:"POST",
                data:{id:state1, _token:_token},
                success:function(result)
                {
                    $('#lga').html(result);
                    $("#lga").val(lga1);
                }         
            })
        }
        //fill wards
        if(lga1 != '')
        {
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url:"{{route('sign.fetchWards')}}",
                method:"POST",
                data:{lgaId:lga1,stateId:state1, _token:_token},
                success:function(result)
                {
                    $('#ward').html(result);
                    $("#ward").val("{{$labs->ward}}");
                }         
            })
        }

        $("#hr_operation").val("{{$labs->hr_operation}}");
        
        var values = "{{$labs->operational_days}}";
        $('#opsdays').val(values.split(','));
        
        
        $("#hs_ownership").val("{{$labs->lab->lb_owner}}");
        $("#hs_op_status").val("{{$labs->lab->lb_op_status}}");
        $("#hs_reg_status").val("{{$labs->lab->lb_reg_status}}");
        $("#hs_lic_status").val("{{$labs->lab->lb_lic_status}}");
        $("#lb_acc_status").val("{{$labs->lab->lb_acc_status}}");
        $("#hs_level").val("{{$labs->lab->lb_level}}");
        $("#lb_state").val("{{$labs->lab->lb_state}}");
        $("#lb_enrol").val("{{$labs->lab->lb_enrol}}");

        //fill ownership type
        if("{{$labs->lab->lb_owner}}"!="")
        {    
            $('#hs_ownership_type option').val('{{$labs->lab->lb_owner_type}}').html('{{$labs->lab->lb_owner_type}}');                
        }
        // checkbox national
        if("{{$labs->lab->lb_cert_ng}}"=="1")
        {   
            $("#national").prop('checked',true);
        }
         // checkbox international
         if("{{$labs->lab->lb_cert_int}}"=="1")
        {   
            $("#international").prop('checked',true);
        }
        
        
        
        /* hours of operatoins */
        $("#hr_operation").change(function(){
            if($(this).val()=="24 hours")
            {    
                $("#operational_hours").attr("disabled", "disabled"); 
                $("#operational_hours").val("");         
            }else       
            {
                $("#operational_hours").removeAttr("disabled");   
            }
        });
        
        //ownership types
        $("#hs_ownership").change(function(){
            if($(this).val()=="1")//public
            {    
                $('#hs_ownership_type option').remove();
                var myOptions = {
                    '' : 'Select Option',
                    'Local Government' : 'Local Government',
                    'State Government' : 'State Government',
                    'Federal Government':'Federal Government',
                    'Military & Paramilitary formations':'Military & Paramilitary formations'
                };
                var mySelect = $('#hs_ownership_type');
                $.each(myOptions, function(val, text) {
                    mySelect.append(
                    $('<option></option>').val(val).html(text)
                    );
                });
                
            }else //private
            {
                $('#hs_ownership_type option').remove();
                var myOptions = {
                    '' : 'Select Option',
                    'For Profit' : 'For Profit',
                    'Not For Profit' : 'Not For Profit'
                };
                var mySelect = $('#hs_ownership_type');
                $.each(myOptions, function(val, text) {
                    mySelect.append(
                    $('<option></option>').val(val).html(text)
                    );
                });     
            }
        });
        
        //national checkbox
        $('#national').change(function(){
        if(this.checked)
            $("#national").val("1");
        else
            $("#national").val("0");
        });
          //international checkbox
          $('#international').change(function(){
        if(this.checked)
            $("#international").val("1");
        else
            $("#international").val("0");
        });

        /* hours of operatoins */
        $("#hr_operation").change(function(){
            if($(this).val()=="24 hours")
            {    
                $("#operational_hours").attr("disabled", "disabled"); 
                $("#operational_hours").val("");         
            }else       
            {
                $("#operational_hours").removeAttr("disabled");   
            }
        });
        
        
        
        //ownership types
        $("#hs_ownership").change(function(){
            if($(this).val()=="1")//public
            {    
                $('#hs_ownership_type option').remove();
                var myOptions = {
                    '' : 'Select Option',
                    'Local Government' : 'Local Government',
                    'State Government' : 'State Government',
                    'Federal Government':'Federal Government',
                    'Military & Paramilitary formations':'Military & Paramilitary formations'
                };
                var mySelect = $('#hs_ownership_type');
                $.each(myOptions, function(val, text) {
                    mySelect.append(
                    $('<option></option>').val(val).html(text)
                    );
                });
                
            }else       //private
            {
                $('#hs_ownership_type option').remove();
                var myOptions = {
                    '' : 'Select Option',
                    'For Profit' : 'For Profit',
                    'Not For Profit' : 'Not For Profit'
                };
                var mySelect = $('#hs_ownership_type');
                $.each(myOptions, function(val, text) {
                    mySelect.append(
                    $('<option></option>').val(val).html(text)
                    );
                });     
            }
        });
         //national certification
        $('#national').change(function(){
        if(this.checked){
             $("#nat1").show(); 
             $("#nat2").show();
        } 
        else{
            $("#nat1").hide(); 
            $("#nat2").hide(); 
            $("#nat_cert").val("");
            $("#datepicker1").val("");
            $("#datepicker2").val("");
        }
        });
        //international certification
        $('#international').change(function(){
        if(this.checked){
             $("#int1").show(); 
             $("#int2").show();
        } 
        else{
            $("#int1").hide(); 
            $("#int2").hide(); 
            $("#int_cert").val("");
            $("#datepicker4").val("");
            $("#datepicker3").val("");
        }
        });
        
        $("input[type=text]").prop('disabled', true);
        $('select').prop("disabled", true);
        $('input[type=checkbox]').attr('disabled','true');
    })
    
</script>

@endpush