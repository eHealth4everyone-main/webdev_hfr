@extends("layouts.master")


@section('content-title')
DHIS2 Data Exchange Log

@endsection

@section("content")
<div class="box">
  <div class="box-body">
    
    <table id="table1" class="table table-bordered table-striped" style="width:100%">
      <thead>
        <tr>
          <th>ID</th>
          <th>Facility Name</th>
          <th>HFR ID</th>
          <th>DHIS2 UID</th>
          <th>Facility</th>
          <th>Ownership</th>
          <th>Level of Care </th>
          <th>Level of Care Option</th>
          <th>Date</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        
        @foreach($logs as $log)
        <tr>
          <td>{{ $log->id }}</td>
          <td>{{$log->facility_name}}</td>
          <td>{{$log->hfr_id}} </td>
          <td>{{$log->dhis_uid}}</td>
          <td>{{$log->facility_status}}</td>
          <td>{{$log->ownership_status}}</td>
          <td>{{$log->level_status}}</td>
          <td>{{$log->level_option_status}}</td>
          <td> {{ Carbon\Carbon::parse($log->created_at)->toFormattedDateString() }}</td>
          <td>
            <a href="#">
              <button class="btn btn-success btn-sm"  type="button" data-toggle="modal" data-target="#view_details"
                  data-id="{{$log->id}}" data-facility_code="{{$log->facility_code}}"  data-start_date="{{$log->start_date}}" data-close_date="{{$log->close_date}}"
                  data-facility_name="{{$log->facility_name}}" data-alt_facility_name="{{$log->alt_facility_name}}" data-state="{{$log->state}}"
                  data-lga="{{$log->lga}}" data-ward="{{$log->ward}}" data-ownership="{{$log->ownership}}" 
                  data-facility_level="{{$log->facility_level}}" data-facility_level_option="{{$log->facility_level_option}}"
                  data-longitude="{{$log->longitude}}" data-latitude="{{$log->latitude}}"
                  data-postal_address="{{$log->postal_address}}" data-phone_number="{{$log->phone_number}}" data-email_address="{{$log->email_address}}"
                  data-website="{{$log->website}}"  >
                  Details
              </button>
          </a> 
          </td>
        </tr>
        @endforeach
      </tbody>

      <tfoot>
    
      </tfoot>
    </table>
    
    
  </div>
  <!-- /.box-body -->
</div>
<!-- /.box -->

{{-- modal facility details --}}
<div class="modal fade" id="view_details" tabindex="-1" role="dialog">
  <div class="modal-dialog " role="document">
      <div class="modal-content">
     
          <div class="modal-body">
              
              <div class="panel-body">
                  
                  <div class="panel-group" id="accordion">
                      {{-- panel one --}}
                      <div class="panel panel-default">
                          <div class="panel-heading">
                              <h4 class="panel-title">
                                  <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Facility Details</a>
                              </h4>
                          </div>
                          <div id="collapse1" class="panel-collapse collapse in">
                              <div class="panel-body">
                                  {{-- <div class="row">
                                      <label class="col-md-4">Facility Code:</label>
                                      <div class="col-md-8" id="facility_code"></div>
                                  </div> --}}
                               
                             
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
                                    <label class="col-md-4 text-md-right">Close Date:</label>
                                    <div class="col-md-8" id="close_date">    </div>
                                </div>
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
                                      <label class="col-md-4 text-md-right">Ownership:</label>
                                      <div class="col-md-8" id="ownership">    </div>
                                  </div>
                                  <div class="row">
                                    <label class="col-md-4 text-md-right"> Level of Care:</label>
                                    <div class="col-md-8" id="facility_level">    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-4 text-md-right">Level of Care Option:</label>
                                    <div class="col-md-8" id="facility_level_option">    </div>
                                </div>
                                  <div class="row">
                                    <label class="col-md-4">Postal Address:</label>
                                    <div class="col-md-8" id="postal_address"></div>
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
                                    <label class="col-md-4">Phone Number:</label>
                                    <div class="col-md-8" id="phone_number"></div>
                                </div>
                            
                                <div class="row">
                                    <label class="col-md-4">Email Address:</label>
                                    <div class="col-md-8" id="email_address"></div>
                                </div>
                                <div class="row">
                                    <label class="col-md-4">Website:</label>
                                    <div class="col-md-8" id="website"></div>
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

@endsection 


@push("bk_script")
<script>
  $(document).ready( function () {
      $('#table1').DataTable( {
        "paging":   true,
        "ordering": true,
        "info":     true,
        responsive: true,
        "order": [[ 0, "desc" ]],
        "columnDefs": [
              {
                  "targets": [ 0 ],
                  "visible": false
              }
          ]

      } );

      $('#view_details').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var modal = $(this)
  
            modal.find('.modal-body #facility_code').text(button.data('facility_code'));
            modal.find('.modal-body #start_date').text(button.data('start_date'));
            modal.find('.modal-body #close_date').text(button.data('close_date'));
            modal.find('.modal-body #facility_name').text(button.data('facility_name'));
            modal.find('.modal-body #alt_facility_name').text(button.data('alt_facility_name'));
            modal.find('.modal-body #state').text(button.data('state'));
            modal.find('.modal-body #lga').text(button.data('lga'));
            modal.find('.modal-body #ward').text(button.data('ward'));
            modal.find('.modal-body #ownership').text(button.data('ownership'));
            modal.find('.modal-body #ownership_type').text(button.data('ownership_type'));
            modal.find('.modal-body #facility_level').text(button.data('facility_level'));
            modal.find('.modal-body #facility_level_option').text(button.data('facility_level_option'));
            modal.find('.modal-body #longitude').text(button.data('longitude'));
            modal.find('.modal-body #latitude').text(button.data('latitude'));
            modal.find('.modal-body #postal_address').text(button.data('postal_address'));
            modal.find('.modal-body #phone_number').text(button.data('phone_number'));
            modal.find('.modal-body #email_address').text(button.data('email_address'));
            modal.find('.modal-body #website').text(button.data('website'));
         
       
        });//end




  } );
</script>
@endpush