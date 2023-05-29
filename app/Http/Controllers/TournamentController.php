<?php

namespace App\Http\Controllers;

use App\Http\Controllers\TournamentBracketController;
use App\Models\Matches;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Tournament;
use Illuminate\Support\Facades\DB;
use App\Models\Game;
use App\Models\Team;
use App\Models\GameMode;
use App\Models\Transaction;
use App\Models\Player;
use App\Models\TournamentPlayer;
use mysql_xdevapi\Result;
use Carbon\Carbon;

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
            $tournament->status = 'sent_to_admin';
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
        $games = Game::all();;
        return view('TournamentCreationPage', compact('is_organisator', 'games'));
    }
    private function checkTournament(int $playerCount, Tournament $tournament) {
        if($playerCount == $tournament->player_count && $tournament->tournament_start == date("Y/m/d")) {
               return true;
        }
        return false;
    }
    public function initiateTournament(Request $request, int $id) {
        $tournament = Tournament::find($id);
        if($tournament) {
            if($request->session()->get('id') == $tournament->fk_Organizerid) {
                $playerCount = DB::table('tournament')->selectRaw('COUNT(participates_in.fk_Playerid) as playercount')->leftJoin('participates_in', 'participates_in.fk_Tournamentid', '=', 'tournament.id')->get()[0]->playercount;
                if($this->checkTournament($playerCount,$tournament)){
                    $tournament->status="ongoing";
                    $request->session()->put('success', "Turnyras sėkmingai pradėtas");
                    return redirect("TournamentPage/".$id);
                } else {
                    $errors = array();
                    array_push($errors, "Negalima pradėti turnyro!");
                    return redirect("TournamentPage/".$id, compact("errors"));
                }
            }
        }
    }

    function openTournamentPage($id){
        $tournamentBracketController = new TournamentBracketController();
        $teams = $tournamentBracketController->updateBettingOdds($id);
        $tournament = Tournament::findOrFail($id);
        $player = Player::findOrFail(\request()->session()->get('id'));
        $isRegistered = TournamentPlayer::where('fk_Playerid', $player->id)
                                                ->where('fk_Tournamentid', $tournament->id)
                                                ->exists();
        if (!$tournament){
            return redirect()->back();
        }
        $tournamentId=$tournament->id;
        $tournamentExtended = DB::table('tournament')
            ->select('tournament.*', 'game_mode.name as game_mode', 'game.name as game_name')
            ->selectRaw('COUNT(participates_in.fk_Playerid) as playercount')
            ->leftJoin('participates_in', 'participates_in.fk_Tournamentid', '=', 'tournament.id')
            ->leftJoin('game_mode', 'game_mode.id', '=', 'tournament.fk_Gamemodeid')
            ->leftJoin('game', 'game.id', '=', 'game_mode.fk_Gameid')
            ->where('tournament.id', $tournament->id)
            ->groupBy('tournament.id')
            ->get();
        $root = Matches::where(function ($query) use ($tournamentId) {
            $query->whereHas('team1', function ($team1Query) use ($tournamentId) {
                $team1Query->where('fk_Tournamentid', $tournamentId);
            })
                ->orWhereHas('team2', function ($team2Query) use ($tournamentId) {
                    $team2Query->where('fk_Tournamentid', $tournamentId);
                });
        })
            ->first();
        if ($root){
            while ($root->higher){
                $root=$root->higher;
            }
        }
        //open column
        $cols = array_fill(0, $tournament->max_team_count, '');
        if ($tournament->player_count == $tournamentExtended[0]->playercount){
            $numbers = [];
            $result = [];
            $this->generateTable($root, 'mid', $tournament->max_team_count, $result);
            for ($i = 0; $i < log($tournament->max_team_count, 2); $i++) {
                $j = 2 ** $i;
                $stage_matches = array_filter($result, function ($item) use ($j) {
                    return $item[1] == $j;
                });
                for ($k = 0; $k < count($cols); $k++) {
                    if ($k % $j == 0) {
                        $item = array_shift($stage_matches);
                        if($cols[$k] != NULL && $item[0] != NULL)
                        {
                            $cols[$k] = $cols[$k] . '<td rowspan="' . $j . '">' . '<p>' . $item[0] . '</p>' . '</td>';
                        }
                    }
                }
            }
            //add winner and close columns
            if ($root && $root->winner) {
                $cols[0] = $cols[0] . '<td rowspan="' . $tournament->max_team_count . '">' . '<p>' . $root->winner->name . '</p>' . '</td>';
            } else {
                $cols[0] = $cols[0] . '<td rowspan="' . $tournament->max_team_count . '">' . '<p>' . 'TBA' . '</p>' . '</td>';
            }
            $cols = array_map(function ($element) {
                return '<tr>' . $element . '</tr>';
            }, $cols);
        }
            return view('TournamentPage', compact('tournamentExtended', 'teams', 'isRegistered', 'cols'));
    }
    function generateTable($match, $leftOrRight, $teamCount, &$result){
        if ($match){
            $this->generateTable($match->lower1, 'left', $teamCount, $result);
            $this->generateTable($match->lower2, 'right', $teamCount, $result);
            $i = 2**(log($teamCount, 2)-$match->stage)/2;
            array_push($result, [$match->team1?$match->team1->name:'TBA', $i]);
            array_push($result, [$match->team2?$match->team2->name:'TBA', $i]);
            return $i;
        }
    }
    function joinTournament($id){
        $tournament = Tournament::findOrFail($id);
        if (!$tournament){
            return redirect()->back();
        }
        $transaction = $this->createTransaction(\request(), $tournament);
        $status = $this->validatePayment($transaction, $tournament->join_price);
        if ($status!=-1){
            $player = Player::findOrFail(\request()->session()->get('id'));
            $tournament = Tournament::findOrFail($id);
            $this->addPlayerToTournament($player, $tournament);
        }
        return $this->openTournamentPage($id);
    }

    function createTransaction(Request $request, $tournament){
        $transaction = new Transaction;
        $transaction->change_value = -$tournament->join_price;
        $transaction->comment = "Sent ".$tournament->join_price." e transaction to PaySera";
        $transaction->time = date("Y/m/d");
        $transaction->fk_PlayerId = $request->session()->get('id');
        $transaction->save();
        return $transaction;
    }

    function addPlayerToTournament($player, $tournament){
        $tp = new TournamentPlayer;
        $tp->fk_Playerid = $player->id;
        $tp->fk_Tournamentid = $tournament->id;
        $tp->save();
    }

    function confirmTournament($id){
        $tournament = Tournament::findOrFail($id);
        if (!$tournament){
            return redirect()->back();
        }
        $tournament->status = 'confirmed';
        $tournament->save();
        return $this->openTournamentsPage(\request());
    }
    public function synchronize($id)
    {
        $tournament = Tournament::findOrFail($id);
        if (!$tournament) {
            return;
        }

        $teams = Team::where('fk_Tournamentid', $tournament->id)->get();

        $matches = Matches::whereNull('end_time')
            ->where(function ($query) use ($teams) {
                $query->whereIn('fk_Teamid1', $teams->pluck('id'))
                    ->orWhereIn('fk_Teamid2', $teams->pluck('id'));
            })
            ->orderBy('stage')
            ->get();

        if ($matches->isEmpty()) {
            return;
        }

        $firstMatch = $matches->first();
        $firstMatch->result = rand(1, 2);
        $firstMatch->end_time = Carbon::now();
        $firstMatch->save();

        $matchController = new MatchController();
        $matchController->updateOutcome($firstMatch->id, $firstMatch->result);

        $winningTeamId = null;
        if ($firstMatch->result == 1) {
            $winningTeamId = $firstMatch->fk_Teamid1;
        } else {
            $winningTeamId = $firstMatch->fk_Teamid2;
        }

        $this->updateBracket($tournament->id, $winningTeamId, $firstMatch->stage);

        return redirect()->back()->with('success', 'Sinchronizacija sėkminga.');
    }

    public function updateBracket($tournamentId, $winningTeamId, $stage)
    {
        $teams = Team::where('fk_Tournamentid', $tournamentId)->get();
        $matches = Matches::whereIn('fk_Teamid1', $teams->pluck('id'))
            ->orWhereIn('fk_Teamid2', $teams->pluck('id'))
            ->get();

        $nextStage = $stage + 1;
        $matchFound = false;

        foreach ($matches as $match) {
            if ($match->stage == $nextStage && $match->fk_Teamid2 === null) {
                $match->fk_Teamid2 = $winningTeamId;
                $match->save();
                $matchFound = true;
            }
        }

        if (!$matchFound) {
            $newMatch = new Matches();
            $newMatch->fk_Teamid1 = $winningTeamId;
            $newMatch->fk_Teamid2 = null;
            $newMatch->stage = $nextStage;
            $newMatch->save();
        }
    }

}
