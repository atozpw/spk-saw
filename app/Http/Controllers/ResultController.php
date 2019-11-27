<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Position;
use App\Criteria;
use App\Player;

class ResultController extends Controller
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

        return view('results.index', compact(['players', 'criterias', 'positions']));
    }
}
