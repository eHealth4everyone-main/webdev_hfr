@extends("layouts.master")


@section('content-title')
Hospitals and Clinics
@if(auth()->user()->hasPermissionTo(2))
<a href="{{route('hospitals.create')}}">
    <button type="button" class="btn btn-primary pull-right">
        Create Hospital or Clinic
    </button>
</a>
@endif
@endsection

@section("content")
<div class="box">
    <div class="box-header with-border">
        <form class="form-horizontal"  action="{{route('searchHospitalsAdmin')}}" method="post">
            @csrf
            <div class="form-group">
                    <div class="col-sm-4">  
                        @if (Auth::user()->state_id == 1 )
                            <select class="form-control select2" id="state_id" name ="state_id">
                                <option value="">--Select State--</option>
                                @foreach($lst_states as $st)
                                    <option value="{{$st->id}}">{{$st->name}}</option>
                                @endforeach
                            </select>
                        @else
                            <select class="form-control select2 dynamic" id="state_id" name ="state_id" disabled required>                                
                                @foreach($lst_states as $st)
                                    <option value="{{ $st->id }}">{{ $st->name }}</option>
                                @endforeach
                                
                            </select>
                            <input type="hidden" name="state_id" value="{{ Auth::user()->state_id }}" />
                        @endif
                    </div>
                    
                    <div class="col-sm-3">
                        <select class="form-control select2" id="lga_id" name="lga_id">
                            
                        </select>
                    </div>
                                  
                    <div class="col-sm-4" >
                        <input class="form-control input-sm" type="text" name="facility_name" id="facility_name" class="form-control" placeholder="Hospital or Clinic Name">
                    </div>
                    
                    <div class="col-sm-1">
                        <button type="submit" class="btn btn-success pull-right btn-sm">Search</button>
                    </div>
                    
                </div>
            </form>
        </div>
        
        <div class="box-body">
            
            <table id="table1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>State</th>
                        <th>LGA</th>
                        <th>Ward</th>
                        <th>Unique ID</th>
                        <th>Facility Name</th>
                        <th>Facility Level</th>
                        <th>Ownership</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach($facilities as $fac)
                    <tr>
                        <td>{{$fac->state}}</td>
                        <td>{{$fac->lga}}</td>
                        <td>{{$fac->ward}}</td>
                        <td>{{$fac->unique_id}}</td>
                        <td>{{$fac->facility_name}}</td>
                        <td>{{$fac->facility_level}}</td>
                        <td>{{$fac->ownership}}</td>
                        <td>
                            
                            <a href="#">
                                <button class="btn btn-success btn-sm"  type="button" data-toggle="modal" data-target="#view_details"
                                data-id="{{$fac->id}}" data-unique_id="{{$fac->unique_id}}" data-registration_no="{{$fac->registration_no}}" data-start_date="{{$fac->start_date}}"
                                data-facility_name="{{$fac->facility_name}}" data-alt_facility_name="{{$fac->alt_facility_name}}" data-state="{{$fac->state}}"
                                data-lga="{{$fac->lga}}" data-ward="{{$fac->ward}}" data-ownership="{{$fac->ownership}}" data-ownership_type="{{$fac->ownership_type}}"
                                data-ownership_details="{{$fac->ownership_details}}" data-facility_level="{{$fac->facility_level}}" data-facility_level_option="{{$fac->facility_level_option}}"
                                data-house_no="{{$fac->house_no}}" data-street_name="{{$fac->street_name}}" data-longitude="{{$fac->longitude}}" data-latitude="{{$fac->latitude}}"
                                data-postal_address="{{$fac->postal_address}}" data-phone_number="{{$fac->phone_number}}" data-email_address="{{$fac->email_address}}"
                                data-website="{{$fac->website}}" data-operational_days="{{$fac->operational_days}}" data-operational_hours="{{$fac->operational_hours}}"
                                data-operation_status="{{$fac->operation_status}}" data-regulatory_status="{{$fac->regulatory_status}}" data-license_status="{{$fac->license_status}}"
                                data-doctors="{{$fac->doctors}}" data-pharmacists="{{$fac->pharmacists}}" data-dentist="{{$fac->dentist}}" data-pharmacy_technicians="{{$fac->pharmacy_technicians}}"
                                data-nurses="{{$fac->nurses}}" data-lab_scientists="{{$fac->lab_scientists}}" data-midwifes="{{$fac->midwifes}}" data-lab_technicians="{{$fac->lab_technicians}}"
                                data-nurse_midwife="{{$fac->nurse_midwife}}" data-him_officers="{{$fac->him_officers}}" data-community_health_officer="{{$fac->community_health_officer}}"
                                data-community_extension_workers="{{$fac->community_extension_workers}}" data-jun_community_extension_worker="{{$fac->jun_community_extension_worker}}"
                                data-dental_technicians="{{$fac->dental_technicians}}" data-env_health_officers="{{$fac->env_health_officers}}" data-beds_accidents_emerg="{{$fac->beds_accidents_emerg}}"
                                data-beds_adminission="{{$fac->beds_adminission}}" data-beds_icu="{{$fac->beds_icu}}" data-onsite_laboratory="{{$fac->onsite_laboratory}}"
                                data-onsite_imaging="{{$fac->onsite_imaging}}" data-onsite_pharmarcy="{{$fac->onsite_pharmarcy}}" data-mortuary_services="{{$fac->mortuary_services}}">
                                View
                            </button>
                        </a> 
                        @if ($fac->lga_id == Auth::user()->lga_id)                        
                            @if(auth()->user()->hasPermissionTo(3))
                            <a href="{{route('hospitals.edit',$fac->id)}}">
                                <button class="btn btn-warning btn-sm"  type="button" > Edit</button>
                            </a>
                            @endif
                    
                            @if(auth()->user()->hasPermissionTo(4))
                            <a href="#">
                                <button class="btn btn-danger btn-sm"  type="button"  data-toggle="modal" data-target="#delete"
                                    data-id_del="{{$fac->id}}" data-unique_id_del="{{$fac->unique_id}}" data-facility_name_del="{{$fac->facility_name}}"> 
                                    Delete
                                </button>
                            </a>
                            @endif
                        @endif
                    </td>
                </tr>
                @endforeach
                
            </tbody>
        </table>
        
        
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <div class="row">
            
            @php
            $perpage = $facilities->perpage();
            $currentpage = $facilities->currentpage();
            $from = ($currentpage-1)*$perpage+1;
            
            if ($facilities->currentpage() == $facilities->lastpage()) {
                $to = $facilities->total();
            } else {
                $to = $currentpage*$perpage;
            }
            @endphp
            
            <div class="col-md-4">
                Showing {{$from}} to {{$to}} of {{$facilities->total()}} entries
                
            </div>
            <div class="col-md-8">
                <div class="pull-right">
                    {{$facilities->links()}}                  
                </div>
            </div>
            
        </div>
    </div>
    
