@extends("layouts.master")

@section('bk_css')
  
@endsection

@section('content-title')
    Dashboard
@endsection

@section("content")
  <div class="">
        <div class="row">
                <div class="col-md-12">
                    <div class="box box-default">
                            <div id="facility_status"></div>
                    </div>
                </div>
         
        </div>
        <div class="row">
                <div class="col-md-12">
                    <div class="box box-default">
                            <div id="visitors"></div>
                    </div>
                </div>
         
        </div>
      
        <div class="row">
                <div class="col-md-12">
                    <div class="box box-default">
                            <div id="no_downloads"></div>
                    </div>
                </div>
        </div>

       <div class="row">
            <table  id="fac_status_table">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Facility Newly Created</th>
                        <th>Facility Creation Rejected</th>
                        <th>Facility Update Requested</th>
                        <th>Facility Update Rejected</th>
                        <th>Facility Deletion Requested</th>
                        <th>Facility Deletion Rejected</th>
                        <th>Facility Verified</th>
                        <th>Facility Validated</th>
                        <th>Facility Published</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($facility_status as $s)
                            <tr>
                                <td> {{ $s[0] }} </td>
                                <td> {{ $s[1] }} </td>
                                <td> {{ $s[2] }} </td>
                                <td> {{ $s[3] }} </td>
                                <td> {{ $s[4] }} </td>
                                <td> {{ $s[5] }} </td>
                                <td> {{ $s[6] }} </td>
                                <td> {{ $s[7] }} </td>
                                <td> {{ $s[8] }} </td>
                                <td> {{ $s[9] }} </td>
                            </tr>
                        @endforeach
                    <tbody>
            </table>
       </div>
     
  </div>

 
@endsection 

@push('bk_script')
    <script src="{{ asset("hcharts/chart/highcharts.js")}}"></script>
    <script src="{{ asset("hcharts/chart/exporting.js")}}"></script>
    <script src="{{ asset("hcharts/chart/data.js")}}"></script>
   

<script>
//facility status chart
$('#fac_status_table').hide();
        
    Highcharts.chart('facility_status', {
        chart: {
            type: 'column'
            },
            title: {
                text: 'Health Facilities by Status'
            },
            data: {
                table: 'fac_status_table'
            },
         
            yAxis: {
                min: 0,
                title: {
                text: ''
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
                verticalAlign: 'bottom',
                floating: false,
                backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: false
            },
            tooltip: {
                
                pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
            },
            plotOptions: {
                column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: false,
                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                }
                }
            },
            credits: {
                enabled: false
            },
  
    });

//visitors
Highcharts.chart('visitors', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Number of Visitors in the Last 30 days'
    },
    subtitle: {
        text: 'Source: Google Analytics'
    },
    xAxis: {
        categories: @json($dates),
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Visitors'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
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
        name: 'Visits',
        data: @json($visitors)
    }],
    credits: {
        enabled: false
    },
});

//downloads
    Highcharts.chart('no_downloads', {
        title: {
            text: 'Monthly Downloads Requests'
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Downloads Requests'
            }
        },
        series: [{
            name: 'Downloads',
            data: @json($num_downloads)
            }],

        credits: {
                enabled: false
        },
    });



</script>
    


@endpush