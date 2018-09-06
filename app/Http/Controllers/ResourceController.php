<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Resource;
use Illuminate\Support\Facades\Storage;

class ResourceController extends Controller
{

    public function index()
    {
        $resources =Resource::all();
        return view('resources.index',compact("resources"));
    }
    public function public_index()
    {
        $resources =Resource::all();
        return view('public.resources',compact("resources"));
    }

  
    public function upload()
    {
        return view('resources.upload');
        
    }

    public function store(Request $request)
    {
        $request->validate([
            'filename' => 'required|string|max:90',
            'resourcefile' => 'mimes:doc,pdf,xls,xlsx,docx|required|max:1999',    
        ]);

        if ($request->hasFile('resourcefile')){
            $filenamewithExt=$request->file('resourcefile')->getClientOriginalName();
            $filename = pathInfo($filenamewithExt,PATHINFO_FILENAME);
            $extension = $request->file('resourcefile')->getClientOriginalExtension();
            $filenametoStore = $filename.'_'.time().'.'.$extension;

            $path = $request->file('resourcefile')->storeAs('public/resources',$filenametoStore);
        }
     
        $resource = new Resource;
        $resource->filename = $filenametoStore;
        $resource->description = $request->filename;
        $resource->format = $extension;
        $resource->save();

        session()->flash("alert-success", "File uploaded successfully!");
        return redirect()->route('resources');

        }

    public function download($filename)
    {
        $file= public_path(). "/storage/resources/".$filename;   
        return response()->download($file);
        
        //return Storage::download($file);
    }

    public function destroy($id)
    {
        //
    }
}
