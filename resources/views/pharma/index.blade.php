@extends("layouts.master")


@section('content-title')
Pharmaceutical Premises	

<a href="/pharma/create">
  <button type="button" class="btn btn-primary pull-right">
    Add New Pharmacy
  </button>
</a>
@endsection

@section("content")
<div class="box">
  <div class="box-body">
    
    
    <table id="table1" class="table table-bordered table-striped" style="width:100%">
      <thead>
        <tr>
          <th>Unique ID</th>
          <th>Facility Name</th>
          <th>State</th>
          <th>LGA</th>
          <th>Ownership</th>
          <th>Category</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        
        @foreach($pharmas as $ph)
        <tr>
          <td>{{$ph->sig_unique_id}}</td>
          <td>{{$ph->reg_fac_name}}</td>
          <td>{{$ph->state}}</td>
          <td>{{$ph->lga}}</td>
          <td>{{$ph->ownership}}</td>
      
          @if ($ph->category == 1)
              <td>Standalone</td>
          @else
              <td>Institution</td>
          @endif

          <td>
            <a href="{{route('pharma.show',$ph->id)}}">
              <button class="btn btn-success btn-sm"  type="button">View</button>
            </a>
            <a href="{{route('pharma.edit',$ph->id)}}">
              <button class="btn btn-warning btn-sm"  type="button" > Edit</button>
            </a>
          </td>
        @endforeach
      </tbody>

      <tfoot>
    
      </tfoot>
    </table>
    
    
  </div>
  <!-- /.box-body -->
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