@extends("layouts.master")


@section('content-title')
Facilities Status Summary

@endsection

@section("content")
 
 
<div class="box">
    
        <div class="box-body">
                <form class="form-horizontal"  action="{{route('status.report')}}" method="GET">
                        @csrf
            
                        <div class="form-group">
                                <label class="col-sm-2">State: </label>
                                <div class="col-sm-8">
                                        <select class="form-control select2" id="state_id" name ="state_id">
                                            <option value="1">All States</option>
                                            @foreach(getStates() as $st)
                                            <option value="{{$st->id}}"  {{ ($st->id == $data['state_id'] ? "selected":"") }}>{{$st->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                            
                                    <div class="col-sm-2">
                                            <button type="submit" class="btn btn-success btn-block pull-right  btn-sm">Filter</button>
                                    </div> 
                                </div>     
                </form>

                @if ($facility_status->count() == 0)
                    <div class="alert alert-success alert-dismissible">
                        No record found!
                    </div>
                @else

                <table id="table2" class="table table-bordered table-striped">
                        <thead>
                                <tr>
                                    @if ($data['state_id']==1)
                                        <th>State</th>
                                    @else
                                        <th>LGA</th>                                        
                                    @endif
                                    <th>Pending Creation</th>
                                    <th>Facility Verified</th>
                                    <th>Facility Creation Rejected</th>
                                    <th>Facility Validated</th>
                                    <th>Facility Created</th>
                                    <th>Pending Update</th>
                                    <th>Facility Update Rejected</th>
                                    <th>Facility Updated</th>
                                    <th>Pending Deletion</th>
                                    <th>Facility Deletion Rejected</th>
                                    <th>Facility Deleted</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($facility_status as $status)
                                        <tr>
                                            @if ($data['state_id']==1)
                                                <td>{{ $status->state }}</td>
                                            @else
                                                <td>{{ $status->lga }}</td>
                                            @endif
                                         <td>{{ $status->Pending_Creation }}</td>
                                         <td>{{ $status->Facility_Verified }}</td>
                                         <td>{{ $status->Facility_Creation_Rejected }}</td>
                                         <td>{{ $status->Facility_Validated }}</td>
                                         <td>{{ $status->Facility_Created }}</td>
                                         <td>{{ $status->Pending_Update }}</td>
                                         <td>{{ $status->Facility_Update_Rejected }}</td>
                                         <td>{{ $status->Facility_Updated }}</td>
                                         <td>{{ $status->Pending_Deletion }}</td>
                                         <td>{{ $status->Facility_Deletion_Rejected }}</td>
                                         <td>{{ $status->Facility_Deleted }}</td>
            
                                        </tr>
                                    @endforeach
                                <tbody>
                </table>
            @endif
        
        
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
    
        {{-- download buttons  --}}
        <div class="btn-group pull-right">
            <form class="form-horizontal"  action="{{route('status.download')}}" method="post">
                @csrf
                
                <input type="hidden" id="state_id" name="state_id" value="{{ $data['state_id'] }}">  

                <button type="submit" class="btn btn-primary btn-sm" name='format' value='xls'>Download</button>

            </form>
        </div>

      
    </div>
    
</div>
<!-- /.box -->

    
@endsection 
    
    
@push('bk_script')
    @include('partials.notification')
    @include('partials.dynamic_state_script')

    <script>
        
        $(document).ready( function () {
            $('#table2').DataTable( {
                "paging":   true,
                "ordering": true,
                "info":     true
            });

        });
    
    
     
    </script>
    
@endpush