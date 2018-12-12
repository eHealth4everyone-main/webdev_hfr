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
                            <div id="visitors"></div>
                    </div>
                </div>
         
        </div>
      
        <div class="row">
                <div class="col-md-6">
                    <div class="box box-default">
                            <div id="no_downloads"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box box-default">
                        <div id="no_feedback"></div>

                    </div>
                </div>
        </div>

     
  </div>

 
@endsection 

@push('bk_script')
    <script src="{{ asset("hcharts/chart/highcharts.js")}}"></script>
    <script src="{{ asset("hcharts/chart/exporting.js")}}"></script>
 

<script>
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

//feedback chart
    Highcharts.chart('no_feedback', {
        title: {
            text: 'Monthly User Feedback'
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Number of feedback'
            }
        },

        series: [{
            name: 'feedbacks',
            data: @json($num_feedbacks)
            }],

            credits: {
                enabled: false
            },
    });


</script>
    


@endpush