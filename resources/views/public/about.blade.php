@extends("layouts.usermaster")

@section('content-title')
<h4><strong>ABOUT NIGERIA HEALTH FACILITY REGISTRY (HFR)</strong></h4>

@endsection

@section("content")
<div class="box">
        <div class="box-body">
          The Nigeria Health Facility Registry (HFR) was developed in 2017 as part of effort to dynamically manage
          the Master Health Facility List (MFL) in the country. The MFL "is a complete listing of health facilities in a
          country (both public and private) and is comprised of a set of identification items for each facility
          (signature domain) and basic information on the service capacity of each facility (service domain)".
          <br /><br />
          The Federal Ministry of Health had previously identified the need for an information system to manage
          the MFL in light of different shortcomings encountered in maintaining an up-to-date paper based MFL.
          The benefits of the HFR are numerous including serving as the hub for connecting different information
          systems thereby enabling integration and interoperability, eliminating duplication of health facility lists
          and for planning the establishment of new health facilities. Elaboration on the use cases of importance
          for which the HFR should address was subsequently made.
          <br /><br />
          The development of the HFR followed a consultative process among the different stakeholders working
          within the Federal Ministry of Health, its agencies and development partners.
          <br /><br />
          The steps of the process followed are listed below:
          <br /><br />
          <ol>
            <li>Request and Authorization by the Honorable Minister to commence the process for modifying
          the MFL for the country</li>
            <li>Stakeholder’s workshop in August 2016 at Reiz Continental Hotel during which the classes of
          health facilities to be covered in the HFR and the data elements of importance for each class of
          health facility were identified.</li>
            <li>Establishment of the MFL Technical Working Group co-chaired by the Department of Health
          Planning Research and Statistics and the Department of Hospital Services. Other members were
          the Department of Information and Communications Technology, National Primary Healthcare
          Development Agency, National Population Commission, National Bureau of Statistics, the UN
          agencies including the World Health Organization, World Bank, USAID, HISP Nigeria with
          technical support from MEASURE Evaluation.</li>
            <li>Three state study (FCT, Lagos and Cross River) to understand health facility registration process
          variation and identify potential workflow issues to be built into the HFR. Also opportunity for the
          retrieval of data collection tools used by the different states.</li>
            <li>Consultations with various regulatory agencies including a meeting between the HMH and all
          the regulatory agencies.</li>
            <li>Finalization and approval of data elements for HFR</li>
            <li>Development and testing of the HFR</li>
            <li>Harmonization of different health facility lists and upload into the HFR</li>
            <li>Presentation of the HFR to stakeholders (including the Honorable Minister of Health) and
          obtaining feedback for its improvement</li>
            <li>Development of draft implementation guidelines</li>
            <li>Release of HFR to the public</li>
          </ol>
          
          The Honorable Minister of Health, Prof. Isaac F. Adewole at the presentation of the HFR to him stated
          that 
          <blockquote>
              <p>Asking me to be a champion of the HFR is like preaching to the choir. Take it that I am already a
                  champion</p>
          </blockquote>
          The project was supported by the United States Agency for International Development
                  
          
    
       

        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
@endsection 


@push('kibiti_scripts')

<script>
    $(document).ready( function () {
      $('#hosp').DataTable( {
        "paging":   true,
        "ordering": true,
        "info":     true,
        "lengthChange": true,
        "searching"   : true,
        "autoWidth"   : false,
    } );
  } );
</script>

@endpush