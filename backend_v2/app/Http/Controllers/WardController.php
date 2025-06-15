<?php

namespace App\Http\Controllers;

use App\Models\Ward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class WardController extends Controller
{

    public function index()
    {
        // $wards = DB::table('ou_wards')
        //     ->orderByRaw('lga_id,name ASC')
        //     ->paginate(10);

        $wards = DB::table('ou_wards')
            ->join('ou_lgas', 'ou_wards.lga_id', '=', 'ou_lgas.id')
            ->join('ou_states', 'ou_lgas.state_id', '=', 'ou_states.id')
            ->select(
                'ou_wards.*',
                'ou_lgas.name as lga',
                'ou_lgas.id as state_id',
                'ou_states.name as state',
                'ou_lgas.id as lga_id'
            )
            ->orderByRaw('ou_wards.lga_id, ou_wards.name ASC')
            ->paginate(10);


        return view('masters.wards.index', compact("wards"));
    }



    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'state_id' => 'nullable',
            'lga_id' => 'required',
        ]);

        \Log::info($request->all());


        $ward = new Ward();
        $ward->name = $request->name;
        $ward->lga_id = $request->lga_id;
        $ward->save();

        session()->flash("alert-success", "Ward added successfully!");
        return back();
    }

    public function update(Request $request)
    {
        $request->validate([
            'name1' => 'required|string|max:100',
            'state_id1' => 'nullable',
            'lga_id1' => 'required',
        ]);

        $ward = Ward::find($request->id1);
        $ward->name = $request->name1;
        $ward->lga_id = $request->lga_id1;
        $ward->save();

        session()->flash("alert-success", "Ward updated successfully!");
        return back();
    }

    public function destroy(Request $request)
    {
        Ward::destroy($request->ward_id);
        session()->flash("alert-success", "Ward deleted successfully!");
        return back();
    }

    public function search(Request $request)
    {
        // $wards = DB::table('wards')
        //     ->where('state_id', 'like', '%' . $request->state . '%')
        //     ->where('lga_id', 'like', '%' . $request->lga . '%')
        //     ->where('name', 'like', '%' . $request->ward_name . '%')
        //     ->orderBy('state')
        //     ->orderBy('lga')
        //     ->orderBy('name')
        //     ->paginate(10)
        //     ->appends($request->all());

        $wards = DB::table('ou_wards')
            ->join('ou_lgas', 'ou_wards.lga_id', '=', 'ou_lgas.id')
            ->join('ou_states', 'ou_lgas.state_id', '=', 'ou_states.id')
            ->select(
                'ou_wards.*',
                'ou_lgas.name as lga',
                'ou_lgas.id as lga_id',
                'ou_states.name as state',
                'ou_states.id as state_id'
            )
            ->when($request->state, function ($query) use ($request) {
                $query->where('ou_states.id', 'like', '%' . $request->state . '%');
            })
            ->when($request->lga, function ($query) use ($request) {
                $query->where('ou_lgas.id', 'like', '%' . $request->lga . '%');
            })
            ->when($request->ward_name, function ($query) use ($request) {
                $query->where('ou_wards.name', 'like', '%' . $request->ward_name . '%');
            })
            ->orderBy('ou_states.name')
            ->orderBy('ou_lgas.name')
            ->orderBy('ou_wards.name')
            ->paginate(10)
            ->appends($request->all());



        return view('masters.wards.index', compact("wards"));
    }
}
