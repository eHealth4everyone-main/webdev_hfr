<script>
    $(document).ready(function(){
        
        var state1 = "{{$hosp->state}}";
        var lga1 = "{{$hosp->lga}}";
        
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
                    $("#ward").val("{{$hosp->ward}}");
                }         
            })
        }
         
        $("#hr_operation").val("{{$hosp->hr_operation}}");
        
        var values = "{{$hosp->operational_days}}";
        $('#opsdays').val(values.split(','));
        
        $("#hs_level").val("{{$hosp->hospital->hs_level}}");
        $("#hs_ownership").val("{{$hosp->hospital->hs_ownership}}");
        $("#hs_op_status").val("{{$hosp->hospital->hs_op_status}}");
        $("#hs_reg_status").val("{{$hosp->hospital->hs_reg_status}}");
        $("#hs_lic_status").val("{{$hosp->hospital->hs_lic_status}}");
        
        if("{{$hosp->hospital->hs_inpatient_adm_fac}}"=="Yes"){
            $("#adm_fac_chk").prop('checked',true);
            $("#adm_fac_txt").removeAttr("disabled"); 
        }
        if("{{$hosp->hospital->hs_inpatient_int_care_service}}"=="Yes"){
            $("#int_care_chk").prop('checked',true);
            $("#int_care_txt").removeAttr("disabled"); 
        }
        if("{{$hosp->hospital->hs_inpatient_acc_and_emg}}"=="Yes"){
            $("#acc_emg_chk").prop('checked',true);
            $("#acc_emg_txt").removeAttr("disabled"); 
        }
        //opd and ipd services show
        if("{{$hosp->hospital->hs_service_type_outpatient}}"=="Yes"){
            $("#opd").val("Yes");
            $("#opd1").show();
        }
        if("{{$hosp->hospital->hs_service_type_inpatient}}"=="Yes"){
            $("#ipd").val("Yes"); 
            $("#ipd1").show();
        }
        //dental fill
        if("{{$hosp->hospital->hs_outpatient_medical}}"!=""){
            $("#medical_chk").prop('checked',true);
            $("#med_panel").show();
            var value = "{{$hosp->hospital->hs_outpatient_medical}}";
            var values = value.split(',');
            
            $.each(values, function( index, value ) {
                $("#"+value).prop('checked',true);
            });
        }
        //fill surgical
        if("{{$hosp->hospital->hs_outpatient_surgery}}"!=""){
            $("#surgical_chk").prop('checked',true);
            $("#surgical_panel").show();
            var value = "{{$hosp->hospital->hs_outpatient_surgery}}";
            var values = value.split(',');
            
            $.each(values, function( index, value ) {
                $("#"+value).prop('checked',true);
            });
        }
        //fill obs
        if("{{$hosp->hospital->hs_outpatient_obstetrics}}"!=""){
            $("#obs_chk").prop('checked',true);
            $("#obs_panel").show();
            var value = "{{$hosp->hospital->hs_outpatient_obstetrics}}";
            var values = value.split(',');
            
            $.each(values, function( index, value ) {
                $("#"+value).prop('checked',true);
            });
        }
        //fill pediatrics
        if("{{$hosp->hospital->hs_outpatient_pediatrics}}"!=""){
            $("#pedi_chk").prop('checked',true);
            $("#pedi_panel").show();
            var value = "{{$hosp->hospital->hs_outpatient_pediatrics}}";
            var values = value.split(',');
            
            $.each(values, function( index, value ) {
                $("#"+value).prop('checked',true);
            });
        }
        //fill dental
        if("{{$hosp->hospital->hs_outpatient_dental}}"!=""){
            $("#dental_chk").prop('checked',true);
            $("#dental_panel").show();
            var value = "{{$hosp->hospital->hs_outpatient_dental}}";
            var values = value.split(',');
            
            $.each(values, function( index, value ) {
                $("#"+value).prop('checked',true);
            });
        }
        //fill specific clinical services
        if("{{$hosp->hospital->hs_specific_clinical_services}}"!=""){
            var value = "{{$hosp->hospital->hs_specific_clinical_services}}";
            var values = value.split(',');
            
            $.each(values, function( index, value ) {
                $("#"+value).prop('checked',true);
            });
        }
        //fill ownership type
        if("{{$hosp->hospital->hs_ownership_type}}"!="")
        {    
            $('#hs_ownership_type option').val('{{$hosp->hospital->hs_ownership_type}}').html('{{$hosp->hospital->hs_ownership_type}}');                
        } 
        //fill hosp level options
        if("{{$hosp->hospital->hs_level_option}}"!="")
        {    
            var opt = "{{$hosp->hospital->hs_level_option}}";
            if(opt=="01"){
                $('#hs_level_option option').val(opt).html('Health Post'); 
            }
            else if(opt=="02"){
                $('#hs_level_option option').val(opt).html('Primary Health Clinic'); 
            }
            else if(opt=="03"){
                $('#hs_level_option option').val(opt).html('Primary Health Centre'); 
            }
            else if(opt=="05"){
                $('#hs_level_option option').val(opt).html('Teaching Hospital'); 
            }   
            else{
                $('#hs_level_option option').val(opt).html('Specialized Hospital'); 
            }   
            $('#fac_option1').show();
            $('#fac_option2').show(); 
        } 
        //fill specialized option
        if("{{$hosp->hospital->hs_sp_option}}"!="")
        {    
            $('#hs_sp_option').val("{{$hosp->hospital->hs_sp_option}}");       
            $('#specialized').show(); 
        }
        
    
 
        
        $("#opd").change(function(){
            if($(this).val()=="Yes")
            {    
                $("#opd1").show();
            }else
            {
                $("#opd1").hide();
            }
        });
        
        $("#ipd").change(function(){
            if($(this).val()=="Yes")
            {    
                $("#ipd1").show();
            }else
            {
                $("#ipd1").hide();
            }
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
        /* facility level options */
        $("#hs_level").change(function(){
            if($(this).val()=="1") //primary
            {    
                $('#hs_level_option option').remove();
                $('#specialized').hide();
                $('#fac_option1').show();
                $('#fac_option2').show();
                
                var myOptions = {
                    '' : 'Select Option',
                    '01' : 'Health Post',
                    '02' : 'Primary Health Clinic',
                    '03' : 'Primary Health Centre'
                };
                var mySelect = $('#hs_level_option');
                $.each(myOptions, function(val, text) {
                    mySelect.append(
                    $('<option></option>').val(val).html(text)
                    );
                });
                
            }else if ($(this).val()=="2") //secondary
            {
                $('#hs_level_option option').remove();
                $('#specialized').hide();
                $('#fac_option1').hide();
                $('#fac_option2').hide();
                
            }
            else{ //tetiary
                $('#hs_level_option option').remove();
                $('#fac_option1').show();
                $('#fac_option2').show();
                var myOptions = {
                    '' : 'Select Option',
                    '05' : 'Teaching Hospital',
                    '06' : 'Specialized Hospital'
                };
                var mySelect = $('#hs_level_option');
                $.each(myOptions, function(val, text) {
                    mySelect.append(
                    $('<option></option>').val(val).html(text)
                    );
                });
            }
        });
        
        /* if Specialized Hospital */
        $("#hs_level_option").change(function(){
            if($(this).val()=="06")
            {    
                $('#specialized').show();
                
            }else       
            {
                $('#specialized').hide();         
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
        //medicals group
        $('#medical_chk').change(function(){
            if(this.checked)
            $('#med_panel').show();
            else
            $('#med_panel').hide();
        });
        //surgical group
        $('#surgical_chk').change(function(){
            if(this.checked)
            $('#surgical_panel').show();
            else
            $('#surgical_panel').hide();
        });
        //obs and gyner group
        $('#obs_chk').change(function(){
            if(this.checked)
            $('#obs_panel').show();
            else
            $('#obs_panel').hide();
        });
        //Pediatrics group
        $('#pedi_chk').change(function(){
            if(this.checked)
            $('#pedi_panel').show();
            else
            $('#pedi_panel').hide();
        });
        //dental group
        $('#dental_chk').change(function(){
            if(this.checked)
            $('#dental_panel').show();
            else
            $('#dental_panel').hide();
        });
        //inpatient accident and emergency group
        $('#acc_emg_chk').change(function(){
            if(this.checked)
            $("#acc_emg_txt").removeAttr("disabled"); 
            else
            $("#acc_emg_txt").attr("disabled", "disabled");
            $("#acc_emg_txt").val(0);
        });
        //inpatient admintion facilities
        $('#adm_fac_chk').change(function(){
            if(this.checked)
            $("#adm_fac_txt").removeAttr("disabled"); 
            else
            $("#adm_fac_txt").attr("disabled", "disabled");
            $("#adm_fac_txt").val(0);
        });
        //inpatient admintion facilities
        $('#int_care_chk').change(function(){
            if(this.checked)
            $("#int_care_txt").removeAttr("disabled"); 
            else
            $("#int_care_txt").attr("disabled", "disabled");
            $("#int_care_txt").val(0);
        });
        
        //******other services checkboxes***
        $('#pharm_chk').change(function(){
            if(this.checked)
            $("#pharm_chk").val("Yes");
            else
            $("#pharm_chk").val("No");
        });
        $('#lab_chk').change(function(){
            if(this.checked)
            $("#lab_chk").val("Yes");
            else
            $("#lab_chk").val("No");
        });
        $('#radio_chk').change(function(){
            if(this.checked)
            $("#radio_chk").val("Yes");
            else
            $("#radio_chk").val("No");
        });
        $('#mort_chk').change(function(){
            if(this.checked)
            $("#mort_chk").val("Yes");
            else
            $("#mort_chk").val("No");
        });
        
        if("{{$hosp->hospital->hs_onsite_pharm}}"=="Yes"){
            $("#pharm_chk").prop('checked',true);
        }
        if("{{$hosp->hospital->hs_onsite_lab}}"=="Yes"){
            $("#lab_chk").prop('checked',true);
        }
        if("{{$hosp->hospital->hs_onsite_radio}}"=="Yes"){
            $("#radio_chk").prop('checked',true);
        }
        if("{{$hosp->hospital->hs_mort_service}}"=="Yes"){
            $("#mort_chk").prop('checked',true);
        }
        
        
        
    });
</script>