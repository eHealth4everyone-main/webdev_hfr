<div class="form-group">
    <label class="col-sm-2 control-label">Out-Patient Services:</label>
    <div class="col-sm-4">
        <select class="form-control input-sm" id="opd" name="opd" style="width: 100%;">
            <option value="No">No</option>
            <option value="Yes">Yes</option>
        </select>
    </div>
    <label class="col-sm-2 control-label">In-Patient Services:</label>
    <div class="col-sm-4">
        <select class="form-control input-sm" id="ipd" name="ipd" style="width: 100%;">
            <option value="No">No</option>
            <option value="Yes">Yes</option>
        </select>
    </div>
</div>
<div class="panel panel-default" id="opd1" style="display:none">
    <div class="panel-heading">Out-Patient Services</div>
    <div class="panel-body">
        
        {{-- Medical --}}
        <div class="form-group"> 
            <div class="col-sm-12">
                <div class="row"> {{-- medical --}}
                    <div class="col-sm-3">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="medical" value="1" id="medical_chk"> Medical
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <div class="panel panel-info" id="med_panel" style="display:none">
                            <div class="row">  {{-- row one --}}
                                <div class="col-sm-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="medicals[]" value="Cardiology"> Cardiology
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="medicals[]" value="Gastroenterology"> Gastroenterology
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="medicals[]" value="Nephrology"> Nephrology
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">{{-- row 2 --}}
                                <div class="col-sm-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="medicals[]" value="Dermatology"> Dermatology 
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="medicals[]" value="Hematology"> Hematology
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="medicals[]" value="Endocrinology"> Endocrinology
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">{{-- row 3 --}}
                                <div class="col-sm-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="medicals[]" value="Geriatrics"> Geriatrics
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="medicals[]" value="Psychiatry/Behavioral Medicine"> Psychiatry/ Behavioral Medicine
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="medicals[]" value="Pulmonology"> Pulmonology
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">{{-- row 4 --}}
                                <div class="col-sm-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="medicals[]" value="Neurology"> Neurology
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="medicals[]" value="Infectious Diseases"> Infectious Diseases
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="medicals[]" value="Nuclear Medicine"> Nuclear Medicine
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">{{-- row 5 --}}
                                <div class="col-sm-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="medicals[]" value="Family Medicine"> Family Medicine
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>{{--Panel info for medical --}}
                        
                    </div>
                </div>                
            </div>  
        </div>{{--form group1 --}}
        
        {{-- Sugical --}}
        <div class="form-group"> 
            <div class="col-sm-12">
                <div class="row"> {{-- --}}
                    <div class="col-sm-3">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="surgical" value="1" id="surgical_chk"> Surgical
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <div class="panel panel-info" id="surgical_panel" style="display:none">
                            <div class="row">  {{-- row one --}}
                                <div class="col-sm-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="surgicals[]" value="Ophthalmology"> Ophthalmology
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="surgicals[]" value="General Surgery"> General Surgery
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="surgicals[]" value="Cardiothoracic Surgery"> Cardiothoracic Surgery
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">{{-- row 2 --}}
                                <div class="col-sm-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="surgicals[]" value="Neuro-Surgery"> Neuro-Surgery 
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="surgicals[]" value="Orthopedic Surgery"> Orthopedic Surgery
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="surgicals[]" value="Urology"> Urology
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">{{-- row 3 --}}
                                <div class="col-sm-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="surgicals[]" value="Otorhinolaryngology(ENT)"> Otorhinolaryngology(ENT)
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="surgicals[]" value="Anesthesia"> Anesthesia
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="surgicals[]" value="Oncology/Radiotherap"> Oncology/Radiotherapy
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">{{-- row 4 --}}
                                <div class="col-sm-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="surgicals[]" value="Radiology"> Radiology
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="surgicals[]" value="Vascular Surgery"> Vascular Surgery
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="surgicals[]" value="Pediatric Surgery"> Pediatric Surgery
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">{{-- row 5 --}}
                                <div class="col-sm-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="surgicals[]" value="Plastic Surgery"> Plastic Surgery 
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="surgicals[]" value="Pediatric Surgery">  Pediatric Surgery
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="surgicals[]" value="Pathology"> Pathology
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>{{--Panel info for surgical--}}
                        
                    </div>
                </div>                
            </div>  
        </div>{{--form group2 --}}
        
        {{--  --}}
        <div class="form-group"> 
            <div class="col-sm-12">
                <div class="row"> 
                    <div class="col-sm-3">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="Obs_gy" value="1" id="obs_chk"> Obstetrics and Gynecology
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <div class="panel panel-info" id="obs_panel" style="display:none">
                            <div class="row">  {{-- row one --}}
                                <div class="col-sm-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="obs[]" value="Obstetrics"> Obstetrics
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="obs[]" value="Gynecology"> Gynecology
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="obs[]" value="Fertility/Assisted Reproductive Techniques"> Fertility/Assisted Reproductive Techniques
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                        </div>{{--Panel info for obs--}}
                        
                    </div>
                </div>                
            </div>  
        </div>{{--form group 3 --}}
        
        {{-- Pediatrics--}}
        <div class="form-group"> 
            <div class="col-sm-12">
                <div class="row"> 
                    <div class="col-sm-3">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="Pediatric" value="1" id="pedi_chk"> Pediatrics
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <div class="panel panel-info" id="pedi_panel" style="display:none">
                            <div class="row">  {{-- row one --}}
                                <div class="col-sm-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="Pediatrics[]" value="Gastroenterology"> Gastroenterology
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="Pediatrics[]" value="Pulmonology"> Pulmonology
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="Pediatrics[]" value="Nephrology"> Nephrology
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">  {{-- row Two --}}
                                <div class="col-sm-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="Pediatrics[]" value="Neonatology"> Neonatology
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="Pediatrics[]" value="Endocrinology"> Endocrinology
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="Pediatrics[]" value="Oncology"> Oncology
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">  {{-- row 3 --}}
                                <div class="col-sm-6">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="Pediatrics[]" value="Child Psychiatry"> Child Psychiatry/Behavioral Medicine
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>{{--Panel info for obs--}}
                        
                        
                    </div>
                </div>                
            </div>  
        </div>{{--form group 4 --}}
        
        {{-- Dentals--}}
        <div class="form-group"> 
            <div class="col-sm-12">
                <div class="row"> 
                    <div class="col-sm-3">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="dental" value="1" id="dental_chk"> Dental
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <div class="panel panel-info" id="dental_panel" style="display: none">
                            <div class="row">  {{-- row one --}}
                                <div class="col-sm-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="dentals[]" value="Oral and Maxillo-Facial Surgery"> Oral and Maxillo-Facial Surgery
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="dentals[]" value="Periodontics"> Periodontics
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                        </div>{{--Panel info for dental--}}
                        
                        
                    </div>
                </div>                
            </div>  
        </div>{{--form group 5 --}}
        
    </div>{{-- panel body 1--}}
