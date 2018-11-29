<!-- Modal New -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Add Service</h4>
        </div>
  
          <div class="modal-body">
              <form action="{{route('service.store')}}" method="post">
                  @csrf()
                  <div class="row">
                      <div class="col-md-12">
                              <input name="service" type="text" class="form-control" id="service" placeholder="Enter service" required>
                      </div>
                      <div class="col-md-12">
                              <span class="text-danger">
                                      <strong id="service-error"></strong>
                              </span>
                      </div>
                    
                  </div>
                       
              </form> 
          </div>
  
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button id="save" class="btn btn-primary">Save</button>
          </div>  
        
      </div>
    </div>
  </div>