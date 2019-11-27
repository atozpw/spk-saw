<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Position;
use App\Criteria;
use App\Player;
use App\Statistic;

class StatisticController extends Controller
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
    public function index(Request $request)
    {
        $positions = Position::orderBy('id', 'desc')->get();

        if ($request->position_id) {
            $criterias = Criteria::where('position_id', $request->position_id)->get();
            $players = Player::where('position_id', $request->position_id)->get();
        }
        else {
            $criterias = Criteria::where('position_id', $positions[0]->id)->get();
            $players = Player::where('position_id', $positions[0]->id)->get();
        }

        return view('statistics.index', compact(['positions', 'criterias', 'players']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Statistic::where('position_id', $request->position_id)->delete();

        if ($request->player_id) {
            for ($i = 0; $i < count($request->player_id); $i++) {
                for ($j = 0; $j < count($request->criteria_id[$i]); $j++) {
                    Statistic::create([
                        'position_id' => $request->position_id,
                        'player_id' => $request->player_id[$i],
                        'criteria_id' => $request->criteria_id[$i][$j],
                        'value' => $request->value[$i][$j]
                    ]);
                }
            }
        }

        $request->session()->flash('mess', 'Data berhasil diperbaharui');

        return redirect('statistics');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
