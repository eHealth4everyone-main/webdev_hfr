@extends("layouts.pub.master")

@section('kibiti_css')

@endsection


@section("content")  



<div class="latest-area section-padding bg-white">
    <div class="container">
            <div class="box-header">
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
                                                
            </div>
            
        <div class="row">
                <div class="col-sm-12">
                          
                        <div class="single-latest-item">
                               
                            <div class="single-latest-text">
                                    <h4>Number of Facilities by Type</h4>

                                    <div class="display" style="width:100%">
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
                    <div class="single-latest-item">
                    
                    
                        <div class="single-latest-text">
                                <h4>Number of facilities by Ownership</h4>
                                <div class="display" style="width:100%">
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
                    <div class="single-latest-item">
                           
                            <div class="single-latest-text">
                                    <h4>Number of facilities by Level of Care </h4>
                                    <div class="display">
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

    </div> 
</div> {{--  --}}

@endsection 

@push('kibiti_scripts')

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>

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
        "pageLength": 8,
    } );
     //table 2
     $('#table2').DataTable( {
        "paging":   true,
        "ordering": false,
        "info":     true,
        "lengthChange": false,
        "searching"   : true,
        "autoWidth"   : false,
        "pageLength": 8,
    } );

    
});
</script>

@endpush