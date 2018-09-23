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
                          <option value="">--Select State--</option>
                          <option value='01' > Abia</option>
                          <option value='02' > Adamawa</option>
                          <option value='03' > Akwa Ibom</option>
                          <option value='04' > Anambra</option>
                          <option value='05' > Bauchi</option>
                          <option value='06' > Bayelsa</option>
                          <option value='07' > Benue</option>
                          <option value='08' > Borno</option>
                          <option value='09' > Cross River</option>
                          <option value='10' > Delta</option>
                          <option value='11' > Ebonyi</option>
                          <option value='12' > Edo</option>
                          <option value='13' > Ekiti</option>
                          <option value='14' > Enugu</option>
                          <option value='37' > FCT</option>
                          <option value='15' > Gombe</option>
                          <option value='16' > Imo</option>
                          <option value='17' > Jigawa</option>
                          <option value='18' > Kaduna</option>
                          <option value='19' > Kano</option>
                          <option value='20' > Katsina</option>
                          <option value='21' > Kebbi</option>
                          <option value='22' > Kogi</option>
                          <option value='23' > Kwara</option>
                          <option value='24' > Lagos</option>
                          <option value='25' > Nasarawa</option>
                          <option value='26' > Niger</option>
                          <option value='27' > Ogun</option>
                          <option value='28' > Ondo</option>
                          <option value='29' > Osun</option>
                          <option value='30' > Oyo</option>
                          <option value='31' > Plateau</option>
                          <option value='32' > Rivers</option>
                          <option value='33' > Sokoto</option>
                          <option value='34' > Taraba</option>
                          <option value='35' > Yobe</option>
                          <option value='36' > Zamfara</option>
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

<!-- ********************summary one ************ -->
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-hospital-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Hospitals and Clinics</span>
            <span class="info-box-number">
                    @foreach ($results as $res)
                        {{$res->hosp}}
                    @endforeach
                </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-stethoscope"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Pharmaceuticals</span>
              <span class="info-box-number">
                    @foreach ($results as $res)
                    {{$res->pharma}}
                @endforeach
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-medkit"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Laboratories</span>
              <span class="info-box-number">
                    @foreach ($results as $res)
                    {{$res->lab}}
                @endforeach
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa  fa-plus-square"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Radiologies</span>
              <span class="info-box-number">
                    @foreach ($results as $res)
                    {{$res->radio}}
                @endforeach
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>
      <!-- *******************summary 1 ends**************** -->

    {{-- summary 2 --}}
    <div class="row">
        <div class="col-sm-6">
                <div class="box box-success">
                    <div class="box-header with-border">
                    <h3 class="box-title">Number of facilities by Ownership</h3>
    
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                    </div>
                
                    <div class="box-body">
                            <div class="table-responsive">
                                <table class="table no-margin" id="table1">
                                    <thead>
                                    <tr>
                                        <th>State</th>
                                        <th>Public</th>
                                        <th>Private</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                            @foreach($fac_ownerships as $own)
                                            <tr>
                                              <td>{{$own->state}}</td>
                                              <td>{{$own->Public}}</td>
                                              <td>{{$own->Private}}</td>
                                              <td>{{$own->Total}}</td>
                                            </tr>
                                            @endforeach
                                    <tbody>
                                </table>
                            </div>
                    </div>
                </div>
        </div>
        <div class="col-sm-6">
                <div class="box box-info">
                        <div class="box-header with-border">
                        <h3 class="box-title">Number of facilities by Level of Care </h3>
        
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                        </div>
                        <div class="box-body">
                                <div class="table-responsive">
                                        <table class="table no-margin" id="table2">
                                            <thead>
                                            <tr>
                                                <th>State</th>
                                                <th>Primary</th>
                                                <th>Secondary</th>
                                                <th>Tertiary</th>
                                                <th>Total</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($fac_levels as $lev)
                                                    <tr>
                                                        <td>{{$lev->state}}</td>
                                                        <td>{{$lev->Primary}}</td>
                                                        <td>{{$lev->Secondary}}</td>
                                                        <td>{{$lev->Tertiary}}</td>
                                                        <td>{{$lev->Total}}</td>
                                                    </tr>
                                                @endforeach
                                            <tbody>
                                        </table>
                                    </div>
                        </div>
                    </div>
        </div>
    
        
    </div>
    {{-- summary 2 ends --}}


    <div class="row" >
        <div class="col-sm-12">
                <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        </div>
    </div>

    

@endsection 

@push('kibiti_scripts')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

@include('partials.dynamic_lgas_only')

    
<script>

$(document).ready( function () {
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

    //table 1
    $('#table1').DataTable( {
        "paging":   true,
        "ordering": false,
        "info":     true,
        "lengthChange": false,
        "searching"   : true,
        "autoWidth"   : false,
        "pageLength": 5,
    } );
     //table 2
     $('#table2').DataTable( {
        "paging":   true,
        "ordering": false,
        "info":     true,
        "lengthChange": false,
        "searching"   : true,
        "autoWidth"   : false,
        "pageLength": 5,
    } );
</script>

@endpush