<?php

namespace App\Http\Controllers;

use App\ImagingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ImagingServiceController extends Controller
{

    public function index()
    {
        //
        $services =ImagingService::all();
        return view('iservice.index', compact("services"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {              
        $validator = Validator::make($request->all(), [
            'service' => 'required|max:100',
        ]);

        if ($validator->passes()) {

            $service = new ImagingService;
            $service->im_service_name = $request->service;
            $service->save();
        
            return response()->json(['success'=>'Service successfully added']); 
        }
        
        return response()->json(['errors' => $validator->errors()]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'service' => 'required|max:100',
        ]);
        
        $iservice=ImagingService::findOrFail($request->service_id);
        $iservice->im_service_name=$request->service;
        $iservice->save();

        session()->flash("alert-success", "Service updated successfully!");
        return back();
        
    }

  
    public function destroy(Request $request, ImagingService $image)
    {
        ImagingService::destroy($request->service_id);
        session()->flash("alert-success", "Service deleted successfully!");
        return back();
    }
}
