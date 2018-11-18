@extends("layouts.pub.master")

@section('custom_css')

@endsection



@section("content")
<div class="latest-area section-padding bg-white">
    <div class="container">
        
        <div class="row">
           
            <div class="col-sm-8">
                    <div id="backDiv" style="height: 30px">
                            <button id="backbutton" style="display: none" class="btn btn-success btn-sm" type="button">Return Back</button>
                    </div>
                <div id="map1" style="height: 500px; min-width: 500px; max-width: 800px; margin: 0 auto" >
                    
                </div>
            </div> 
            <div class="col-sm-4">
                    <div class="single-latest-item">      
                            <div id="levels" style="min-width: 310px; height: 250px; margin: 0 auto"></div>

                    </div>
                    <div class="single-latest-item">      
                            <div id="ownership" style="min-width: 310px; height: 250px; margin: 0 auto"></div>

                    </div>
            </div>

            
        </div>
    </div>        
    
</div>


<!-- Goolge Map Modal -->
<div class="modal fade" id="googleMapModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Facilities in LGA</h4>
            </div>
            <div class="modal-body">
                <div id="googleMap" style="height: 500px; min-width: 500px; max-width: 800px; margin: 0 auto"></div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



@endsection 

@push('custom_scripts')
    <script src="{{ asset("hcharts/chart/highcharts.js")}}"></script>
 
    <script src="{{ asset("hcharts/map/exporting.js")}}"></script>
    <script src="{{ asset("hcharts/map/data.js")}}"></script>
    <script src="{{ asset("hcharts/map/map.js")}}"></script>
   
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAF8UERyCqSP9JZ_HfvfPH2cM_6-slYd7Q" async defer></script>

<script>
    
    window.onload = function() {
        $('#backbutton').hide(0);
        showAllStatesMap();
    };
    
    $("#backbutton").click(function(){
        $('#backbutton').hide(0);
        showAllStatesMap();
    });
    
    
    function showAllStatesMap(){
        
        var data= @json($total_facilities_state);
        
        $.getJSON('geo/All_States.geojson', function (geojson) {
            
            // Initiate the chart
            Highcharts.mapChart('map1', {
                chart: {
                    map: geojson
                },
                
                title: {
                    text: 'Distribution of Hospitals and Clinics'
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
                                showSelectedState(this.statecode);
                            }
                        }
                    }
                }]
                
            });//highmpa end
            
        });//all states map ends
        
    }
    
    //load state map
    function showSelectedState(statecode){
        $('#backbutton').show();
        
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
                
                //if success get and display the state map
                $.getJSON(full_path, function (geojson) {
                    
                    // Initiate the chart
                    Highcharts.mapChart('map1', {
                        chart: {
                            map: geojson
                        },
                        
                        title: {
                            text: 'Distribution of Hospitals and Clinics'
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
                            maxColor: '#418E41'
                        },
                        
                        mapNavigation: {
                            enabled: true,
                            buttonOptions: {
                                verticalAlign: 'top',
                                align: 'left'
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
                            point:{
                                events:{
                                    click: function(){
                                        // Get the modal
                                        $('#googleMapModal').modal('show');
                                                                             
                                        showGoogleMap(statecode,this.LGA_UID)
                                    }
                                }
                            }
                        }]
                        
                    });//chart ends
                    
                });
            }//success ends         
        });//ajax ends
        
    }//end show state
    
    // Re-init map before show modal
    $('#googleMapModal').on('show.bs.modal', function(event) {
        // initializeGMap(button.data('lat'), button.data('lng'));
    })
    
    //on click of lga map, this function will load state map and get 
    //facilities with coordinates and display on google map
    function showGoogleMap(statecode,lgacode){
        //get path for geojson file for state
        var path = "geo/";
        file = statecode.concat(".geojson");
        full_path = path.concat(file);
        
        
        //get facilities with geo coorindates
        $.ajax({
            url:"{{route('getFacilitesGMap')}}",
            method:"POST",
            data:{lga_code:lgacode, _token: "{{ csrf_token() }}"},
            success:function(result)
            {
                var locations = result.facilities_list;
                //set the title of modal form
                var modalTitle = "Hospitals and Clinics in ".concat(result.lga_name);
                modalTitle = modalTitle.concat(" LGA")
                $('#myModalLabel').text(modalTitle);

                //google map functions starts here

                //get the first coordinate to center the map
                var lati,longi;
                $.each(locations, function(i, item) {   
                    lati = item.latitude;
                    longi = item.longitude;
                    return false;
                });

                var map = new google.maps.Map(document.getElementById('googleMap'), {
                    zoom: 9,
                    center: new google.maps.LatLng(lati, longi),
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });
                
                map.data.loadGeoJson(full_path);
                
                var infowindow = new google.maps.InfoWindow();
                
                var marker;
                $.each(locations, function(i, item) {
                    
                    marker = new google.maps.Marker({
                        position: new google.maps.LatLng(item.latitude, item.longitude),
                        map: map
                    });
                    
                    google.maps.event.addListener(marker, 'click', (function(marker, i) {
                        return function() {
                            infowindow.setContent(item.facility_name);
                            infowindow.open(map, marker);
                        }
                    })(marker, i));
                    
                });
                
                
            }//success ends         
        });//ajax ends
        
    }//end function
    
    
    
</script>
{{-- show facility by leveles chart--}}
<script> 
        Highcharts.chart('levels', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: "Hospitals and Clinics by Level of Care"
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                plotOptions: {
                    pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                        style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        }
                    }
                    }
                },
                series: [{
                    name: 'Facilities',
                    colorByPoint: true,
                    data: @json($facilities_level_state)
                }],
                credits: {
                            enabled: false
                        },
                });
                
</script>
{{-- show facilities by ownership sumary --}}
<script>
        Highcharts.chart('ownership', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: "Hospitals and Clinics by Ownership"
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
            }
        },
        series: [{
            name: 'Facilities',
            colorByPoint: true,
            data: @json($facilities_ownership_state)
        }],
        credits: {
                    enabled: false
                },
        });

</script>

@endpush