@extends("layouts.master")

@section('bk_css')
  <script src="{{asset("https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js")}}"></script>
@endsection

@section('content-title')
    Dashboard
@endsection

@section("content")
  <div class="">
      
        <div class="row">
                <div class="col-md-6">
                    <div class="box box-default">
                            <div id="no_downloads"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box box-default">
                        <canvas id=""></canvas>
                    </div>
                </div>
        </div>

        <div class="row">
                <div class="col-md-6">
                    <div class="box box-default">
                        NA
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box box-default">
                        NA
                    </div>
                </div>    
        </div>
  </div>

 
@endsection 

@push('bk_script')
<script src="{{ asset("js/highcharts.js")}}"></script>
<script src="{{ asset("js/series-label.js")}}"></script>
<script src="{{ asset("js/exporting.js")}}"></script>

<script>
  
</script>
<script>

Highcharts.chart('no_downloads', {

        title: {
        text: 'Number Monthly Downloads Requests'
        },
        xAxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        yAxis: {
        title: {
            text: 'Number of Downloads'
        }
        },
        legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
        },

        plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
            }
        },

        series: [{
        name: 'Downloads',
        data: [40, 50, 77, 15, 50, 41, 53, 65]
        }],

        responsive: {
        rules: [{
            condition: {
            maxWidth: 500
            },
            chartOptions: {
            legend: {
                layout: 'horizontal',
                align: 'center',
                verticalAlign: 'bottom'
            }
            }
        }]
      
        },
        credits: {
            enabled: false
        },

});
</script>

    


@endpush