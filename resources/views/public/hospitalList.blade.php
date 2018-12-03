@extends("layouts.pub.master")

@section('custom_css')

@endsection



@section("content")   
<div class="latest-area section-padding bg-white">
    <div class="container">

    <div class="box-header">
        <form class="form-horizontal"  action="{{route('searchFacilities')}}" method="GET">
            @csrf
            <div class="form-group">
               
              <div class="col-sm-2">
                    <select class="form-control select2" id="state_id" name ="state_id">
                            <option value="0">All States</option>
                            @foreach($lst_states as $st)
                                <option value="{{$st->id}}">{{$st->name}}</option>
                            @endforeach
                    </select>
              </div>
              
              <div class="col-sm-2">
                  <select class="form-control select2" id="lga_id" name="lga_id">
                      <option value="">--Select LGA--</option>
                  </select>
              </div>
              <div class="col-sm-2">
                    <select class="form-control select2" id="facility_type_id" name="facility_type_id">
                            @foreach($lst_facility_types as $ty)
                                <option value="{{$ty->id}}">{{$ty->name}}</option>
                            @endforeach
                    </select>
                </div>
                <div class="col-sm-2">
                    <select class="form-control select2" id="geo_codes" name="geo_codes">
                        <option value="0">All Facilities</option>
                        <option value="1">With Coordinates</option>
                        <option value="2">Without Coordinates</option>                            
                    </select>
                </div>

              <div class="col-sm-3" >
                <input class="form-control input-sm"type="text" name="facility_name" id="facility_name" class="form-control" placeholder="Facility name">
              </div>

              <div class="col-sm-1">
                  <button type="submit" class="btn btn-success pull-right btn-sm">Search</button>
              </div>

          </div>
        </form>

    </div>
    <div role="alert" class="alert alert-success"> 
            A total of {{$facilities->total()}} record(s) found  
                          
    </div>
        <div class="box-body">                

                <table id="hosp" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>State</th>
                        <th>LGA</th>
                        <th>Ward</th>
                        <th>Unique ID</th>
                        <th>Facility Name</th>
                        @if($facility_type_id == 1 OR $facility_type_id == 3)
                            <th>Facility Level</th>
                        @endif

                        <th>Ownership</th>
                        <th>Details</th>
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

                                @if($facility_type_id == 1 OR $facility_type_id == 3)
                                    <td>{{$fac->facility_level}}</td>
                                @endif
                                
                                <td>{{$fac->ownership}}</td>
                                <td>
                                    {{-- <a href="{{route('facilitydetails',['id'=>$fac->id,'facility_type_id'=>$facility_type_id])}}"><button class="btn btn-success btn-xs" type="button">view</button> </a> --}}
                                    <a href="#">
                                    <button class="btn btn-success btn-sm" id="btnDetails" data-id="{{$fac->id}}" data-type_id="{{$facility_type_id}}" type="button" data-toggle="modal"  data-target="#showFacDetails">View</button>
                                    </a>
                                    {{-- <a href="#">
                                            <button class="btn btn-warning btn-sm" id="btnOnMap" data-id="{{$fac->id}}"  type="button" data-toggle="modal"  data-target="#showFaconMap">View on Map</button>
                                    </a> --}}
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
    </div> <!-- /contanier-->
</div> <!-- / -->
      
@endsection 

