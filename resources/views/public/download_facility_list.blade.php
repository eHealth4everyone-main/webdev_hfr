@extends("layouts.pub.master")

@section('custom_css')
@endsection



@section("content")   
<div class="latest-area section-padding bg-white">
        <div class="container">
    
        <div class="box-header">
            <form class="form-horizontal"  action="{{route('downloadFacilityFilter')}}" method="GET">
                @csrf
                <div class="form-group">
                    <div class="col-sm-4">
                            <select class="form-control select2" id="facility_type_id" name="facility_type_id">
                                    @foreach($lst_facility_types as $ty)
                                        <option value="{{$ty->id}}">{{$ty->name}}</option>
                                    @endforeach
                            </select>
                        </div>
                    <div class="col-sm-4">
                            <select class="form-control select2" id="state_id" name ="state_id">
                                    <option value="0">All States</option>
                                    @foreach($lst_states as $st)
                                        <option value="{{$st->id}}">{{$st->name}}</option>
                                    @endforeach
                            </select>
                    </div>         
                    
                    <div class="col-sm-4" >
                        <div class="pull-right">
                                <button type="submit" class="btn btn-success pull-right btn-sm">Filter</button>
                        </div>
                    
                    </div>
                    
                        
              </div>
            </form>
    
        </div>
      
            <div class="box-body">                
    
                    <table id="hosp" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>State</th>
                            <th>LGA</th>
                            <th>Unique ID</th>
                            <th>Facility Name</th>
                            <th>Facility Level</th>
                            <th>Ownership</th>
                        </tr>
                        </thead>
                        <tbody>
                    
                            @foreach($facilities as $fac)
                            <tr>
                            
                            <td>{{$fac->state}}</td>
                            <td>{{$fac->lga}}</td>
                            <td>{{$fac->unique_id}}</td>
                            <td>{{$fac->facility_name}}</td>
                            <td>{{$fac->facility_level}}</td>
                            <td>{{$fac->ownership}}</td>
                        
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                
                </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <div class="row">
                  
                      @php
                        $perpage = $facilities->perpage();
                        $currentpage = $facilities->currentpage();
                        $from = ($currentpage-1)*$perpage+1;
                        
                        if ($facilities->currentpage() == $facilities->lastpage()) {
                          $to = $facilities->total();
                        } else {
                          $to = $currentpage*$perpage;
                        }
                      @endphp
                 
                      <div class="col-md-4">
                          Showing {{$from}} to {{$to}} of {{$facilities->total()}} entries
                         
                      </div>
                      <div class="col-md-8">
                          <div class="pull-right">
                              {{$facilities->links()}}                  
                          </div>
                      </div>
                </div>
                {{-- download buttons  --}}
                <div class="btn-group pull-right">
                        <a href="{{route('export',['type'=>$facility_type_id,'state'=>$state_id,'format'=>'csv'])}}">
                            <button type="button" class="btn btn-info btn-sm">Download CSV</button>
                        </a>
                        <a href="{{route('export',['type'=>$facility_type_id,'state'=>$state_id,'format'=>'excel'])}}">
                            <button type="button" class="btn btn-success btn-sm">Download Excel</button>
                        </a>
                </div>

            </div>
        </div> <!-- /contanier-->
    </div> <!-- / -->

@endsection 

@push('custom_scripts')
    @include('partials.notification')

    <script>
        $(document).ready( function () {
            $("#state_id").val({{$state_id}}).change();
            $("#facility_type_id").val({{$facility_type_id}}).change();
    
        });
    </script>

@endpush