</div>{{-- panel info 1--}}



<div class="panel panel-default" id="ipd1" style="display:none">
    <div class="panel-heading">In-Patient Services</div>
    <div class="panel-body">
        
        <div class="form-group"> 
            <div class="col-sm-12">
                <div class="row"> 
                    <div class="col-sm-3">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="hs_inpatient_acc_and_emg" value="Yes" id="acc_emg_chk"> Accidents and Emergency
                            </label>
                        </div>
                    </div>
                    <div class="form-group">   
                        <label for="hs_no_pharm" class="col-sm-2 control-label">Number of Beds:</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control input-sm"  id="acc_emg_txt" name="hs_inpatient_acc_and_emg_num" value="0" disabled>
                        </div>
                    </div>
                    
                </div>  

                <div class="row"> 
                    <div class="col-sm-3">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="hs_inpatient_adm_fac" value="Yes" id="adm_fac_chk"> Admission Facilities
                            </label>
                        </div>
                    </div>
                    <div class="form-group">   
                        <label for="hs_no_pharm" class="col-sm-2 control-label">Number of Beds:</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control input-sm"  id="adm_fac_txt" name="hs_inpatient_adm_fac_num" value="0" disabled>
                        </div>
                    </div>
                    
                </div>   

                <div class="row"> 
                    <div class="col-sm-3">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="hs_inpatient_int_care_service" id="int_care_chk" value="Yes"> Intensive Care Unit
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group">   
                        <label for="hs_no_pharm" class="col-sm-2 control-label">Number of Beds:</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control input-sm"  id="int_care_txt" name="hs_inpatient_int_care_service_num" value="0" disabled>
                        </div>
                        
                        
                    </div>
                </div> 
                
            </div>  
        </div>{{--form group 5 --}}
        
    </div>
</div>

{{--Specific Clinical Service--}}
<div class="panel panel-default">
    <div class="panel-heading">Specific Clinical Service</div>
    <div class="panel-body">
        <div class="form-group"> 
            <div class="col-sm-12">
                <div class="row"> 
                    <div class="col-sm-4">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="clinical[]"  value="ANC" id="ANC"> Antenatal Care(ANC)
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="clinical[]" value="Immunization" id="Immunization"> Immunization
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="clinical[]" value="HIV" id="HIV"> HIV/ AIDS Services
                            </label>
                        </div>
                    </div>
                </div>  
                <div class="row"> 
                    <div class="col-sm-4">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="clinical[]" value="TB" id="TB"> Tuberculosis
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="clinical[]" value="NCD" id="NCD"> Non Communicable Diseases
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="clinical[]" value="FP" id="FP"> Family Planning
                            </label>
                        </div>
                    </div>
                </div>      
            </div>  
        </div>{{--form group 5 --}}
    </div>
</div>

{{--other services, onsite..--}}
<div class="panel panel-default">
    <div class="panel-heading">Other Services</div>
    <div class="panel-body">
        
        <div class="form-group"> 
            <div class="col-sm-12">
                <div class="row"> 
                    <div class="col-sm-3">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="hs_onsite_pharm" value="No" id="pharm_chk"> Onsite Pharmacy
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="hs_onsite_lab" value="No"  id="lab_chk"> Onsite Laboratory
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="hs_onsite_radio" value="No"  id="radio_chk"> Onsite Imaging/ Radio Diagnostics Center
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="hs_mort_service" value="No" id="mort_chk"> Mortuary Services
                            </label>
                        </div>
                    </div>
                </div>  

 
                
            </div>  
        </div>{{--form group 5 --}}
        
    </div>
</div>