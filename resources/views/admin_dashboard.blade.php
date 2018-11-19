@extends("layouts.master")

@section('bk_css')
  
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
                        <div id="no_feedback"></div>

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
    {{-- <script src="{{ asset("hcharts/chart/series-label.js")}}"></script> --}}
    <script src="{{ asset("hcharts/chart/highcharts.js")}}"></script>
    <script src="{{ asset("hcharts/chart/exporting.js")}}"></script>
 
<script>
  
</script>
<script>

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
                text: 'Downloads Requests'
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