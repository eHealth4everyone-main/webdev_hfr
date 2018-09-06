@extends("layouts.usermaster")

@section('kibiti_css')
  <script src="{{asset("https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js")}}"></script>
@endsection

@section('content-title')
    Dashboard
@endsection

@section("content")
  <div class="">
        <div class="row">
                <div class="col-sm-8">
                    <div class="box box-default">
                  <img class="img-responsive center-block" src="/img/map.png" title="Nigeria Health Facility Registry">
                 
                    </div>
                </div>
                <div class="col-md-4">
                        <div class="box box-default">
                            <canvas id="myChart2"></canvas>
                        </div>
                        
                </div>  
                
        </div>
   
        <div class="row">
                <div class="col-md-6">
                    <div class="box box-default">
                        <canvas id="myChart2"></canvas>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box box-default">
                        NA
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

@push('kibiti_scripts')

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
    
    {{-- Summary of fac types --}}
    <script>
        var ctx = document.getElementById("myChart2").getContext('2d');
     
        var no_factypes = [{{$factypes[0]->total}},{{$factypes[1]->total}},{{$factypes[2]->total}},{{$factypes[3]->total}}];
        
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ["Hospitals", "Pharmaceuticals", "Laboratories", "Imaging"],
                datasets: [{
                    
                    data: no_factypes,
                    backgroundColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                    
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                       
                    ],
                    borderWidth: 1
                }]
            },
            options: {
            
                title:{
                    display:true,
                    text:'Facilities by Type',
                    fontSize:20
                },
                legend:{
                    dislay:false,
                    position:'bottom',
                }
            }
        });
        </script>


@endpush