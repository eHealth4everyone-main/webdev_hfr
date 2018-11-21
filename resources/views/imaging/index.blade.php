@extends("layouts.master")


@section('content-title')
Radiological Premises

<a href="{{route('imaging.index')}}">
        <button type="button" class="btn btn-primary pull-right">
                Add Radiological Facility
        </button>
    </a>
@endsection

@section("content")
<div class="box">
        <div class="box-body">
         
      <table id="table1" class="table table-bordered table-striped" style="width:100%">
            <thead>
              <tr>
                  <th>State</th>
                  <th>LGA</th>
                  <th>Ward</th>
                  <th>Unique ID</th>
                  <th>Facility Name</th>
                  <th>Ownership</th>
                  <th>Actions</th>
              </tr>
            </thead>
            <tbody>
           
              @foreach($imagings as $im)
              <tr>
                  <td>{{$im->state}}</td>
                  <td>{{$im->lga}}</td>
                  <td>{{$im->ward}}</td>
                  <td>{{$im->unique_id}}</td>
                  <td>{{$im->facility_name}}</td>
                  <td>{{$im->ownership}}</td>
                  <td>
                      <a href="{{route('imaging.show',$im->id)}}">
                        <button class="btn btn-success btn-sm"  type="button">View</button>
                      </a>
                      <a href="{{route('imaging.edit',$im->id)}}">
                        <button class="btn btn-warning btn-sm"  type="button" >Edit</button>
                      </a>
                  </td>
              </tr>
              @endforeach
              
            </tbody>
          </table>
      
        </div>
        <div class="box-footer">
            <div class="row">
              
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
             
                  <div class="col-md-4">
                      Showing {{$from}} to {{$to}} of {{$imagings->total()}} entries
                     
                  </div>
                  <div class="col-md-8">
                      <div class="pull-right">
                          {{$imagings->links()}}                  
                      </div>
                  </div>
  
            </div>
          </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
@endsection 


@push("bk_script")
<script>
  $(document).ready( function () {

  } );
</script>
@endpush