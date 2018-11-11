@extends("layouts.pub.master")

@section('custom_css')

  
@endsection

@section("content")  
<div class="latest-area section-padding bg-white">
    <div class="container">

            <div class="row">
                <div class="col-sm-12">
                    <div class="single-latest-item">      
                            <div id="pop_index" style="min-width: 310px; height: 500px; margin: 0 auto"></div>

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


<script> 

    Highcharts.chart('pop_index', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Population Index Per State'
        },
        subtitle: {
            text: '(Number of Persons Per Facility)'
        },
        xAxis: {
            categories: @json($pop_index_states),
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: ''
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key} State</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">Persons Per Facility: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0,
                dataLabels: {
                    enabled: false
                }
            }
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'States',
            
            data: @json($pop_index_ppf)
        }]
    });

    
</script>

@endpush