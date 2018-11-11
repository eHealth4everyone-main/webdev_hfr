@extends("layouts.pub.master")

@section('custom_css')

  
@endsection

@section("content")  
<div class="latest-area section-padding bg-white">
    <div class="container">
            <div class="box-header">
                    <form class="form-horizontal"  action="{{route('getfacilities')}}" method="GET">
                        @csrf
                        <div class="form-group">
                
                                <div class="col-sm-6">
                                        <select class="form-control select2" id="facility_type_id" name="facility_type_id">
                                            @foreach($lst_facility_types as $ty)
                                                <option value="{{$ty->id}}">{{$ty->name}}</option>
                                            @endforeach
                                        </select>
                                </div>
                                    
                                <div class="col-sm-4">
                                    <select class="form-control select2" id="state_id" name ="state_id">
                                        <option value="0">All States</option>
                                        @foreach($lst_states as $st)
                                            <option value="{{$st->id}}">{{$st->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                        
                                <div class="col-sm-2">
                                    <button type="submit" class="btn btn-success btn-sm pull-right">Filter</button>
                                </div>
                      </div>
                    </form>
            
            </div>



            <div class="row" >
                    <div class="col-sm-12">
                            <div class="single-latest-item">      
                                  
                                    <div id="container3" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

                                    <table  id="table3">
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th>Primary</th>
                                                <th>Secondary</th>
                                                <th>Tertiary</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($levels_by_state as $lev)
                                                    <tr>
                                                        <td>{{$lev->state}}</td>
                                                        <td>{{$lev->Primary}}</td>
                                                        <td>{{$lev->Secondary}}</td>
                                                        <td>{{$lev->Tertiary}}</td>
                                                    </tr>
                                                @endforeach
                                            <tbody>
                                    </table>
                            </div>
                 
                    </div>
                
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="single-latest-item">      
                            <div id="levels" style="min-width: 310px; height: 250px; margin: 0 auto"></div>

                    </div>
                </div>

                <div class="col-sm-6">
                        <div class="single-latest-item">      
                                <div id="ownership" style="min-width: 310px; height: 250px; margin: 0 auto"></div>

                        </div>
                       
                </div>
            
                
            </div>
    
    </div>
</div>
@endsection 

@push('custom_scripts')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>

@include('partials.dynamic_lgas_only')

    
<script>
 
    
//Chart 1
        $('#table3').hide();
        
        Highcharts.chart('container3', {
        chart: {
            type: 'column'
            },
            title: {
                text: 'Number of Hospitals and Clinics by Level of Care'
            },
            data: {
                table: 'table3'
            },
         
            yAxis: {
                min: 0,
                title: {
                text: 'Number of facilities'
                },
                stackLabels: {
                enabled: true,
                style: {
                    fontWeight: 'bold',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                }
                }
            },
            legend: {
                align: 'right',
                x: -30,
                verticalAlign: 'top',
                y: 25,
                floating: true,
                backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: false
            },
            tooltip: {
                headerFormat: '<b>{point.x}</b><br/>',
                pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
            },
            plotOptions: {
                column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: true,
                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                }
                }
            },
            credits: {
                enabled: false
            },
  
        });

</script>

    
<script>
        Highcharts.chart('ownership', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Percentage of Hospitals and Clinics by Ownership'
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
Highcharts.chart('levels', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Percentage of Hospitals and Clinics by Level of Care'
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