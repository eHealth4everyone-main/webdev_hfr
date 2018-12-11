@extends("layouts.master")


@section('content-title')
Pharmaceutical Premises	

@if(auth()->user()->hasPermissionTo(10))
  <a href="{{route('pharmacies.create')}}">
    <button type="button" class="btn btn-primary pull-right">
      Create Pharmacy
    </button>
  </a>
@endif
@endsection

@section("content")
<div class="box">
  <div class="box-body">
    
    
    <table  class="table table-bordered table-striped" style="width:100%">
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
        
        @foreach($pharmacies as $ph)
        <tr>
            <td>{{$ph->state}}</td>
            <td>{{$ph->lga}}</td>
            <td>{{$ph->ward}}</td>
            <td>{{$ph->unique_id}}</td>
            <td>{{$ph->facility_name}}</td>
            <td>{{$ph->ownership}}</td>

          <td>
            @if(auth()->user()->hasPermissionTo(9))
              <a href="{{route('pharmacies.show',$ph->id)}}">
                <button class="btn btn-success btn-sm"  type="button">View</button>
              </a>
            @endif
            @if(auth()->user()->hasPermissionTo(11))
              <a href="{{route('pharmacies.edit',$ph->id)}}">
                <button class="btn btn-warning btn-sm"  type="button" > Edit</button>
              </a>
            @endif
            @if(auth()->user()->hasPermissionTo(12))
              <a href="">
                <button class="btn btn-danger btn-sm"  type="button" > Delete</button>
              </a>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>

      <tfoot>
    
      </tfoot>
    </table>
    
    
  </div>
  <!-- /.box-body -->
  <div class="box-footer">
      <div class="row">
        
            @php
              $perpage = $pharmacies->perpage();
              $currentpage = $pharmacies->currentpage();
              $from = ($currentpage-1)*$perpage+1;
              
              if ($pharmacies->currentpage() == $pharmacies->lastpage()) {
                $to = $pharmacies->total();
              } else {
                $to = $currentpage*$perpage;
              }
            @endphp
       
            <div class="col-md-4">
                Showing {{$from}} to {{$to}} of {{$pharmacies->total()}} entries
               
            </div>
            <div class="col-md-8">
                <div class="pull-right">
                    {{$pharmacies->links()}}                  
                </div>
            </div>

      </div>
    </div>
</div>
<!-- /.box -->
@endsection 


@push("bk_script")
<script>
  $(document).ready( function () {
    $('#table1').DataTable( {
      "paging":   true,
      "ordering": true,
      "info":     true
    } );
  } );
</script>
@endpush