</div>
<!-- /.box -->
{{-- modal facility details --}}
<div class="modal fade" id="view_details" tabindex="-1" role="dialog">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Facility Details</h4>
                <div class='notifications top-right'></div>
            </div>
            <div class="modal-body">
                
                <div class="panel-body">
                    
                    <div class="panel-group" id="accordion">
                        {{-- panel one --}}
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Identity</a>
                                </h4>
                            </div>
                            <div id="collapse1" class="panel-collapse collapse in">
                                <div class="panel-body">
                                    <div class="row">
                                        <label class="col-md-4">Unique_id:</label>
                                        <div class="col-md-8" id="unique_id"></div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-4">Registration No:</label>
                                        <div class="col-md-8" id="registration_no"></div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-4 text-md-right">Facility Name:</label>
                                        <div class="col-md-8" id="facility_name">    </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-4 text-md-right">Alternate Name:</label>
                                        <div class="col-md-8" id="alt_facility_name">    </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-4 text-md-right">Start Date:</label>
                                        <div class="col-md-8" id="start_date">    </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-4 text-md-right">Ownership:</label>
                                        <div class="col-md-8" id="ownership">    </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-4 text-md-right">Ownership Type:</label>
                                        <div class="col-md-8" id="ownership_type">    </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-4 text-md-right">Ownership Details:</label>
                                        <div class="col-md-8" id="ownership_details">    </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-4 text-md-right">Facility Level:</label>
                                        <div class="col-md-8" id="facility_level">    </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-4 text-md-right">Facility Level Option:</label>
                                        <div class="col-md-8" id="facility_level_option">    </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-4 text-md-right">Days of Operation:</label>
                                        <div class="col-md-8" id="operational_days">   </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-4 text-md-right">Hours of Operation:</label>
                                        <div class="col-md-8" id="operational_hours">   </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- panel two --}}
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Location</a>
                                </h4>
                            </div>
                            <div id="collapse2" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="row">
                                        <label class="col-md-4">State:</label>
                                        <div class="col-md-8" id="state"></div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-4">LGA:</label>
                                        <div class="col-md-8" id="lga"></div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-4">Ward:</label>
                                        <div class="col-md-8" id="ward"></div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-4">House No:</label>
                                        <div class="col-md-8" id="house_no"></div>
                                    </div>      
                                    <div class="row">
                                        <label class="col-md-4">Street Name:</label>
                                        <div class="col-md-8" id="street_name"></div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-4">Longitude:</label>
                                        <div class="col-md-8" id="longitude"></div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-4">Latitude:</label>
                                        <div class="col-md-8" id="latitude"></div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-4">Address:</label>
                                        <div class="col-md-8" id="postal_address"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- panel 3 --}}
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">Contacts</a>
                                </h4>
                            </div>
                            <div id="collapse3" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="row">
                                        <label class="col-md-4">Phone Number:</label>
                                        <div class="col-md-8" id="phone_number"></div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-4">Emai Address:</label>
                                        <div class="col-md-8" id="email_address"></div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-4">Website:</label>
                                        <div class="col-md-8" id="website"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- panel four --}}
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">Status</a>
                                </h4>
                            </div>
                            <div id="collapse4" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="row">
                                        <label class="col-md-4">Operational Status:</label>
                                        <div class="col-md-8" id="operation_status"></div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-4">Regulatory Status:</label>
                                        <div class="col-md-8" id="regulatory_status"></div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-4">License Status:</label>
                                        <div class="col-md-8" id="license_status"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- panel five HFR--}}
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse5">Personnel</a>
                                </h4>
                            </div>
                            <div id="collapse5" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="row">
                                        <label class="col-md-6">No. of Doctors:</label>
                                        <div class="col-md-6" id="doctors"></div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-6">No. of Pharmacists:</label>
                                        <div class="col-md-6" id="pharmacists"></div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-6">No. of Dentists:</label>
                                        <div class="col-md-6" id="dentist"></div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-6">No. Pharmacy Technicians:</label>
                                        <div class="col-md-6" id="pharmacy_technicians"></div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-6">No. of Nurses:</label>
                                        <div class="col-md-6" id="nurses"></div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-6">No. of Midwifes:</label>
                                        <div class="col-md-6" id="midwifes"></div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-6">No. of Nurses/Midwifes:</label>
                                        <div class="col-md-6" id="nurse_midwife"></div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-6">No. of Lab Technicians:</label>
                                        <div class="col-md-6" id="lab_technicians"></div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-6">No. of Lab Scientits:</label>
                                        <div class="col-md-6" id="lab_scientists"></div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-6">Health Records/HIM Officers:</label>
                                        <div class="col-md-6" id="him_officers"></div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-6">No. of Community Health Officer:</label>
                                        <div class="col-md-6" id="community_health_officer"></div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-6">No. of Community Health Extension Worker:</label>
                                        <div class="col-md-6" id="community_extension_workers"></div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-6">No. of Junior Com Health Extension Worker:</label>
                                        <div class="col-md-6" id="jun_community_extension_worker"></div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-6">No. of Dental Technicians:</label>
                                        <div class="col-md-6" id="dental_technicians"></div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-6">No. of Environmental Health Officers:</label>
                                        <div class="col-md-6" id="env_health_officers"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- pane six Services--}}
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse6">Services</a>
                                </h4>
                            </div>
                            <div id="collapse6" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="row">
                                        <label class="col-md-6">Medical:</label>
                                        <div class="col-md-6" id="medical"></div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-6">Surgical:</label>
                                        <div class="col-md-6" id="surgical"></div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-6">Obsterics and Gynecology:</label>
                                        <div class="col-md-6" id="gyn"></div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-6">Pediatrics:</label>
                                        <div class="col-md-6" id="pediatrics"></div>   
                                    </div>
                                    <div class="row">
                                        <label class="col-md-6">Dental:</label>
                                        <div class="col-md-6" id="dental"></div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-6">Specific Clinical Service:</label>
                                        <div class="col-md-6" id="specialservice"></div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-6">Beds Accidents and Emergency:</label>
                                        <div class="col-md-6" id="beds_accidents_emerg"></div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-6">Beds Admission Facilities:</label>
                                        <div class="col-md-6" id="beds_adminission"></div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-6">Beds ICU:</label>
                                        <div class="col-md-6" id="beds_icu"></div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-6">Onsite Laboratory:</label>
                                        <div class="col-md-6" id="onsite_laboratory"></div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-6">Onsite Imaging:</label>
                                        <div class="col-md-6" id="onsite_imaging"></div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-6">Onsite Pharmacy:</label>
                                        <div class="col-md-6" id="onsite_pharmarcy"></div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-6">Mortuary Services:</label>
                                        <div class="col-md-6" id="mortuary_services"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    
                    
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!--/.modal-dialog -->
    </div>
