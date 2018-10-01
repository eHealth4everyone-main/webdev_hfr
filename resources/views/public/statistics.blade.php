@extends("layouts.public_master")

@section('kibiti_css')

@endsection

@section('content-title')
       
  
@endsection

@section("content")  


<!-- ********************summary one ************ -->
    <div class="row">
        {{-- <div class="col-md-3 col-sm-6 col-xs-12">
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
        </div> --}}
        <!-- /.col -->
        {{-- <div class="col-md-3 col-sm-6 col-xs-12">
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
        </div> --}}
        <!-- /.col -->

        <!-- fix for small devices only -->
        {{-- <div class="clearfix visible-sm-block"></div>

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
        </div> --}}
        <!-- /.col -->
    </div>
    
    <div class="row">
            <div class="col-sm-12">
                    <div class="box box-default">
                        <div class="box-header with-border">
                                <form class="form-horizontal"  action="" method="GET">
                                        @csrf
                                        <div class="form-group">
                                           
                                          <div class="col-sm-5">
                                              <select class="form-control select2" id="state" name ="state">
                                                    @include('public.states')
                                              </select>
                                          </div>
                                          
                                          <div class="col-sm-5">
                                              <select class="form-control select2" id="lga" name="lga">
                                                  <option value="">--Select LGA--</option>
                                              </select>
                                          </div>
                                         
                                        
                                          <div class="col-sm-2">
                                              <button type="submit" class="btn btn-success btn-sm pull-right">Search</button>
                                          </div>
                                        
                                      </div>
                                </form>
                        
                        
                                <h4>Number of Facilities by Type</h4>
                        </div>
                    
                        <div class="box-body">
                               

                                <div class="table-responsive">
                                    <table class="table no-margin">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>Hospitals and Clinics</th>
                                            <th>Pharmaceuticals</th>
                                            <th>Laboratories</th>
                                            <th>Radiologies and Imaging</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                                @foreach($results as $res)
                                                <tr>
                                                <td>Total facilities</td>
                                                  <td>{{$res->hosp}}</td>
                                                  <td>{{$res->pharma}}</td>
                                                  <td>{{$res->lab}}</td>
                                                  <td>{{$res->radio}}</td>
                                                </tr>
                                                @endforeach
                                        <tbody>
                                    </table>
                                </div>
                        </div>
                    </div>
            </div>
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

    

@endsection 

@push('kibiti_scripts')


@include('partials.dynamic_lgas_only')

    
<script>

$(document).ready( function () {
    
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

    
});
</script>

@endpush