@extends("layouts.public_master")


@section('content-title')	

@endsection

@section("content")
<div class="box">
        <div class="box-body">  
          <table id="table1" class="table " style="width:100%">
            <thead>
              <tr>
              
              </tr>
            </thead>
            <tbody>
           
              @foreach($resources as $res)
              <tr>
                <td>
                    @if($res->format=='pdf')
                      <img class="center-block" src="/img/pdf.png"/>
                    @endif
                    @if(($res->format=='doc') or ($res->format=='docx'))
                      <img class="center-block" src="/img/word.png"/>
                    @endif
                    @if(($res->format=='xls') or ($res->format=='xlsx'))
                      <img class="center-block" src="/img/excel.png"/>
                    @endif
                </td>
                <td>{{$res->description}}</td>
                <td>
                    <a href="{{route('downloadFile',$res->filename)}}">
                      <button class="btn btn-success btn-sm" type="button"> Download</button>
                    </a>
                 
                  </td>
              </tr>
              @endforeach
              <form method="POST" action="{{route('updateuser') }}" >

              </form>
            </tbody>
          
          </table>


        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
@endsection 


@push("kibiti_scripts")
<script>
  $(document).ready( function () {
    $('#table1').DataTable( {
      "paging":   true,
      "ordering": false,     
      "lengthChange": false,
      "searching"   : false,
      "autoWidth"   : false,
  } );



} );
</script>
@endpush