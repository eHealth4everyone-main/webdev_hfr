@extends("layouts.master")


@section('content-title')
Radiological Premises

    <a href="">
        <button type="button" class="btn btn-info pull-right">
                Add New Imaging
        </button>
    </a>
@endsection

@section("content")
<div class="box">
        <div class="box-body">

          <div class="box-header with-border">
                  {{-- <form class="form-horizontal" action=""> --}}
                      <div class="box-body">
                          <div class="form-group">                   
                              <label for="search" class="col-sm-1 control-label">Search:</label>
                              <div class="col-sm-5">
                                  <input type="text" class="form-control" id="search" name="search" placeholder="Facility, State, LGA">
                              </div>
                          </div>
                      </div>
                  {{-- </form> --}}
          </div>
         
          
          <table id="table1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Unique ID</th>
                <th>Facility Name</th>
                <th>State</th>
                <th>LGA</th>
                <td>Ownership</td>
                <td>Category</td>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
           
              @foreach($imagings as $im)
              <tr>
                <td>{{$im->unique_id}}</td>
                <td>{{$im->fac_name}}</td>
                <td>{{$im->state}}</td>
                <td>{{$im->lga}}</td>
                <td>{{$im->ownership}}</td>
                <td>{{$im->category}}</td>
                <td>
                        <a href="#">
                          <button class="btn btn-info btn-sm"  type="button">Details</button>
                        </a>
                        <a href="#">
                          <button class="btn btn-primary btn-sm"  type="button" > Edit</button>
                        </a>
                      </td>
              </tr>
              @endforeach
              
            </tbody>
          </table>
           {{-- pagination link --}}
           <div class="box-body">
              <div class="text-left">
                  @php
                    $perpage = $imagings->perpage();
                    $currentpage = $imagings->currentpage();
                    $from = ($currentpage-1)*$perpage+1;
                    
                    if ($imagings->currentpage() == $imagings->lastpage()) {
                      $to = $imagings->total();
                    } else {
                      $to = $currentpage*$perpage;
                    }
                  @endphp
                  <label for="">Showing {{$from}} to {{$to}} of {{$imagings->total()}} entries</label>
                 
              </div>
      
              <div class="text-right">
                  {{$imagings->links()}}
              </div>
          </div>

        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
@endsection 


