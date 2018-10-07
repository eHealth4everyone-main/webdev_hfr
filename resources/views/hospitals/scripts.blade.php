<script>
    $(document).ready(function(){
        
        
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


    });
</script>