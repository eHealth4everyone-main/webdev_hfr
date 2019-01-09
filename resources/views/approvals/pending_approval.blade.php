@extends("layouts.master")


@section('content-title')
Pending Approvals

@endsection

@section("content")
@if($pending->isEmpty())
<div class="callout callout-success">
    <h4>Congrats!</h4>
    <p>No Pending approvals</p>
</div>
@endif

@foreach($pending as $p)

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">
            Facility Name: <span class="label label-default"> {{ $p->facility_name }}</span> 
            
            @if ($p->action === "CREATE")
            Request Type: <span class="label label-info"> {{$p->action}}</span>
            @elseif ($p->action === "UPDATE")
            Request Type: <span class="label label-primary"> {{$p->action}}</span>
            @else
            Request Type: <span class="label label-danger"> {{$p->action}}</span>                
            @endif
            
            @if (($p->status_id === 1) or ($p->status_id ===8))
            Status: <span class="label label-warning"> {{$p->status}}</span> 
            @elseif (($p->status_id === 3) or ($p->status_id ===5) or ($p->status_id ===7) or ($p->status_id===10) or ($p->status_id ===12 or ($p->status_id ===12)))
            Status: <span class="label label-danger"> {{$p->status}}</span> 
            @else
            Status: <span class="label label-success"> {{$p->status}}</span>                 
            @endif
        </h3>
        
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
        <!-- /.box-tools -->
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Action</th>
                    <th>Date</th>
                    <th>Done By</th>     
                </tr>
            </thead>
            <tbody>
                
                @foreach($status as $s)
                <tr>
                    @if(($p->id == $s->hospital_id) and ($p->action == $s->action_type))
                    <td>{{$s->action}}</td>
                    <td>{{$s->created_at}}</td>
                    <td>
                        <Strong>Name: </Strong>{{$s->user}} <br>
                        <Strong>Position: </Strong>{{$s->position}} <br>
                        <Strong>E-mail: </Strong>{{$s->email}} <br>
                        <Strong>Mobile: </Strong>{{$s->mobile}}
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        @if ($p->action === "CREATE")
        <a href="#">
            <button class="btn btn-success btn-sm"  type="button" data-toggle="modal" data-target="#view_details" data-id="{{$p->id}}"
                data-unique_id="{{$p->unique_id}}" data-registration_no="{{$p->registration_no}}" data-start_date="{{$p->start_date}}"
                data-facility_name="{{$p->facility_name}}" data-alt_facility_name="{{$p->alt_facility_name}}" data-state="{{$p->state}}"
                data-lga="{{$p->lga}}" data-ward="{{$p->ward}}" data-ownership="{{$p->ownership}}" data-ownership_type="{{$p->ownership_type}}"
                data-ownership_details="{{$p->ownership_details}}" data-facility_level="{{$p->facility_level}}" data-facility_level_option="{{$p->facility_level_option}}"
                data-house_no="{{$p->house_no}}" data-street_name="{{$p->street_name}}" data-longitude="{{$p->longitude}}" data-latitude="{{$p->latitude}}"
                data-postal_address="{{$p->postal_address}}" data-phone_number="{{$p->phone_number}}" data-email_address="{{$p->email_address}}"
                data-website="{{$p->website}}" data-operational_days="{{$p->operational_days}}" data-operational_hours="{{$p->operational_hours}}"
                data-operation_status="{{$p->operation_status}}" data-regulatory_status="{{$p->regulatory_status}}" data-license_status="{{$p->license_status}}"
                data-doctors="{{$p->doctors}}" data-pharmacists="{{$p->pharmacists}}" data-dentist="{{$p->dentist}}" data-pharmacy_technicians="{{$p->pharmacy_technicians}}"
                data-nurses="{{$p->nurses}}" data-lab_scientists="{{$p->lab_scientists}}" data-midwifes="{{$p->midwifes}}" data-lab_technicians="{{$p->lab_technicians}}"
                data-nurse_midwife="{{$p->nurse_midwife}}" data-him_officers="{{$p->him_officers}}" data-community_health_officer="{{$p->community_health_officer}}"
                data-community_extension_workers="{{$p->community_extension_workers}}" data-jun_community_extension_worker="{{$p->jun_community_extension_worker}}"
                data-dental_technicians="{{$p->dental_technicians}}" data-env_health_officers="{{$p->env_health_officers}}" data-beds_accidents_emerg="{{$p->beds_accidents_emerg}}"
                data-beds_adminission="{{$p->beds_adminission}}" data-beds_icu="{{$p->beds_icu}}" data-onsite_laboratory="{{$p->onsite_laboratory}}"
                data-onsite_imaging="{{$p->onsite_imaging}}" data-onsite_pharmarcy="{{$p->onsite_pharmarcy}}" data-mortuary_services="{{$p->mortuary_services}}">
                Approve
            </button>
        </a>  
        @elseif ($p->action === "UPDATE") 
            <a href="{{route('view.updated_records',['id'=>$p->id,'stage'=>'approve'])}}">
                <button class="btn btn-success btn-sm"  type="button" > Approve</button>
            </a>
        @else
        
        @endif
        
    </div>
</div>

@endforeach



{{-- modal facility details for new Facility  --}}
<div class="modal fade" id="view_details" tabindex="-1" role="dialog">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Facility Details</h4>
                <div class='notifications top-right'></div>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('store.approval')}}">
                    @csrf
                    <input type="hidden" id="id" name="id">
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
                            {{-- panel five --}}
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
                            {{-- panel six --}}
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse6">Services</a>
                                    </h4>
                                </div>
                                <div id="collapse6" class="panel-collapse collapse">
                                    <div class="panel-body">
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
                                    </div>
                                </div>
                            </div>
                            {{-- panel seven --}}
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse7">Remarks</a>
                                    </h4>
                                </div>
                                <div id="collapse7" class="panel-collapse">
                                    <div class="panel-body">
                                        <div class="row">
                                            <label class="col-md-2">Note:<font color="red">*</font></label>
                                            <div class="col-md-10">
                                                <textarea class="form-control" rows="3" name="notes" placeholder="Please enter notes ..." required></textarea>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div> 
                        
                        
                    </div>
                    
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger" name="action" value="reject">Reject</button>
                        <button type="submit" class="btn btn-success" name="action" value="approve">Approve</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
                
            </div><!--modal body ends -->
        </div><!--/.modal-content -->
    </div><!--/.modal -->
    
    {{-- modal show updated records --}}
    <div class="modal fade" id="view_updated" tabindex="-1" role="dialog">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Facility Details</h4>
                    <div class='notifications top-right'></div>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{route('store.updated_approval')}}">
                        @csrf
                        <input type="hidden" id="id" name="id">
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
                                                <label class="col-md-4 text-md-right">Facility Level Option:</label>
                                                <div class="col-md-8" id="">    </div>
                                            </div>
                                         
                                        </div>
                                    </div>
                                </div>
         
                            </div> 
                            
                            
                        </div>
                        
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger" name="action" value="reject">Reject</button>
                            <button type="submit" class="btn btn-success" name="action" value="approve">Approve</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                    
                </div><!--modal body ends -->
            </div><!--/.modal-content -->
        </div><!--/.modal -->
        
        @endsection 
        
        
        @push('bk_script')
        @include('partials.notification')
        
        
        <script>
            $(document).ready( function () {
                
            });
            
            
            $('#view_details').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var modal = $(this)
                
                modal.find('.modal-body #id').val(button.data('id'));
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
                
            });//end
            
            
            
        </script>
        
        @endpush