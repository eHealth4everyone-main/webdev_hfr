@extends("layouts.master")

@section('content-title')
HFR - DHIS2 Exchange



@endsection

@section("content")
<div class="box">
  <div class="box-body">
    <div id='updating'>
        <h4>Updating DHIS2. Please wait...</h4>
    </div>

    <div id='progress' class="progress">
      <div id="dynamic" class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
        <span id="current-progress"></span>
      </div>
    </div>
    <div id='fac_error' class="alert alert-warning alert-dismissible">
        <h4><i class="icon fa fa-warning"></i> Warning!</h4>
        Something went wrong while creating facility!
    </div>
    <div id='fac_success' class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Success!</h4>
        Facility successfully created!
    </div>

  </div>
  <!-- /.box-body -->
</div>
<!-- /.box -->
@endsection 



@push('bk_script')

<script>
$(document).ready(function() {
      $("#fac_error").hide();
      $("#fac_success").hide();


      var current_progress = 0;
      $(document).ajaxStart(function(){
          var interval = setInterval(function() {
              current_progress += 5;
              $("#dynamic")
              .css("width", current_progress + "%")
              .attr("aria-valuenow", current_progress)
              .text(current_progress + "%");
              if (current_progress >= 100)
                  clearInterval(interval);
          }, 1000);
      });
  

      var ward_id = '{{ old('ward_id') }}';
      var facility_name = '{{ old('facility_name') }}';
      var alt_facility_name = '{{ old('alt_facility_name') }}';
      var start_date = '{{ old('start_date') }}';
      var postal_address = '{{ old('postal_address') }}';
      var email_address = '{{ old('email_address') }}';
      var website = '{{ old('website') }}';
      var longitude = '{{ old('longitude') }}';
      var latitude = '{{ old('latitude') }}';
      var phone_number = '{{ old('phone_number') }}';
      var _token = $('input[name="_token"]').val();
      
      $.ajax({
          url:"{{route('dhis.store')}}",
          method:"POST",
          data:{ward_id:ward_id,facility_name:facility_name,start_date:start_date,postal_address:postal_address,
                email_address:email_address,website:website,longitude:longitude,latitude:latitude,
                alt_facility_name:alt_facility_name,phone_number:phone_number, _token:_token},
          success:function(result)
          {
              console.log(result);
          }         
      })   

  
      $(document).ajaxStop(function(){
        current_progress = 95;
        $("#dynamic")
              .css("width", current_progress + "%")
              .attr("aria-valuenow", current_progress)
              .text(current_progress + "%");
        $("#fac_success").show();
        $("#progress").hide();
        $('#updating').hide();
        
        
      });
      

				
});

// $(function() {

// });


</script>

@endpush