@extends("layouts.pub.master")

@section('kibiti_css')
 
@endsection



@section("content")
<div class="latest-area section-padding bg-white">
        <div class="container">
                <div class="row">
                        <div class="col-sm-12">
                                <div id="map1" style="height: 500px; min-width: 500px; max-width: 800px; margin: 0 auto" ></div>
                         
                        </div>
                            
                </div>
          </div>        

</div>


@endsection 

@push('kibiti_scripts')
<script src="{{ asset("js/highmaps.js")}}"></script>
<script src="{{ asset("js/drilldown.js")}}"></script>

<script>
$(document).ready( function () {
    var data = [
        ['RI', 0],
        ['KT', 1],
        ['SO', 2],
        ['ZA', 3],
        ['YO', 4],
        ['KB', 5],
        ['AD', 6],
        ['BR', 7],
        ['AK', 8],
        ['AB', 9],
        ['IM', 10],
        ['BY', 11],
        ['BE', 12],
        ['CR', 13],
        ['TA', 14],
        ['KW', 15],
        ['LA', 16],
        ['NI', 17],
        ['FC', 18],
        ['OG', 19],
        ['ON', 20],
        ['EK', 21],
        ['OS', 22],
        ['OY', 23],
        ['AN', 24],
        ['BA', 25],
        ['GO', 26],
        ['DE', 27],
        ['ED', 28],
        ['EN', 29],
        ['EB', 30],
        ['KD', 31],
        ['KO', 32],
        ['PL', 33],
        ['NA', 34],
        ['JI', 35],
        ['KN', 36]
];


$.getJSON('geo/states.geojson', function (geojson) {

    // Initiate the chart
    Highcharts.mapChart('map1', {
        chart: {
            map: geojson
        },

        title: {
            text: 'Number of Health Facilities'
        },

        mapNavigation: {
            enabled: true,
            buttonOptions: {
                verticalAlign: 'top'
            }
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
            name: 'Health Facilities',
            states: {
                hover: {
                    color: '#BADA56'
                }
            },
            dataLabels: {
                enabled: true,
                format: '{point.properties.statename}'
            }
        }]

    });//highmpa end

});
  


     

} );//doc end

</script>
    

@endpush