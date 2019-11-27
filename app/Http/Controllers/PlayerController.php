<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Player;
use App\Position;

class PlayerController extends Controller
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
        $players = Player::orderBy('id', 'desc')->paginate(10);
        return view('players.index', compact(['players']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $positions = Position::all();
        return view('players.create', compact(['positions']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Player::create([
            'name' => $request->name,
            'team' => $request->team,
            'number' => $request->number,
            'position_id' => $request->position_id
        ]);

        $request->session()->flash('mess', 'Data berhasil disimpan');

        return redirect('players');
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
        $player = Player::find($id);
        $positions = Position::all();

        return view('players.edit', compact(['player', 'positions']));
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
        $player = Player::find($id);
        $player->update([
            'name' => $request->name,
            'team' => $request->team,
            'number' => $request->number,
            'position_id' => $request->position_id
        ]);

        $request->session()->flash('mess', 'Data berhasil diperbaharui');

        return redirect('players');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        Player::destroy($id);

        $request->session()->flash('mess', 'Data berhasil dihapus');

        return redirect('players');
    }
}
