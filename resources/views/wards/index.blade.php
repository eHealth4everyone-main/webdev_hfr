@extends("layouts.master")


@section('content-title')
List of Wards	
<a href="">
    <button type="button" class="btn btn-primary pull-right">
            Create Ward
    </button>
</a>
@endsection

@section("content")
<div class="box">
        <div class="box-body">  
          <table id="table1" class="table table-striped table-bordered" style="width:100%">
            <thead>
              <tr>
                <th>State</th>
                <th>LGA</th>
                <th>Ward ID</th>
                <th>Ward</th>
              </tr>
            </thead>
            <tbody>
           
                @foreach($wards as $w)
                <tr>
                  <td>{{$w->state}}</td>
                  <td>{{$w->lga}}</td>
                  <td>{{$w->id}}</td>
                  <td>{{$w->name}}</td>
                </tr>
                @endforeach
                
              </tbody>
          
          </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <div class="row">
              
                  @php
                    $perpage = $wards->perpage();
                    $currentpage = $wards->currentpage();
                    $from = ($currentpage-1)*$perpage+1;
                    
                    if ($wards->currentpage() == $wards->lastpage()) {
                      $to = $wards->total();
                    } else {
                      $to = $currentpage*$perpage;
                    }
                  @endphp
             
                  <div class="col-md-4">
                      Showing {{$from}} to {{$to}} of {{$wards->total()}} entries
                     
                  </div>
                  <div class="col-md-8">
                      <div class="pull-right">
                          {{$wards->links()}}                  
                      </div>
                  </div>

            </div>
          </div>
</div>
      <!-- /.box -->
@endsection 


@push("bk_script")

@endpush