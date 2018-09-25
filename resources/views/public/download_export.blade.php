@extends("layouts.public_master")

@section('kibiti_css')

@endsection

@section('content-title')
       
  
@endsection

@section("content")   

<div class="">
        <h5><p class="text-light-blue">
       
        </p></h5> 
    </div>
<div class="box">
        <div class="box-header with-border">
                <form class="form-horizontal"  action="{{route('facToDownload')}}" method="GET">
                        @csrf
                        <div class="form-group">
                           
                            <div class="col-sm-4">
                                <select class="form-control select2" id="facilitytype" name="facilitytype" required>
                                    <option value="">--Facility Type--</option>
                                    <option value="1">Hospitals</option>
                                    <option value="2">Laboratories</option>
                                    <option value="3">Pharmaceuticals</option>
                                    <option value="4">Radiology and Imaging</option>
                                </select>
                            </div>
                          <div class="col-sm-4">
                              <select class="form-control select2" id="state" name ="state">
                                  @include('public.states')
                              </select>
                          </div>
                          
                          
                         
                          <div class="col-sm-2">
                             
                          </div>
                          <div class="col-sm-2">
                              <button type="submit" class="btn btn-success pull-right">Search</button>
                          </div>
                        
                      </div>
                    </form>
        </div>
  <div class="box-body">
    
      @if($indx != 1)
          <table id="hosp" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Unique ID</th>
                <th>Facility Name</th>
                <th>State</th>
                <th>LGA</th>
                @if (($type === 1)||($type === 2))
                    <th>Facility Level</th>
                @endif
            
                <th>Ownership</th>
                
              </tr>
            </thead>
            <tbody>
           
              @foreach($facilities as $fac)
              <tr>
                <td>{{$fac->unique_id}}</td>
                <td>{{$fac->facility_name}}</td>
                <td>{{$fac->state}}</td>
                <td>{{$fac->lga}}</td>
                
                @if (($type === 1)||($type === 2))
                    <td>{{$fac->level}}</td>
                @endif
               
                <td>{{$fac->ownership}}</td>
          
              </tr>
              @endforeach
              
            </tbody>
          </table>
      @endif
      <div class="box-footer clearfix">
            <div class="btn-group pull-right">
                <button type="button" class="btn btn-info btn-sm">Download CSV</button>
                <button type="button" class="btn btn-success btn-sm">Download Excel</button>
            </div>
      </div>
    </div>
        <!-- /.box-body -->
      </div> 
      <!-- /.box -->
@endsection 

@push('kibiti_scripts')
@include('partials.dynamic_lgas_only')

<script>
    $(document).ready( function () {
      $('#hosp').DataTable( {
        "paging":   true,
        "ordering": true,
        "info":     true,
        "lengthChange": false,
        "searching"   : true,
        "autoWidth"   : false,
        "pageLength": 20,
    } );
  } );
</script>

@endpush