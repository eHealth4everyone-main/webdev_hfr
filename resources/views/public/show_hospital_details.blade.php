@extends("layouts.pub.master")



@section("content")
 
    <div class="event-area section-padding event-page">
        <div class="container">
            <div class="row">
                <div class="single-event-text">
                      
                        <div class="row">
                            
                            <label class="col-sm-3 " style="text-align: right;">Unique ID:</label>                            
                            <div class="col-sm-3">
                                {{$hosp[0]->unique_id}}
                            </div>
                            
                          
                        </div>
                        <div class="row">
                            
                            <label class="col-sm-3 " style="text-align: right;">Registered No:</label>                            
                            <div class="col-sm-3">
                                {{$hosp[0]->registration_no}}
                            </div>
                            
                            <label class="col-sm-3 " style="text-align: right;">Commencement Date:</label>
                            <div class="col-sm-3">
                                {{$hosp[0]->start_date}}
                            </div>
                        </div>
                        
                        <div class="row">
                            <label class="col-sm-3" style="text-align: right;">Registered Name:</label>
                            <div class="col-sm-3">
                                {{$hosp[0]->facility_name}}
                            </div>
                            
                            <label for="alt_facility_name" class="col-sm-3 " style="text-align: right;">Alternate Name:</label> 
                            <div class="col-sm-3">
                                {{$hosp[0]->alt_facility_name}}
                            </div>
                        </div>
                        
                        <div class="row">
                            <label class="col-sm-3 " style="text-align: right;">State: </label></label>
                            <div class="col-sm-3">
                                {{$hosp[0]->state}}
                            </div>
                            
                            <label class="col-sm-3 " style="text-align: right;">LGA:</label></label>
                            <div class="col-sm-3">
                                {{$hosp[0]->lga}}
                            </div>
                            
                        </div>
                        <div class="row">
                            <label class="col-sm-3 " style="text-align: right;">Ward:</label>
                            <div class="col-sm-9">
                                {{$hosp[0]->ward}}
                            </div>
                        </div>
                        
                        <div class="row">
                            <label for="house_no" class="col-sm-3 " style="text-align: right;">House Number:</label>
                            <div class="col-sm-3">
                                {{$hosp[0]->house_no}}
                            </div>
                            
                            <label for="street_name" class="col-sm-3 " style="text-align: right;">Street Name:</label>
                            <div class="col-sm-3">
                                {{$hosp[0]->street_name}}
                            </div>
                        </div>
                        
                        <div class="row">
                            <label for="latitude" class="col-sm-3 " style="text-align: right;">Latitude:</label>
                            <div class="col-sm-3">
                                {{$hosp[0]->latitude}}
                            </div>
                            
                            <label for="longitude" class="col-sm-3 " style="text-align: right;">Longitude:</label>
                            <div class="col-sm-3">
                                {{$hosp[0]->longitude}}
                            </div>
                        </div>
                        <div class="row">
                            <label for="postal_address" class="col-sm-3 " style="text-align: right;">Postal Address:</label>
                            <div class="col-sm-3">
                                {{$hosp[0]->postal_address}}
                            </div>
                            
                            <label for="phone_number" class="col-sm-3 " style="text-align: right;">Phone Number:</label>
                            <div class="col-sm-3">
                                {{$hosp[0]->phone_number}}
                            </div>
                        </div>
                        <div class="row">
                            <label for="email_address" class="col-sm-3 " style="text-align: right;">Email Address:</label>
                            <div class="col-sm-3">
                                {{$hosp[0]->email_address}}
                            </div>
                            
                            <label for="website" class="col-sm-3 " style="text-align: right;">Website:</label>
                            <div class="col-sm-3">
                                {{$hosp[0]->website}}
                            </div>
                        </div>
                        
                        
                        <div class="row">
                            <label class="col-sm-3 " style="text-align: right;">Days of Operation:</label>
                            <div class="col-sm-3">
                                {{$hosp[0]->operational_days}}
                            </div>
                            <label class="col-sm-3 " style="text-align: right;">Hours of Operation:</label>
                            <div class="col-sm-3">
                                {{$hosp[0]->operational_hours}}
                            </div>
                        </div>
                        
                        <div class="row">
                            <label class="col-sm-3 " style="text-align: right;">Hospital/ Clinic Level:</label></label>
                            <div class="col-sm-3">
                                {{$hosp[0]->facility_level}}
                            </div>
                            <label id="level_option_label" class="col-sm-3 " style="text-align: right;" style="display:none">Facility Level Options:</label>
                            <div id="level_option_div" class="col-sm-3" style="display:none">
                                {{$hosp[0]->facility_level_option}}
                            </div>
                        </div>
                        <div class="row" id="specialized_div" style="display:none">
                            <label class="col-sm-3 " style="text-align: right;">Specialized Options:</label>
                            <div class="col-sm-3">
                                
                            </div>
                        </div>
                        
                        <div class="row">
                            <label class="col-sm-3 " style="text-align: right;">Ownership: </label></label>
                            <div class="col-sm-3">
                                {{$hosp[0]->ownership}}
                            </div>
                            <label class="col-sm-3 " style="text-align: right;">Ownership Type:</label>
                            <div class="col-sm-3">
                                {{$hosp[0]->ownership_type}}
                            </div>
                        </div>
                        
                        <div class="row">
                            <label for="hs_ownership_details" class="col-sm-3 " style="text-align: right;">Ownership Details:</label>
                            <div class="col-sm-9">
                                {{$hosp[0]->ownership_details}}
                            </div>
                        </div>
                        
                        <div class="row">
                            <label class="col-sm-3 " style="text-align: right;">Operation Status:</label></label>
                            <div class="col-sm-3">
                                {{$hosp[0]->operation_status}}                           
                            </div>
                            <label class="col-sm-3 " style="text-align: right;">Regulatory Status:</label>
                            <div class="col-sm-3">
                                {{$hosp[0]->regulatory_status}}                                                       
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-3 " style="text-align: right;">License Status:</label>
                            <div class="col-sm-3">
                                {{$hosp[0]->license_status}}                           
                            </div>
                        </div>
                        <div class="row">
                            <label for="hs_no_doctors" class="col-sm-3 " style="text-align: right;">Medical Doctors:</label>
                            <div class="col-sm-3">
                                {{$hosp[0]->doctors}}
                            </div>
                            <label for="hs_no_pharm" class="col-sm-3 " style="text-align: right;">Pharmacists:</label>
                            <div class="col-sm-3">
                                {{$hosp[0]->pharmacists}}
                            </div>
                        </div>
                        <div class="row">
                            <label for="hs_no_dentist" class="col-sm-3 " style="text-align: right;">Dentists:</label>
                            <div class="col-sm-3">
                                {{$hosp[0]->dentist}}
                            </div>
                            <label for="hs_no_pharm_tech" class="col-sm-3 " style="text-align: right;">Pharmacy Technicians:</label>
                            <div class="col-sm-3">
                                {{$hosp[0]->pharmacy_technicians}}
                            </div>
                        </div>
                        <div class="row">
                            <label for="hs_no_single_qualified_nurses" class="col-sm-3 " style="text-align: right;">Nurses (Single):</label>
                            <div class="col-sm-3">
                                {{$hosp[0]->nurses}}
                            </div>
                            <label for="hs_no_lab_sc" class="col-sm-3 " style="text-align: right;">Laboratory Scientists:</label>
                            <div class="col-sm-3">
                                {{$hosp[0]->lab_scientists}}
                            </div>
                        </div>
                        <div class="row">
                            <label for="hs_no_single_qualified_midwives" class="col-sm-3 " style="text-align: right;">Midwifes (Single):</label>
                            <div class="col-sm-3">
                                {{$hosp[0]->midwifes}}
                            </div>
                            <label for="hs_no_lab_tech" class="col-sm-3 " style="text-align: right;">Laboratory Technicians:</label>
                            <div class="col-sm-3">
                                {{$hosp[0]->lab_technicians}}
                            </div>
                        </div> 
                        
                        <div class="row">
                            <label for="hs_nurses_midwives" class="col-sm-3 " style="text-align: right;">Nurse/ Midwife (Double):</label>
                            <div class="col-sm-3">
                                {{$hosp[0]->nurse_midwife}}
                            </div>
                            <label for="hs_no_health_rec" class="col-sm-3 " style="text-align: right;">Health Records/HIM Officers:</label>
                            <div class="col-sm-3">
                                {{$hosp[0]->him_officers}}
                            </div>
                        </div>
                        <div class="row">
                            <label for="hs_no_comm_health_officer" class="col-sm-3 " style="text-align: right;">Community Health Officer:</label>
                            <div class="col-sm-3">
                                {{$hosp[0]->community_health_officer}}
                            </div>
                            <label for="hs_no_comm_health_ext_officer" class="col-sm-3 " style="text-align: right;">Community Health Extension Worker:</label>
                            <div class="col-sm-3">
                                {{$hosp[0]->community_extension_workers}}
                            </div>
                        </div>
                        <div class="row">
                            <label for="hs_no_jun_comm_health_ext_off" class="col-sm-3 " style="text-align: right;">Junior Com Health Extension Worker:</label>
                            <div class="col-sm-3">
                                {{$hosp[0]->jun_community_extension_worker}}
                            </div>
                            <label for="hs_no_dental_tech" class="col-sm-3 " style="text-align: right;">Dental Technicians:</label>
                            <div class="col-sm-3">
                                {{$hosp[0]->dental_technicians}}
                            </div>
                        </div>
                        <div class="row">
                            <label for="hs_no_env_health_officer" class="col-sm-3 " style="text-align: right;">Environmental Health Officers:</label>
                            <div class="col-sm-9">
                                {{$hosp[0]->env_health_officers}}
                            </div>
                        </div>
                        <div class="row">
                                <label for="hs_no_env_health_officer" class="col-sm-3 " style="text-align: right;">Services Offered:</label>
                                <div class="col-sm-9">
                                        @foreach($services as $s)
                                            <small class="label label-default">{{$s->name}}</small>
                                        @endforeach
                                </div>
                        </div>
                       
                        <div class="row">
                            <a href="{{route('listhosp')}}">
                                <button type="button" class="btn btn-success pull-right">Return Back</button>
                            </a>
                        </div>
                </div>

                
            </div>
        </div> 
    </div>
    

@endsection 

@push('custom_scripts')


@endpush