</div><!--/.modal -->


{{-- modal deletation  --}}
<div class="modal fade" id="delete" tabindex="-1" role="dialog">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Delete Facility</h4>
                <div class='notifications top-right'></div>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('hospitals.InitiateDelete')}}">
                    @csrf
                    <input type="hidden" id="facility_id" name="facility_id">
                    <div class="panel-body">
                        
                        <div class="panel-group" id="accordion_d">
                            {{-- panel one --}}
                            <div class="panel panel-default">
                              
                                <div id="collapse1d" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <div class="row">
                                            <label class="col-md-4">Unique_id:</label>
                                            <div class="col-md-8" id="unique_id_del"></div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-4 text-md-right">Facility Name:</label>
                                            <div class="col-md-8" id="facility_name_del">    </div>
                                        </div>
                                      
                                        <div class="row">
                                            <label class="col-md-4">Reason for Delete:<font color="red">*</font></label>
                                            <div class="col-md-8">
                                                <textarea class="form-control" rows="3" name="reason" placeholder="Please enter reason" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                           
                        </div> 
                        
                    </div>
                    
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Send Delete Request</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
                
            </div><!--modal body ends -->
        </div><!--/.modal-content -->
    </div>
</div> <!--/.modal -->
    
@endsection 
    
    
@push('bk_script')
    @include('partials.dynamic_state_script')
    @include('partials.notification')
    
    <script>
        $("#state_id").val({{Auth::user()->state_id}}).change();

        $(document).ready( function () {
            $("#state_id").val({{Auth::user()->state_id}}).change();
            
        });
        
        $('#view_details').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var modal = $(this)
            $("#specialservice").empty();
            $("#medical").empty();
            $("#surgical").empty();
            $("#gyn").empty();
            $("#pediatrics").empty();
            $("#dental").empty();

            modal.find('.modal-body #unique_id').text(button.data('unique_id'));
            modal.find('.modal-body #registration_no').text(button.data('registration_no'));
            modal.find('.modal-body #start_date').text(button.data('start_date'));
            modal.find('.modal-body #facility_name').text(button.data('facility_name'));
            modal.find('.modal-body #alt_facility_name').text(button.data('alt_facility_name'));
            modal.find('.modal-body #state').text(button.data('state'));
            modal.find('.modal-body #lga').text(button.data('lga'));
            modal.find('.modal-body #ward').text(button.data('ward'));
            modal.find('.modal-body #ownership').text(button.data('ownership'));
            modal.find('.modal-body #ownership_type').text(button.data('ownership_type'));
            modal.find('.modal-body #ownership_details').text(button.data('ownership_details'));
            modal.find('.modal-body #facility_level').text(button.data('facility_level'));
            modal.find('.modal-body #facility_level_option').text(button.data('facility_level_option'));
            modal.find('.modal-body #house_no').text(button.data('house_no'));
            modal.find('.modal-body #street_name').text(button.data('street_name'));
            modal.find('.modal-body #longitude').text(button.data('longitude'));
            modal.find('.modal-body #latitude').text(button.data('latitude'));
            modal.find('.modal-body #postal_address').text(button.data('postal_address'));
            modal.find('.modal-body #phone_number').text(button.data('phone_number'));
            modal.find('.modal-body #email_address').text(button.data('email_address'));
            modal.find('.modal-body #website').text(button.data('website'));
            modal.find('.modal-body #operational_days').text(button.data('operational_days'));
            modal.find('.modal-body #operational_hours').text(button.data('operational_hours'));
            modal.find('.modal-body #operation_status').text(button.data('operation_status'));
            modal.find('.modal-body #regulatory_status').text(button.data('regulatory_status'));
            modal.find('.modal-body #license_status').text(button.data('license_status'));
            modal.find('.modal-body #doctors').text(button.data('doctors'));
            modal.find('.modal-body #pharmacists').text(button.data('pharmacists'));
            modal.find('.modal-body #dentist').text(button.data('dentist'));
            modal.find('.modal-body #pharmacy_technicians').text(button.data('pharmacy_technicians'));
            modal.find('.modal-body #nurses').text(button.data('nurses'));
            modal.find('.modal-body #lab_scientists').text(button.data('lab_scientists'));
            modal.find('.modal-body #midwifes').text(button.data('midwifes'));
            modal.find('.modal-body #lab_technicians').text(button.data('lab_technicians'));
            modal.find('.modal-body #nurse_midwife').text(button.data('nurse_midwife'));
            modal.find('.modal-body #him_officers').text(button.data('him_officers'));
            modal.find('.modal-body #community_health_officer').text(button.data('community_health_officer'));
            modal.find('.modal-body #community_extension_workers').text(button.data('community_extension_workers'));
            modal.find('.modal-body #jun_community_extension_worker').text(button.data('jun_community_extension_worker'));
            modal.find('.modal-body #dental_technicians').text(button.data('dental_technicians'));
            modal.find('.modal-body #env_health_officers').text(button.data('env_health_officers'));
            modal.find('.modal-body #beds_accidents_emerg').text(button.data('beds_accidents_emerg'));
            modal.find('.modal-body #beds_adminission').text(button.data('beds_adminission'));
            modal.find('.modal-body #beds_icu').text(button.data('beds_icu'));
            modal.find('.modal-body #onsite_laboratory').text(button.data('onsite_laboratory'));
            modal.find('.modal-body #onsite_imaging').text(button.data('onsite_imaging'));
            modal.find('.modal-body #onsite_pharmarcy').text(button.data('onsite_pharmarcy'));
            modal.find('.modal-body #mortuary_services').text(button.data('mortuary_services'));
            
            var hosp_id = button.data('id');
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url:"{{route('hospitals.getServices')}}",
                method:"POST",
                data:{hosp_id:hosp_id,_token:_token},
                success:function(result)
                {
                    $.each(result, function(i, item) {   
                        if (item.category_id=="1"){
                            $("#medical").append("<span class='label label-default'>" + item.name + "</span> ");
                        }
                        if (item.category_id=="2"){
                            $("#surgical").append("<span class='label label-default'>" + item.name + "</span> ");
                        }
                        if (item.category_id=="3"){
                            $("#gyn").append("<span class='label label-default'>" + item.name + "</span> ");
                        }
                        if (item.category_id=="4"){
                            $("#pediatrics").append("<span class='label label-default'>" + item.name + "</span> ");
                        }
                        if (item.category_id=="5"){
                            $("#dental").append("<span class='label label-default'>" + item.name + "</span> ");
                        }
                        if (item.category_id=="6"){
                            $("#specialservice").append("<span class='label label-default'>" + item.name + "</span> ");
                        }
                    });     
                  
                }         
            })
        });//end

        $('#delete').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var modal = $(this)
        
            modal.find('.modal-body #unique_id_del').text(button.data('unique_id_del'));
            modal.find('.modal-body #facility_name_del').text(button.data('facility_name_del'));
            modal.find('.modal-body #facility_id').val(button.data('id_del'));            
          
        });//end
        
    </script>
    
@endpush