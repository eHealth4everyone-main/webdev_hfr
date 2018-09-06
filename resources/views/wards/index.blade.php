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
                <th>Local Government Area(LGA)</th>
                <th>Ward Name</th>
              </tr>
            </thead>
          
          </table>


        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
@endsection 


@push("bk_script")
<script>
      $(function() {
          $('#table1').DataTable({
              processing: true,
              serverSide: true,
              ordering: true,
              ajax: '{{route('wards.listwards')}}',
              columns: [
                  { data: 'state', name: 'state' },
                  { data: 'lga', name: 'lga' },
                  { data: 'ward', name: 'ward' }
              ]
          });
      });
</script>
@endpush