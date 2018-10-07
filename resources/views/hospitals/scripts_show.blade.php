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
                url:"{{route('hosp.fetchLga')}}",
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
                url:"{{route('hosp.fetchWards')}}",
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
        
        
     
        $("input[type=text]").prop('disabled', true);
        $('select').prop("disabled", true);
        $('input[type=checkbox]').attr('disabled','true');
    });
</script>