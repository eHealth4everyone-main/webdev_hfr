@extends('layouts.public_master')

@section('content-title')
    <h3>Contact Us </h3> 
@endsection

@section('content')

<div class="box box-default">
        <div class="box-header with-border">
            <h4>Please fill the following form to contact us</h4>
        </div>
    <div class="box-body">
    <div class="row">
        <div class="col-md-4">
            
                <h4><strong>Federal Ministry of Health <br></strong></h4> 
                <strong>Department of Health Planning Research and Statistics </strong>
                <br>
                <br>
                <strong> Address <br></strong>
                New Federal Secretariat Complex, Phase III, <br>
                Ahmadu Bello Way, Central Business District,<br>
                FCT Abuja, Nigeria <br>
                <br>
                <strong>Telephone<br></strong>
                HMH Office: 08127256638<br>
                HMSH Office: 08022139767<br>
                <br>
                <strong> Email <br></strong>                    
                <a href=""> hfr@health.gov.ng<br></a>
                <a href="">info@health.gov.ng<br></a>
                <a href="">hmoffice@health.gov.ng<br></a>
          
        </div>
        <div class="col-md-8">
                <form method="POST" action="{{route('storecontact')}}" class="form-horizontal">
                        @csrf

                        <div class="form-group row">
                            <label for="firstname" class="col-md-2 control-label">Your Name<font color="red">*</font> </label>

                            <div class="col-md-10">
                                <input id="name" type="text"  name="name" class="form-control" value="{{ old('name') }}" placeholder="Full name" required autofocus>
                            </div>
                        </div>
                
                            <div class="form-group row">
                                    <label for="email" class="col-md-2 control-label">Your E-Mail<font color="red">*</font> </label>
        
                                    <div class="col-md-10">
                                        <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="E-mail address" required>
      
                                    </div>
                            </div>
                            <div class="form-group row">
                                    <label for="subject" class="col-md-2 control-label">Subject<font color="red">*</font> </label>
        
                                    <div class="col-md-10">
                                        <input id="subject" type="text" name="subject" class="form-control" value="{{ old('subject') }}" placeholder="Subject" required>
        
  
                                    </div>
                            </div>
                      
                     
                        <div class="form-group row">
                                <label for="message" class="col-md-2 control-label">Message<font color="red">*</font> </label>
    
                                <div class="col-md-10">
                                    <textarea  id="message" name="message" class="form-control" rows="10" value="{{ old('message') }}" placeholder="Your message.." required></textarea>
                          
                                </div>
                        </div>
                      
                   

                        <div class="box-footer">
                            
                                <button type="submit" class="btn btn-success pull-right">Send </button>
                        </div>
                    </form>
    </div>
        </div>
    </div>
   
</div>
@endsection

@push('kibiti_scripts')
    @include('partials.notification')

@endpush