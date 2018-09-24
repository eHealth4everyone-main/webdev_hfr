@extends("layouts.public_master")

@section('kibiti_css')

@endsection

@section('content-title')
       
  
@endsection

@section("content")  
<div class="box">
    
        <div class="box-body">
            <form class="form-horizontal"  action="{{route('getfacilities')}}" method="GET">
                @csrf
                <div class="form-group">
                   
                  <div class="col-sm-4">
                      <select class="form-control select2" id="state" name ="state">
                            @include('public.states')
                      </select>
                  </div>
                  
                  <div class="col-sm-4">
                      <select class="form-control select2" id="lga" name="lga">
                          <option value="">--Select LGA--</option>
                      </select>
                  </div>
                 
                
                  <div class="col-sm-4">
                      <button type="submit" class="btn btn-success pull-right">Search</button>
                  </div>
                
              </div>
            </form>
    
        </div>
    
    </div>  


    <div class="row" >
        <div class="col-sm-12">
            <div class="box box-info">
                <div class="box-header with-border">
                <h3 class="box-title"> </h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
                </div>
                <div class="box-body">
                        <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                </div>
            </div>
        </div>
      
    </div>

    <div class="row">
       <div class="col-sm-6">
            <div class="box box-primary">
                    <div class="box-header with-border">
                    <h3 class="box-title">Facilities by Level of Care </h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                    </div>
                    <div class="box-body">
                            <div id="levels" style="min-width: 310px; height: 250px; margin: 0 auto"></div>
                    </div>
                </div>
        </div>

        <div class="col-sm-6">
                <div class="box box-success">
                        <div class="box-header with-border">
                        <h3 class="box-title">Facilities by Ownership </h3>
    
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                        </div>
                        <div class="box-body">
                                <div id="ownership" style="min-width: 310px; height: 250px; margin: 0 auto"></div>
                        </div>
                    </div>
        </div>
     
        
    </div>
    

@endsection 

@push('kibiti_scripts')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

@include('partials.dynamic_lgas_only')

    
<script>

$(document).ready( function () {
    //barchart
    var states= @json($state_name);
    var num_states=@json($num_of_fac);

    Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Number of Health Facilities per State'
    },

    xAxis: {
        categories: states,
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
        text: 'Number of facilities'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
        '<td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
        pointPadding: 0.2,
        borderWidth: 0
        }
    },
    series: [{
        name: 'Facilities',
        data: num_states

    }],
    credits: {
            enabled: false
        },
    });


    });

    

////pi chart by ownership
        Highcharts.chart('ownership', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: ''
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
            data: [{
            name: 'Public',
            y: {{$facbyownership[1]}}
            }, {
            name: 'Private',
            y: {{$facbyownership[0]}}
            }]
        }],
        credits: {
                    enabled: false
                },
        });

</script>
<script> 
//facilities by levels
Highcharts.chart('levels', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: ''
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
            data: [{
            name: 'Primary',
            y: {{$facbylevels[0]}},
            sliced: true,
            selected: true
            }, {
            name: 'Secondary',
            y: {{$facbylevels[1]}}
            },  {
            name: 'Tertiary',
            y: {{$facbylevels[2]}}
            }]
        }],
        credits: {
                    enabled: false
                },
        });
</script>

@endpush