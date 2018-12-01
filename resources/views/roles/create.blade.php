@extends("layouts.master")

@section('bk_css')

@endsection

@section('content-title')

@endsection

@section("content")


<form class="form-horizontal" action="{{route('roles.store')}}" method="POST">
    @csrf
       
    <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        User Role
                    </a>
                </h4>
            </div>
           
            <div class="panel-body">
                    <div class="box-body">
               
                            <div class="form-group row">
                                    <label style="text-align: right;" class="col-md-2 col-form-label text-md-right">Role:<font color="red">*</font> </label>
                                    <div class="col-md-8">
                                            <input id="role" type="text" class="form-control" name="role" required autofocus>
                                    <span class="text-danger">
                                        <strong id="role-error"></strong>
                                    </span>
                                    </div>
                            </div>      
                            <div class="form-group row">
                                <label style="text-align: right;" class="col-md-2 col-form-label text-md-right">Description:<font color="red">*</font> </label>
                                <div class="col-md-8">
                                        <input id="description" type="text" class="form-control" name="description" required>
                                <span class="text-danger">
                                    <strong id="descr-error"></strong>
                                </span>
                                </div>
                             </div> 
                     
                            <div class="form-group row">
                                <label class="col-sm-2" style="text-align: right;">Permissions:<font color="red">*</font></label>
                                <div class="col-sm-2">                               
                                        <input type='checkbox' id='check_all'> Check All                                                  
                                </div>
                                                            
                            </div>
                            <div class="form-group row">
                                    <label class="col-sm-2"></label>
                                    <div class="col-sm-2">                               
                                        <input type='checkbox'name='permissions[]' value='1'> View Hospitals                                                    
                                    </div>
                                    <div class="col-sm-2">                               
                                        <input type='checkbox'name='permissions[]' value='2'> Add Hospitals                                                   
                                    </div>
                                    <div class="col-sm-2">                               
                                        <input type='checkbox'name='permissions[]' value='3'> Update Hospitals                                                
                                    </div>
                                    <div class="col-sm-2">                               
                                        <input type='checkbox'name='permissions[]' value='4'> Delete Hospitals                                                       
                                    </div>
                                    <div class="col-sm-2"></div>                              
                                </div>
                            <div class="form-group row">
                                <div class="col-sm-2"></div>   
                                <div class="col-sm-2">                               
                                    <input type='checkbox'name='permissions[]' value='5'> View Laboratories 
                                </div>
                                <div class="col-sm-2">                               
                                    <input type='checkbox'name='permissions[]' value='6'> Add Laboratories
                                </div>
                                <div class="col-sm-2">                               
                                        <input type='checkbox'name='permissions[]' value='7'> Update Laboratories  
                                </div>
                                <div class="col-sm-2">                               
                                        <input type='checkbox'name='permissions[]' value='8'> Delete Laboratories
                                </div>
                                <div class="col-sm-2"></div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2"></div>   
                                <div class="col-sm-2">                               
                                        <input type='checkbox'name='permissions[]' value='9'> View Pharmacies
                                </div>
                                <div class="col-sm-2">                               
                                        <input type='checkbox'name='permissions[]' value='10'> Add Pharmacies
                                </div>
                                <div class="col-sm-2">                               
                                        <input type='checkbox'name='permissions[]' value='11'> Update Pharmacies  
                                </div>
                                <div class="col-sm-2">                               
                                        <input type='checkbox'name='permissions[]' value='12'> Delete Pharmacies  
                                </div>
                                <div class="col-sm-2"></div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2"></div>   
                                <div class="col-sm-2">                               
                                    <input type='checkbox'name='permissions[]' value='13'> View Radiologies
                                </div>
                                <div class="col-sm-2">                               
                                    <input type='checkbox'name='permissions[]' value='14'> Add Radiologies
                                </div>
                                <div class="col-sm-2">                               
                                    <input type='checkbox'name='permissions[]' value='15'> Update Radiologies
                                </div>
                                <div class="col-sm-2">                               
                                        <input type='checkbox'name='permissions[]' value='16'> Delete Radiologies
                                </div>
                                <div class="col-sm-2"></div>
                            </div>
                            <div class="form-group row">
                                    <div class="col-sm-2"></div>   
                                    <div class="col-sm-2">                               
                                            <input type='checkbox'name='permissions[]' value='17'> View Users
                                    </div>
                                    <div class="col-sm-2">                               
                                            <input type='checkbox'name='permissions[]' value='18'> Add Users
                                    </div>
                                    <div class="col-sm-2">                               
                                            <input type='checkbox'name='permissions[]' value='19'> Update Users
                                    </div>
                                    <div class="col-sm-2">                               
                                            <input type='checkbox'name='permissions[]' value='20'> Delete Users
                                    </div>
                                    <div class="col-sm-2"></div>
                            </div>
                            <div class="form-group row">
                                    <div class="col-sm-2"></div>   
                                    <div class="col-sm-2">                               
                                            <input type='checkbox'name='permissions[]' value='21'> View Roles
                                    </div>
                                    <div class="col-sm-2">                               
                                            <input type='checkbox'name='permissions[]' value='22'> Add Roles
                                    </div>
                                    <div class="col-sm-2">                               
                                            <input type='checkbox'name='permissions[]' value='23'> Update Roles
                                    </div>
                                    <div class="col-sm-2">                               
                                            <input type='checkbox'name='permissions[]' value='24'> Delete Roles
                                    </div>
                                    <div class="col-sm-2"></div>
                            </div>
  
                            <div class="form-group row">
                                    <div class="col-sm-2"></div>   
                                    <div class="col-sm-2">                               
                                            <input type='checkbox'name='permissions[]' value='25'> View Resources
                                    </div>
                                    <div class="col-sm-2">                               
                                            <input type='checkbox'name='permissions[]' value='26'> Add Resources
                                    </div>
                                    <div class="col-sm-2">                               
                                            <input type='checkbox'name='permissions[]' value='27'> Update Resources
                                    </div>
                                    <div class="col-sm-2">                               
                                            <input type='checkbox'name='permissions[]' value='28'> Delete Resources
                                    </div>
                                    <div class="col-sm-2"></div>
                            </div>
                            <div class="form-group row">
                                    <div class="col-sm-2"></div>   
                                    <div class="col-sm-2">                               
                                            <input type='checkbox'name='permissions[]' value='29'> View Feedbacks
                                    </div>
                                    <div class="col-sm-3">                               
                                            <input type='checkbox'name='permissions[]' value='30'> View Download Request
                                    </div>
                                    <div class="col-sm-2">                               
                                            
                                    </div>
                                    <div class="col-sm-2">                               
                                            
                                    </div>
                                    <div class="col-sm-2"></div>
                            </div>
                        {{-- <input type="hidden"  name="hospital_id" value="{{$hosp[0]->id}}"> --}}
                
                
                            
                    </div>
            </div>
        
    </div>
    
<!-- /.box-body -->
<div class="box-footer">
    <a href="{{route('roles.index')}}">
        <button type="button" class="btn btn-warning">Return Back</button>
    </a>
    <button type="submit" class="btn btn-primary pull-right">Save Record</button>
</div>
<!-- /.box-footer -->
</form>

@endsection 



@push('bk_script')
    @include('partials.notification')

    <script type="text/javascript">
        $(document).ready(function() {
            $('#check_all').click(function() {
                var c = this.checked;
                $(':checkbox').prop('checked',c);
            });
        });

    </script>


@endpush