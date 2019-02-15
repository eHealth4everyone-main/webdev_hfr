<!-- Modal delete record -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
          <div class="modal-content">
           
          <form action="{{route('service.destroy','id')}}" method="post">
              @csrf
              @method("DELETE")
              <div class="modal-body">
                  <p class="text-center">
                    Are you sure you want to delete this service?
                  </p>
                    <input type="hidden" name="service_id" id="id" value="">  
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">No</button>
                <button type="submit" class="btn btn-warning btn-sm">Yes</button>
              </div>
            </form>
            
          </div>
        </div>
 </div> 
      