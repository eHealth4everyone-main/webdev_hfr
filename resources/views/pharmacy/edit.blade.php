@extends("layouts.master")

@section('content-title')
<h4> <p class="text-aqua">Unique ID: {{$pharma->sig_unique_id}}</p></h4>
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

<form class="form-horizontal" action="/pharma/{{$pharma->id}}" method="POST">
    @csrf
    @method("PUT")
    
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        {{-- Tab One   --}}
        <div class="panel panel-primary">
            <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Edit Pharmaceutical
                    </a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                    <div class="box-body">
                        
                        <div class="form-group">
                            <label for="cac_reg" class="col-sm-2 control-label">Registration No:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  id="cac_reg" name="cac_reg" value="{{$pharma->cac_reg}}" placeholder="Corporate Affairs Registration Number">
                            </div>
                            
                            <label class="col-sm-2 control-label">Commencement Date:</label>
                            <div class="col-sm-4">
                                <div class="input-group date" >
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right" id="datepicker"  value="{{$pharma->comm_date}}" name="comm_date">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="reg_fac_name" class="col-sm-2 control-label">Registered Name: <font color="red">*</font> </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  id="reg_fac_name"  name="reg_fac_name" value="{{$pharma->reg_fac_name}}" placeholder="Registered Facility Name">
                            </div>
                            
                            <label for="alt_facility_name" class="col-sm-2 control-label">Alternate Name:</label> 
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  id="alt_facility_name" name="alt_facility_name" value="{{$pharma->alt_facility_name}}" placeholder="Alternate Facility Name">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-2 control-label">State:<font color="red">*</font> </label></label>
                            <div class="col-sm-4">
                                <select class="form-control select2" id="state" name ="state">
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
                                <select class="form-control select2" id="lga" name="lga">
                                    <option value="">--Select LGA--</option>
                                </select>
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Ward:</label>
                            <div class="col-sm-10">
                                <select class="form-control select2" id="ward" name="ward">
                                    <option value="">--Select Ward--</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="house_no" class="col-sm-2 control-label">House Number:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  id="house_no" name="house_no" value="{{$pharma->house_no}}">
                            </div>
                            
                            <label for="street_name" class="col-sm-2 control-label">Street Name:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  id="street_name"  name="street_name" value="{{$pharma->street_name}}">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="latitude" class="col-sm-2 control-label">Latitude:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  id="latitude" name="latitude"  value="{{$pharma->latitude}}">
                            </div>
                            
                            <label for="longitude" class="col-sm-2 control-label">Longitude:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  id="longitude" name="longitude" value="{{$pharma->longitude}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="postal_address" class="col-sm-2 control-label">Postal Address:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  id="postal_address"  name="postal_address" value="{{$pharma->postal_address}}">
                            </div>
                            
                            <label for="phone_number" class="col-sm-2 control-label">Phone Number:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  id="phone_number" name="phone_number"  value="{{$pharma->phone_number}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email_address" class="col-sm-2 control-label">Email Address:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  id="email_address" name="email_address" value="{{$pharma->email_address}}">
                            </div>
                            
                            <label for="website" class="col-sm-2 control-label">Website:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  id="website" name="website" value="{{$pharma->website}}">
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
                            <input type="text" class="form-control"  id="operational_hours" name="operational_hours" value="" placeholder="08:00AM-06:00PM" disabled>
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
                            <input type="text" class="form-control"  id="hs_ownership_details" name="hs_ownership_details" value="{{$pharma->pharma->ownership_detail}}">
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
                        <label class="col-sm-2 control-label">Category of Outlet:</label>
                        <div class="col-sm-4">
                            <select class="form-control select2" id="pharmacy_category" name="pharmacy_category" style="width: 100%;">
                                <option value="">--Choose one--</option>
                                <option value="Manufacturing">Manufacturing</option>
                                <option value="Wholesale">Wholesale</option>
                                <option value="Retail">Retail</option>
                                <option value="Importation">Importation</option>
                                <option value="PPMV">Patent and Proprietary Medicine Vendors</option>
                                <option value="Hospital">Hospital</option>
                                <option value="Distribution">Distribution</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Institution/ Stand Alone Premises:<font color="red">*</font> </label>
                        <div class="col-sm-4">
                            <select class="form-control select2" id="standalone" name="standalone" style="width: 100%;">
                                <option value="">--Choose one--</option>
                                <option value="1">Standalone</option>
                                <option value="0">Institution</option>
                            </select>
                        </div>
                        <label class="col-sm-2 control-label">PCN Registration Number:</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control"  id="ph_reg_no" name="ph_reg_no" value="{{$pharma->pharma->ph_reg_no}}" placeholder="Pharmacists Council of Nigeria Reg No">                        
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="hs_no_single_qualified_nurses" class="col-sm-2 control-label">Number of Pharmacists:</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control input-sm"  id="ph_num_pharmacist" name="ph_num_pharmacist"  value="{{$pharma->pharma->ph_num_pharmacist}}">
                        </div>
                        <label for="hs_no_lab_sc" class="col-sm-2 control-label">Number of Pharmacy Technicians:</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control input-sm"  id="ph_num_pharm_tech" name="ph_num_pharm_tech" value="{{$pharma->pharma->ph_num_pharm_tech}}">
                        </div>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>
    
    
    
</div>

<!-- /.box-body -->
<div class="box-footer">
    <a href="/pharma">
        <button type="button" class="btn btn-danger">Cancel</button>
    </a>
    <button type="submit" class="btn btn-primary pull-right">Update Record</button>
</div>
<!-- /.box-footer -->
</form>

@endsection 

@push('bk_script')

@include('partials.dynamic_state_script')
@include('partials.notification')

<script>
    $(document).ready(function(){
        var state1 = "{{$pharma->state}}";
        var lga1 = "{{$pharma->lga}}";
        
        $("#state").val(state1);
        //fill lgas
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
                    $("#ward").val("{{$pharma->ward}}");
                }         
            })
        }
        
        
        $("#hr_operation").val("{{$pharma->hr_operation}}");
        
        var values = "{{$pharma->operational_days}}";
        
        $('#opsdays').val(values.split(','));
        
        
        $("#hs_ownership").val("{{$pharma->pharma->ownership}}");
        $("#hs_op_status").val("{{$pharma->pharma->ph_op_status}}");
        $("#hs_reg_status").val("{{$pharma->pharma->ph_reg_status}}");
        $("#hs_lic_status").val("{{$pharma->pharma->ph_lic_status}}");
        $("#pharmacy_category").val("{{$pharma->pharma->pharmacy_category}}");
        $("#standalone").val("{{$pharma->pharma->standalone}}");
        
        
        //fill ownership type
        if("{{$pharma->pharma->ownership_type}}"!="")
        {    
            $('#hs_ownership_type option').val('{{$pharma->pharma->ownership_type}}').html('{{$pharma->pharma->ownership_type}}');                
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
        
        
    });
</script>


@endpush