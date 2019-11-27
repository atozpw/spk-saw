<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Position;
use App\Criteria;

class CriteriaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $positions = Position::has('criterias')->orderBy('id', 'desc')->paginate(10);
        return view('criterias.index', compact(['positions']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $positions = Position::all();
        return view('criterias.create', compact(['positions']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->criteria_name) {
            for ($i = 0; $i < count($request->criteria_name); $i++) {
                Criteria::create([
                    'position_id' => $request->position_id,
                    'code' => $request->criteria_code[$i],
                    'name' => $request->criteria_name[$i],
                    'attribute' => $request->criteria_attribute[$i],
                    'weight' => $request->criteria_weight[$i]
                ]);
            }
        }
        
        $request->session()->flash('mess', 'Data berhasil disimpan');

        return redirect('criterias');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $positions = Position::all();
        $position = Position::find($id);
        return view('criterias.edit', compact(['positions', 'position']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->criteria_name) {
            Criteria::where('position_id', $id)->delete();
            for ($i = 0; $i < count($request->criteria_name); $i++) {
                Criteria::create([
                    'position_id' => $request->position_id,
                    'code' => $request->criteria_code[$i],
                    'name' => $request->criteria_name[$i],
                    'attribute' => $request->criteria_attribute[$i],
                    'weight' => $request->criteria_weight[$i]
                ]);
            }
        }
        
        $request->session()->flash('mess', 'Data berhasil diperbaharui');

        return redirect('criterias');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        Criteria::where('position_id', $id)->delete();

        $request->session()->flash('mess', 'Data berhasil dihapus');

        return redirect('criterias');
    }
}
