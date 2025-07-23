<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resource;
use Illuminate\Support\Facades\Storage;

class ResourceController extends Controller
{

    public function index()
    {
        $resources = Resource::all();
        return view('resources.index', compact("resources"));
    }
    public function public_index()
    {
        $resources = Resource::all();
        return view('public.resources', compact("resources"));
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

        // Handle file uploads
        $filePath = $request->hasFile('resourcefile')
            ? env('APP_URL') . "/storage/" . $request->file('resourcefile')->store('resources', 'public')
            : null;

        $extension = $request->file('resourcefile')->getClientOriginalExtension();

        $resource = new Resource;
        $resource->filename = $filePath;
        $resource->description = $request->filename;
        $resource->format = $extension;
        $resource->save();

        session()->flash("alert-success", "File uploaded successfully!");
        return redirect()->route('resources');
    }


    public function update(Request $request)
    {
        $request->validate([
            'filename1' => 'required|string|max:90',
        ]);


        // Handle file uploads
        $filePath = $request->hasFile('resourcefile')
            ? env('APP_URL') . "/storage/" . $request->file('resourcefile')->store('resources', 'public')
            : null;

        $extension = $request->file('resourcefile')->getClientOriginalExtension();

        $resource = Resource::find($request->id);
        $resource->filename = $filePath;
        $resource->format = $extension;
        $resource->description = $request->filename1;
        $resource->save();

        session()->flash("alert-success", "Document updated successfully!");
        return redirect()->route('resources');
    }

    public function download($filename)
    {
        // $file= public_path(). "/storage/resources/".$filename;
        // // dd($file);
        // return response()->download($file);
        $file_path = storage_path('app/public/resources/' . $filename);
        return response()->download($file_path);
    }


    public function destroy(Request $request)
    {
        // Extract the base filename only
        $filename = basename($request->filename);
        $docId = $request->doc_id;

        $file_path = storage_path('app/public/resources/' . $filename);
        \Log::info("File path: " . $file_path);

        if (file_exists($file_path)) {
            unlink($file_path);
            \Log::info("File deleted with unlink(): " . $filename);
        } else {
            \Log::warning("File not found, skipping unlink(): " . $request->filename);
        }

        Resource::destroy($docId);

        session()->flash("alert-success", "Document deleted successfully!");
        return redirect()->route('resources');
    }
}
