<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tournament;
use Illuminate\Support\Facades\DB;
use App\Models\Game;
use App\Models\Team;
use App\Models\GameMode;
use App\Models\Transaction;
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
    public function validateForm(Request $request) {
        $request->validate([
            'game' => 'required',
            'game_mode' => 'required',
            'max_team_count' => 'required',
            'player_count' => 'required',
            'price_pool' => 'required',
            'join_price' => 'required',
            'registration_start' => 'required',
            'registration_end' => 'required'
        ]);

        $team_size = $request->input('max_team_count');
        $playerCount = $request->input('player_count');
        $isDigit = ($playerCount % $team_size) == 0 ? true : false;
        if($isDigit) {
            $gameMode = new GameMode;
            $gameMode->name = $request->input('game_mode');
            $gameMode->team_size = $playerCount / $team_size;
            $gameMode->fk_Gameid = $request->input('game');
            $gameMode->save();
            $transaction = new Transaction;
            $transaction->change_value = -$request->input('price_pool');
            $transaction->comment = "Sent ".$request->input('price_pool')." e transaction to PaySera";
            $transaction->time = date("Y/m/d");
            $transaction->fk_PlayerId = $request->session()->get('id');
            $transaction->save();
            $this->validatePayment($transaction, $request->input('price_pool'));
            $tournament = new Tournament;
            $tournament->current_stage = 0;
            $tournament->max_team_count = $request->input('max_team_count');
            $tournament->player_count = $request->input('player_count');
            $tournament->prize_pool = $request->input('price_pool');
            $tournament->join_price = $request->input('join_price');
            $tournament->registration_start = $request->input('registration_start');
            $tournament->registration_end = $request->input('registration_end');
            $tournament->status = 0;
            $tournament->tournament_start = $request->input('tournament_start');
            $tournament->fk_Gamemodeid = $gameMode->id;
            $tournament->fk_Organizerid = $request->session()->get('id');
            $tournament->save();
            return redirect('/');
        }


    }
    public function validatePayment(Transaction $transaction,int $price) {
        return $transaction->comment = "Confirmed ". $price." e transaction from PaySera";
    }
    public function renderTournamentCreationPage(Request $request) {
        $is_organisator = $request->session()->get('is_organisator');
        $games = Game::all();
        return view('TournamentCreationPage', compact('is_organisator', 'games'));
    }

    public function initiateTournament(Request $request, int $id) {
        $tournament = Tournament::find($id);
        if($tournament) {
            if($request->session()->get('id') == $tournament->fk_Organizerid) {
                $tournamentExtended = DB::table('tournament')->selectRaw('COUNT(participates_in.fk_Playerid) as playercount');
                die(print_r($tournamentExtended));
            }
        }
    }

    function openTournamentPage($id){
        $teams = Team::where("fk_Tournamentid", $id)->get();
        $tournament = Tournament::findOrFail($id);
        if (!$tournament){
            return redirect()->back();
        }
        $tournamentExtended = DB::table('tournament')
            ->select('tournament.*', 'game_mode.name as game_mode', 'game.name as game_name')
            ->selectRaw('COUNT(participates_in.fk_Playerid) as playercount')
            ->leftJoin('participates_in', 'participates_in.fk_Tournamentid', '=', 'tournament.id')
            ->leftJoin('game_mode', 'game_mode.id', '=', 'tournament.fk_Gamemodeid')
            ->leftJoin('game', 'game.id', '=', 'game_mode.fk_Gameid')
            ->where('tournament.id', $tournament->id)
            ->groupBy('tournament.id')
            ->get();
        return view('TournamentPage', compact('tournamentExtended', 'teams'));
    }

    function joinTournament($id){
        return $this->openTournamentPage($id);
    }
}
