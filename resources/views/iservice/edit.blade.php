<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Edit Service</h4>
        </div>
        <form action="{{route('iservice.update','id')}}" method="post">
            @csrf
            @method("PUT")
          <div class="modal-body">
                    <input type="hidden" name="service_id" id="id" value="">
                    <div class="row">
                        <div class="col-md-12">
                                <input name="service" type="text" class="form-control" id="service" placeholder="Enter service" required>
                        </div>
                        <div class="col-md-12">
                        
                            @if($errors->any())                       
                                  @foreach($errors->all() as $error)
                                        <span class="text-danger">
                                            <strong > {{$error}}</strong>
                                        </span>
                                  @endforeach
                            @endif

                        </div>
                      
                    </div>                   
               
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </form> 

      </div>
    </div>
  </div> 