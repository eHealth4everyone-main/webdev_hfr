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
                <div class="col-sm-12">
                    <div class="box box-default">
                        <canvas id="myCdddhart"></canvas>
                    </div>
                </div>
                
        </div>
        <div class="row">
                <div class="col-md-6">
                    <div class="box box-default">
                        <canvas id=""></canvas>
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

<script>
    var ctx = document.getElementById("myChart").getContext('2d');
    
    var states= @json($state_name);
    var num_states=@json($num_of_fac);

    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: states,
            datasets: [{
                label: 'States',
                data: num_states,
                borderWidth: 1,
                // fillColor: 'rgba(54, 162, 235, 1)',
                // strokeColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 1)',
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            },
            title:{
                display:true,
                text:'# of Facilities per State',
                fontSize:20
            },
            legend:{
                dislay:false,
                position:'right',
            }
        }
    });
    </script>
    


@endpush