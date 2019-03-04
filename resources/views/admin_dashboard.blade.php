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

       <div class="row" >
            <table  id="fac_status_table">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Pending Creation</th>
                        <th>Facility Verified</th>
                        <th>Facility Creation Rejected</th>
                        <th>Facility Validated</th>
                        <th>Facility Created</th>
                        <th>Pending Update</th>
                        <th>Facility Update Rejected</th>
                        <th>Facility Updated</th>
                        <th>Pending Deletion</th>
                        <th>Facility Deletion Rejected</th>
                        <th>Facility Deleted</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($facility_status as $status)
                            <tr>
                             <td>{{ $status->state }}</td>
                             <td>{{ $status->Pending_Creation }}</td>
                             <td>{{ $status->Facility_Verified }}</td>
                             <td>{{ $status->Facility_Creation_Rejected }}</td>
                             <td>{{ $status->Facility_Validated }}</td>
                             <td>{{ $status->Facility_Created }}</td>
                             <td>{{ $status->Pending_Update }}</td>
                             <td>{{ $status->Facility_Update_Rejected }}</td>
                             <td>{{ $status->Facility_Updated }}</td>
                             <td>{{ $status->Pending_Deletion }}</td>
                             <td>{{ $status->Facility_Deletion_Rejected }}</td>
                             <td>{{ $status->Facility_Deleted }}</td>

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