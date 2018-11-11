@extends("layouts.pub.master")

@section('custom_css')
 
@endsection



@section("content")
<div class="latest-area section-padding bg-white">
        <div class="container">
                <div class="row">
                        <div class="col-sm-6">
                                <div id="map1" style="height: 500px; min-width: 500px; max-width: 800px; margin: 0 auto" ></div>
                         
                        </div>
                        <div class="col-sm-6">
                          <div id="map2" style="height: 500px; min-width: 500px; max-width: 800px; margin: 0 auto" ></div>
                   
                        </div>
                            
                </div>
          </div>        

</div>

<div id="myModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
           
          </div>
                    
        </div>
  </div>   
    </div>
  </div>
</div>



@endsection 

@push('custom_scripts')
<script src="{{ asset("js/highmaps.js")}}"></script>
<script src="{{ asset("js/drilldown.js")}}"></script>
<script src="{{ asset("js/exporting.js")}}"></script>




<script>

   //all states map
    var data= @json($total_facilities_state);

    $.getJSON('geo/All_States.geojson', function (geojson) {

    // Initiate the chart
    Highcharts.mapChart('map1', {
        chart: {
            map: geojson
        },

        title: {
            text: 'Number of Hospitals and Clinics'
        },

        mapNavigation: {
            enabled: true,
            buttonOptions: {
                verticalAlign: 'top'
            }
        },
        legend: {
                layout: 'vertical',
                align: 'left',
                verticalAlign: 'middle'
        },
        colorAxis: {
            min: 0,
            minColor: '#E6E7E8',
            maxColor: '#008000'
        },
        credits: {
            enabled: false
        },
  

        series: [{
            data: data,
            keys: ['statecode', 'value'],
            joinBy: 'statecode',
            name: 'Hospitals and Clinics',
            states: {
                hover: {
                    color: '#BADA56'
                }
            },
            dataLabels: {
                enabled: true,
                format: '{point.properties.statename}'
            },
      
            point:{
                events:{
                    click: function(){
                        showState(this.statecode);
                    }
                }
            }
        }]
    
    });//highmpa end

    });//all states map ends
  

//load state map
function showState(statecode){
    
    var path = "geo/";
    file = statecode.concat(".geojson");
    full_path = path.concat(file);

    //get number of facilities of selected state by lga
    
        $.ajax({
                url:"{{route('getFacilitesByLGA')}}",
                method:"POST",
                data:{state_code:statecode, _token: "{{ csrf_token() }}"},
                success:function(result)
                {
                    var statename= result.state[0];

                    //if success get and display map
                    $.getJSON(full_path, function (geojson) {

                        // Initiate the chart
                        Highcharts.mapChart('map2', {
                            chart: {
                                map: geojson
                            },
                                        
                            title: {
                                text: 'Number of Hospitals and Clinics'
                            },
                            subtitle: {
                                text: statename.concat(" State")
                            },

                            legend: {
                                layout: 'vertical',
                                align: 'left',
                                verticalAlign: 'middle'
                            },
                            colorAxis: {
                                min: 1,
                                minColor: '#E6E7E8',
                                maxColor: '#9A5A4D'
                            },

                            mapNavigation: {
                                enabled: true,
                                buttonOptions: {
                                    verticalAlign: 'top',
                                    align: 'right'
                                }
                            },

                            credits: {
                                enabled: false
                            },

                            series: [{
                                data: result.facilities,
                                keys: ['LGA_UID','value'],
                                joinBy: ['LGA_UID'],
                                name: 'Health Facilities',
                                states: {
                                    hover: {
                                        color: '#BADA56'
                                    }
                                },
                                dataLabels: {
                                    enabled: true,
                                    format: '{point.properties.lganame}'
                                },
                            }]

                        });//chart ends

                    });
                }//success ends         
        });//ajax ends
  
}//end show state


     



</script>
    

@endpush