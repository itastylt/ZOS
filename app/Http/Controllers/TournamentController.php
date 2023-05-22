<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\Tournament;
use Illuminate\Support\Facades\DB;


class TournamentController extends Controller
{
    function openTournamentsPage(Request $request){
        $is_organisator = $request->session()->get('is_organisator');
        $tournaments = DB::table('tournament')
            ->select('tournament.*', 'game_mode.name as game_mode', 'game.name as game_name')
            ->selectRaw('COUNT(participates_in.fk_Playerid) as playercount')
            ->leftJoin('participates_in', 'participates_in.fk_Tournamentid', '=', 'tournament.id')
            ->leftJoin('game_mode', 'game_mode.id', '=', 'tournament.fk_Gamemodeid')
            ->leftJoin('game', 'game.id', '=', 'game_mode.fk_Gameid')
            ->groupBy('tournament.id')
            ->get();


        $tournaments = $this->orderTournaments($tournaments);
        $liked = [];
        if ($this->checkLikedTournaments()!=0){
            $liked = $this->insertLikedList();
        }
        return view('TournamentsPage', compact('tournaments', 'liked', 'is_organisator'));
    }
    function orderTournaments($tournaments){
        return $tournaments->sortByDesc(function($tournament){
            return $tournament->playercount;
        });
    }
    function checkLikedTournaments(){
        return 0;
    }
    function insertLikedList(){
        return [];
    }

    public function renderTournamentCreationPage(Request $request) {
        $is_organisator = $request->session()->get('is_organisator');
        return view('TournamentCreationPage', compact('is_organisator'));
    }
}