@push('custom_scripts')
    @include('partials.dynamic_lgas_only')

    <script>
        $(document).ready( function () {
            $("#geo_codes").val({{$geo_codes}}).change();
            $("#state_id").val({{$state_id}}).change();
            $("#facility_type_id").val({{$facility_type_id}}).change();
            $("#facility_name").val("{{$facility_name}}");
            // $("#lga_id").val({{$lga_id}}).change();
           

            $("#btnDetails1").click(function () {
                
                var id = $(this).data('id');
                var fac_type_id= $(this).data('type_id');

              
            });
                
             $('#showFacDetails').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                
                var id = button.data('id')
                var fac_type_id = button.data('type_id')
                console.log(id);

                $.ajax({
                    url:"{{route('facilitydetails')}}",
                    method:"POST",
                    data:{id:id,facility_type_id:fac_type_id, _token: "{{ csrf_token() }}"},
                    success:function(result)
                    {
                        $('#unique_id1').text(result.details[0].unique_id);
                        $('#facility_name1').text(result.details[0].facility_name);
                        $('#registration_no1').text(result.details[0].registration_no == null ? "" : result.details[0].registration_no);
                        $('#start_date1').text(result.details[0].start_date == null ? "" :result.details[0].start_date );
                        $('#alt_facility_name1').text(result.details[0].alt_facility_name == null ? "" :result.details[0].alt_facility_name);
                        $('#state1').text(result.details[0].state);
                        $('#lga1').text(result.details[0].lga);
                        $('#ward1').text(result.details[0].ward);
                        $('#house_no1').text(result.details[0].house_no== null ? "" :result.details[0].house_no);
                        $('#street_name1').text(result.details[0].street_name== null ? "" :result.details[0].street_name);
                        $('#latitude1').text(result.details[0].latitude== null ? "" :result.details[0].latitude);
                        $('#longitude1').text(result.details[0].longitude== null ? "" :result.details[0].longitude);
                        $('#postal_address1').text(result.details[0].postal_address== null ? "" :result.details[0].postal_address);
                        $('#phone_number1').text(result.details[0].phone_number== null ? "" :result.details[0].phone_number);
                        $('#email_address1').text(result.details[0].email_address== null ? "" :result.details[0].email_address);
                        $('#website1').text(result.details[0].website== null ? "" :result.details[0].website);
                        $('#operational_days1').text(result.details[0].operational_days== null ? "" :result.details[0].operational_days);
                        $('#operational_hours1').text(result.details[0].operational_hours== null ? "" :result.details[0].operational_hours);
                        $('#facility_level1').text(result.details[0].facility_level);
                        $('#ownership1').text(result.details[0].ownership);
                        $('#ownership_type1').text(result.details[0].ownership_type== null ? "" :result.details[0].ownership_type);
                        $('#ownership_details1').text(result.details[0].ownership_details== null ? "" :result.details[0].ownership_details);
                        $('#operation_status1').text(result.details[0].operation_status== null ? "" :result.details[0].operation_status);
                        $('#regulatory_status1').text(result.details[0].regulatory_status== null ? "" :result.details[0].regulatory_status);
                        $('#license_status1').text(result.details[0].license_status== null ? "" :result.details[0].license_status);
                        $('#pharmacists1').text(result.details[0].pharmacists== null ? "" :result.details[0].pharmacists);
                        $('#dentist1').text(result.details[0].dentist == null ? "" :result.details[0].dentist);
                        $('#pharmacy_technicians1').text(result.details[0].pharmacy_technicians == null ? "" :result.details[0].pharmacy_technicians);
                        $('#nurses1').text(result.details[0].nurses== null ? "" :result.details[0].nurses);
                        $('#lab_scientists1').text(result.details[0].lab_scientists == null ? "" :result.details[0].lab_scientists);
                        $('#midwifes1').text(result.details[0].midwifes== null ? "" :result.details[0].midwifes);
                        $('#lab_technicians1').text(result.details[0].lab_technicians == null ? "" :result.details[0].lab_technicians);
                        $('#nurse_midwife1').text(result.details[0].nurse_midwife == null ? "" :result.details[0].nurse_midwife );
                        $('#him_officers1').text(result.details[0].him_officers == null ? "" :result.details[0].him_officers );
                        $('#community_health_officer1').text(result.details[0].community_health_officer == null ? "" :result.details[0].community_health_officer);
                        $('#community_extension_workers1').text(result.details[0].community_extension_workers == null ? "" :result.details[0].community_extension_workers);
                        $('#jun_community_extension_worker1').text(result.details[0].jun_community_extension_worker == null ? "" :result.details[0].jun_community_extension_worker);
                        $('#dental_technicians1').text(result.details[0].dental_technicians == null ? "" :result.details[0].dental_technicians);
                        $('#env_health_officers1').text(result.details[0].env_health_officers == null ? "" :result.details[0].env_health_officers);
                        
                        // var services = result.services[0];
                        var serv = result.services.toString();
                        
                        $('#services1').text(serv == null ? "" :serv);

                        $('#showFacDetails').modal('show')
                        
                    }//success ends         
                });//ajax ends
             
            })

        });
    </script>

@endpush