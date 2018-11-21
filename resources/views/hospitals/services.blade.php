@extends("layouts.master")

@section('bk_css')
<style type="text/css">
    #checkbox-list-container .checkbox-list > li > a {
        display: block;
        padding: 3px 0;
        clear: both;
        font-weight: normal;
        line-height: 1.42857143;
        color: #333;
        white-space: nowrap;
    }
 
    #checkbox-list-container .checkbox-list > li > a:hover,
    #checkbox-list-container .checkbox-list > li > a:focus {
        color: #333;
        text-decoration: none;
        background-color: transparent;
    }
 
    #checkbox-list-container .checkbox-list > .active > a,
    #checkbox-list-container .checkbox-list > .active > a:hover,
    #checkbox-list-container .checkbox-list > .active > a:focus {
        color: #333;
        text-decoration: none;
        background-color: transparent;
        outline: 0;
    }
 
    #checkbox-list-container .checkbox-list > .disabled > a,
    #checkbox-list-container .checkbox-list > .disabled > a:hover,
    #checkbox-list-container .checkbox-list > .disabled > a:focus {
        color: #777;
    }
 
    #checkbox-list-container .checkbox-list > .disabled > a:hover,
    #checkbox-list-container .checkbox-list > .disabled > a:focus {
        text-decoration: none;
        cursor: unset;
        background-color: transparent;
        background-image: none;
        filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);
    }
 
    #checkbox-list-container .checkbox-list > li > a > label {
        padding: 3px 0 3px 20px;
    }
 
    @media (min-width: 768px) {
        #checkbox-list-container .checkbox-list > li {
            float: left;
            width: 33%;
        }
        #checkbox-list-container .checkbox-list-vertical > li {
            float: none;
            width: 100%;
        }
    }
 
    #checkbox-list-container .multiselect-container.checkbox-list {
        position: static;
    }
 
</style>
@endsection

@section('content-title')
<h4><p class="text-aqua">Hospital/Clinic Services</p></h4>
@endsection

@section("content")


<form class="form-horizontal" action="{{route('hospitals.storeservices')}}" method="POST">
    @csrf
       
    <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Services
                    </a>
                </h4>
            </div>
           
            <div class="panel-body">
                    <div class="box-body">
               
                        <div class="form-group">
                            <label class="col-sm-2" style="text-align: right;">Unique ID:</label>
                            <div class="col-sm-4">
                                {{$hosp[0]->unique_id}}                                       
                            </div>
                            <label class="col-sm-2" style="text-align: right;">Facility Name:</label>
                            <div class="col-sm-4">
                                    {{$hosp[0]->facility_name}}                                       
                            </div>      
                         
                        </div>
                    
                        <div class="form-group">
                            <label class="col-sm-2" style="text-align: right;">Services:</label>
                            <div class="col-sm-10">
                                
                                <select class="btn-group" name="services[]" multiple="multiple" id="services" style="width: 100%;" required>
                                    @foreach($categories as $cat)
                                        {{-- <optgroup label = "{{$cat->category}}"> --}}
                                        {{-- <label style="text-align: right;">{{$cat->category}}</label> --}}

                                            @foreach($hs_services as $serv)
                                                @if($cat->id == $serv->category_id)
                                                    @if(in_array($serv->id,$available_services, TRUE))
                                                        <option value="{{$serv->id}}" selected="selected">{{$serv->service}}</option>
                                                    @else
                                                        <option value="{{$serv->id}}">{{$serv->service}}</option>
                                                    @endif
                                                    
                                                @endif
                                            @endforeach
                                        {{-- </optgroup> --}}
                                    @endforeach
                                    
                                </select>  
                                                                                                
                            </div>
                                
                        </div>
                        <input type="hidden"  name="hospital_id" value="{{$hosp[0]->id}}">
                
                
                            
                    </div>
            </div>
        
    </div>
    
<!-- /.box-body -->
<div class="box-footer">
    <a href="{{route('hospitals.index')}}">
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
            $('#services').multiselect({
                enableClickableOptGroups: true,
                includeSelectAllOption:true,
                buttonContainer: '<div id="checkbox-list-container"></div>',
                buttonClass: '',
                templates: {
                    button: '',
                    ul: '<ul class="multiselect-container checkbox-list"></ul>',
                }
            });
        });
    </script>
    <script type="text/javascript">
    
        $('#services6').multiselect({
            enableClickableOptGroups: true,
            includeSelectAllOption: true
        });

        // $(function () {
        //     $('select[multiple]').multiselect({
        //         columns: 4,
        //         search: true,
        //         selectAll: true,
        //         selectGroup: true,
        //         texts    : {
        //             placeholder: 'Select Service',
        //             search     : 'Search Service'
        //         }
               
        //      });

        // });
        
        
        // var data = @json($hs_services);
        // //console.log(data);
        
        // var category = "";
        // var options = [];
        // $.each(data, function(i, item) {
          
        //     if(category != item.category){
        //         category = item.category;
        //     }
            
        //     var opt = {
        //         label  : category,
        //         options: [{
        //             name   : item.service,
        //             value  : item.id,
        //             checked: false
        //         }]
        //     };
        //     options.push(opt);
        // });
        // console.log(options);
 
        // $('#services').multiselect( 'loadOptions', options);
       

        // $('#services').multiselect( 'reload' );

    </script>

@endpush