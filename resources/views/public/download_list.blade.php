@extends("layouts.pub.master2")

@section('custom_css')

@endsection


@section("content")  

<div class="latest-area section-padding bg-white">
    <div class="container">

    <div class="box-header">

        <form class="form-horizontal"  action="{{route('download.filter')}}" method="GET">
            @csrf
            <div class="form-group">
                    <div class="col-sm-2">
                            <select class="form-control select2" id="facility_type_id" name="facility_type_id">
                                    @foreach(getFacilityTypes() as $ty)
                                        <option value="{{$ty->id}}">{{$ty->name}}</option>
                                    @endforeach
                            </select>
                        </div>
                    <div class="col-sm-2">
                          <select class="form-control select2" id="state_id" name ="state_id">
                                  <option value="1">All States</option>
                                  @foreach(getStates() as $st)
                                      <option value="{{$st->id}}">{{$st->name}}</option>
                                  @endforeach
                          </select>
                    </div>
                    
                    <div class="col-sm-2">
                        <select class="form-control select2" id="lga_id" name="lga_id">
                            <option value="1">--Select LGA--</option>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <select class="form-control select2" id="ward_id" name="ward_id">
                            <option value="0">--Select Ward--</option>
                        </select>
                    </div>
                 
      
                    <div class="col-sm-2">
                        <select class="form-control select2" id="facility_level_id"  name="facility_level_id" style="width: 100%;">
                                <option value="0">--Select Facility Level--</option>
                                @foreach(getLevelOfCare() as $st)
                                        <option value="{{ $st->id }}">{{ $st->name }}</option>
                                @endforeach
                        </select>        
                    </div>
                    <div class="col-sm-2">
                        <select class="form-control select2" id="ownership_id"  name="ownership_id" style="width: 100%;">
                            <option value="0">--Select Ownership--</option>
                            @foreach(getOwnership() as $st)
                                <option value="{{$st->id}}">{{$st->name}}</option>
                            @endforeach
                            
                        </select>
                    </div>    
      
                </div>
            <div class="form-group">
               
              <div class="col-sm-2">
                    <select class="form-control select2" id="operational_status_id" name ="operational_status_id">
                        <option value="0">--Select Operational Status--</option>
                        @foreach(getOperationalStatus() as $st)
                                <option value="{{ $st->id }}">{{ $st->status }}</option>
                        @endforeach
                    </select>
              </div>
              <div class="col-sm-2">
                    <select class="form-control select2" id="registration_status_id" name="registration_status_id" style="width: 100%;">
                        <option value="0">--Select Registration Status--</option>
                        @foreach(getRegistrationStatus() as $st)
                            <option value="{{ $st->id }}" >{{ $st->status }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-2">
                        <select class="form-control select2" id="license_status_id" name="license_status_id" style="width: 100%;">
                            <option value="0">--Select License Status--</option>
                            @foreach(getLicenseStatus() as $st)
                                <option value="{{ $st->id }}" >{{ $st->status }}</option>
                            @endforeach
                        </select>
                    </div>
              <div class="col-sm-2">
                    <select class="form-control select2" id="geo_codes" name="geo_codes">
                        <option value="0">--Select Coordinates--</option>
                        <option value="1">With Coordinates</option>
                        <option value="2">With No Coordinates</option>                            
                    </select>
                </div>
                <div class="col-sm-2">
                    <select class="form-control select2" id="service_type" name="service_type">
                        <option value="0">--Select Service Type--</option>
                        <option value="1">Out Patient</option>
                        <option value="2">In Patient</option>                            
                    </select>
                </div>
              <div class="col-sm-2">
                    <button type="submit" class="btn btn-success pull-right btn-sm">Search</button>
                    <button type="button" class="btn btn-sm" id='reset'>Reset</button>
              </div>
            

          </div>
      

        </form>
      

        
    </div>
    {{-- <div role="alert" class="alert alert-success"> 
            A total of {{$facilities->total()}} record(s) found  
                          
    </div> --}}
        <div class="box-body">                

                <table id="hosp" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>State</th>
                        <th>LGA</th>
                        <th>Ward</th>
                        <th>Facility ID</th>
                        <th>Facility Name</th>
                        @if($facility_type_id == 1 OR $facility_type_id == 3)
                            <th>Facility Level</th>
                        @endif

                        <th>Ownership</th>
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
            <div class="btn-group pull-right">
                    <form class="form-horizontal"  action="{{route('download.export')}}" method="post">
                            @csrf
    
                            <input type="hidden"  name="state_id2" value="{{ $state_id }}">
                            <input type="hidden"  name="lga_id2" value="{{ $lga_id }}">
                            <input type="hidden"  name="facility_name2" value="{{ $facility_name }}">
                            <input type="hidden"  name="geo_codes2" value="{{ $geo_codes }}">
                            <input type="hidden"  name="facility_level_id2" value="{{ $facility_level_id  }}">
                            <input type="hidden"  name="ownership_id2" value="{{ $ownership_id }}">
                            <input type="hidden"  name="operational_status_id2" value="{{ $operational_status_id }}">
                            <input type="hidden"  name="registration_status_id2" value="{{ $registration_status_id }}">
                            <input type="hidden"  name="license_status_id2" value="{{ $license_status_id }}">
               
    
                            <button type="submit" class="btn btn-primary btn-sm" name='format' value='xls'>Download</button>
    
                    </form>
                </div>
        </div>
    </div> <!-- /contanier-->
</div> <!-- / -->



@endsection 

@push('custom_scripts')
@include('partials.dynamic_state_script')

<script>
    $(document).ready( function () {
        $("#geo_codes").val({{$geo_codes}}).change();
        $("#state_id").val({{$state_id}}).change();
        $("#facility_type_id").val({{$facility_type_id}}).change();
        $("#facility_name").val("{{$facility_name}}");
        $("#facility_level_id").val({{$facility_level_id}}).change();
        $("#ownership_id").val({{$ownership_id}}).change();
        $("#operational_status_id").val({{$operational_status_id}}).change();
        $("#registration_status_id").val({{$registration_status_id}}).change();
        $("#license_status_id").val({{$license_status_id}}).change();
        $("#service_type").val({{$service_type}}).change();
        // $("#lga_id").val({{$lga_id}}).change();
        
        $("#reset").click(function(){
            $("#geo_codes").val(0).change();
            $("#state_id").val(1).change();
            $("#facility_type_id").val(1).change();
            $("#facility_name").val("");
            $("#facility_level_id").val(0).change();
            $("#ownership_id").val(0).change();
            $("#operational_status_id").val(0).change();
            $("#registration_status_id").val(0).change();
            $("#license_status_id").val(0).change();
            $("#service_type").val(0).change();
            $("#service_category_id").val(0).change();
            $("#services").val(0).change();
        });

   

        $("#service_category_id").change(function(){
            var id= $('#service_category_id').val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url:"{{route('getServices')}}",
                method:"POST",
                data:{id:id, _token:_token},
                success:function(result)
                {
                    $('#services').html(result);
                }         
            })
        });


      
    
    });
</script>

@endpush