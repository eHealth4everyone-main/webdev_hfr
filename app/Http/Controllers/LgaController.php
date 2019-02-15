<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lga;

class LgaController extends Controller
{
 

    public function index()
    {
        $lgas =Lga::orderBy('name','ASC')->get();
        return view('masters.lgas.index', compact("lgas"));
    }


    public function store(Request $request)
    {              
        $request->validate([
            'name' => 'required|string|max:40',
            'short_code' => 'required|string|max:2',
        ]);

        $state = new ou_state;
        $state->name = $request->name;
        $state->short_code= $request->short_code;
        $state->save();

        session()->flash("alert-success", "State added successfully!");        
        return back();
    }

    public function update(Request $request)
    {
        $request->validate([
            'name1' => 'required|string|max:40',
            'short_code1' => 'required|string|max:2',
        ]);

        $state = ou_state::findOrFail($request->id);
        $state->name = $request->name1;
        $state->short_code= $request->short_code1;
        $state->save();

        session()->flash("alert-success", "State updated successfully!");
        return back();
    }

    public function destroy(Request $request)
    {
        ou_state::destroy($request->state_id);
        session()->flash("alert-success", "State deleted successfully!");
        return back();
    }

}
