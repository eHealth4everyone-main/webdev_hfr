@extends("layouts.master")


@section('content-title')
Laboratory Premises

@if(auth()->user()->hasPermissionTo(6))
    <a href="{{'laboratory.index'}}">
        <button type="button" class="btn btn-primary pull-right">
                Add New Laboratory
        </button>
    </a>
@endif

@endsection

@section("content")
<div class="box">
        <div class="box-body">

          
          <table id="table1" class="table table-bordered table-striped">
            <thead>
              <tr>
                  <th>State</th>
                  <th>LGA</th>
                  <th>Ward</th>
                  <th>Unique ID</th>
                  <th>Facility Name</th>
                  <th>Facility Level</th>
                  <th>Ownership</th>
                  <th>Actions</th>
              </tr>
            </thead>
            <tbody>
           
              @foreach($labs as $lab)
              <tr>
                  <td>{{$lab->state}}</td>
                  <td>{{$lab->lga}}</td>
                  <td>{{$lab->ward}}</td>
                  <td>{{$lab->unique_id}}</td>
                  <td>{{$lab->facility_name}}</td>
                  <td>{{$lab->facility_level}}</td>
                  <td>{{$lab->ownership}}</td>
                <td>
                    @if(auth()->user()->hasPermissionTo(5))
                        <a href="{{route('laboratory.show',$lab->id)}}">
                            <button class="btn btn-success btn-sm"  type="button">View</button>
                        </a>
                    @endif
                    @if(auth()->user()->hasPermissionTo(7))
                        <a href="{{route('laboratory.edit',$lab->id)}}">
                            <button class="btn btn-warning btn-sm"  type="button" > Edit</button>
                        </a>
                    @endif
                    @if(auth()->user()->hasPermissionTo(8))
                        <a href="">
                            <button class="btn btn-danger btn-sm"  type="button" > Delete</button>
                        </a>
                    @endif
                  </td>
              </tr>
              @endforeach
              
            </tbody>
          </table>
          

        </div>
        <div class="box-footer">
            <div class="row">
              
                  @php
                    $perpage = $labs->perpage();
                    $currentpage = $labs->currentpage();
                    $from = ($currentpage-1)*$perpage+1;
                    
                    if ($labs->currentpage() == $labs->lastpage()) {
                      $to = $labs->total();
                    } else {
                      $to = $currentpage*$perpage;
                    }
                  @endphp
             
                  <div class="col-md-4">
                      Showing {{$from}} to {{$to}} of {{$labs->total()}} entries
                     
                  </div>
                  <div class="col-md-8">
                      <div class="pull-right">
                          {{$labs->links()}}                  
                      </div>
                  </div>
  
            </div>
          </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
@endsection 

@push('bk_script')

<script>
    $(document).ready( function () {
  
  } );
</script>

@endpush
