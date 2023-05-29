<?php

namespace App\Http\Controllers;

use App\Models\Elo;
use App\Models\Belongs2;
use App\Models\Matches;
use App\Models\Player;
use App\Models\Team;
use App\Models\TeamPlayer;
use App\Models\Tournament;
use App\Models\TournamentPlayer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TournamentBracketController extends Controller
{
    const DEFAULT_ELO = 500;
    function startGeneration(){
        //generate tournament bracket
        $today = Carbon::today();
        $tournaments = Tournament::where('tournament_start', $today)->get();
        foreach ($tournaments as $tournament){
            if ($this->isAlreadyGenerated($tournament->id) || $tournament->status!='confirmed'){
                continue;
            }
            $players = $tournament->players;
            $playerCount = count($players);
            if ($playerCount < $tournament->player_count) {
                $this->stopTournament($tournament);
            } else{
                $gameMode = $tournament->gameMode;
                $game = $gameMode->game;
                $players = $this->sortPlayers($players, $game->id);
                $pockets = $this->formPlayerPockets($tournament, $players->toArray());
                $teams = $this->generateTeams($tournament, $gameMode->team_size, $pockets);
                $teamArray = $teams->toArray();
                $root = $this->createBracketTree($teamArray);
                $nodes = $this->makeMatches($root);
                $stage = 0;
                while($this->checkTeamsLeft($teamArray)>0){
                    $stage+=1;
                    $nextNodes = [];
                    for ($i = 0; $i < count($nodes); $i++) {
                        $leaf = $nodes[$i];
                        if ($this->checkLeafSide($leaf)=='left'){
                            $leaf = $this->createLeftLeaf($leaf);
                        } elseif ($this->checkLeafSide($leaf)=='right'){
                            $leaf = $this->createRightLeaf($leaf);
                        }
                        $leaf->save();
                        array_push($nextNodes, $leaf);

                    }
                    $teams = $this->takeTeams($teamArray, count($nextNodes));
                    $mc = [];
                    for ($j = 0; $j < count($nextNodes); $j++) {
                        $match = $this->selectHighesValueLeaf($tournament->id, $nextNodes[0]['stage']);
                        $match = $this->insertLowestValueTeam($match, $teams);
                        array_push($mc, $match);
                    }
                    if ($this->checkTeamsLeft($teamArray)==0){
                        break;
                    }
                    $nodes = $this->makeMatches($nextNodes);
                }
                $tournamentId = $tournament->id;
                $matches = Matches::where('stage', '!=', $stage)
                    ->where(function ($query) use ($tournamentId) {
                        $query->whereHas('team1', function ($team1Query) use ($tournamentId) {
                            $team1Query->where('fk_Tournamentid', $tournamentId);
                        })
                            ->orWhereHas('team2', function ($team2Query) use ($tournamentId) {
                                $team2Query->where('fk_Tournamentid', $tournamentId);
                            });
                    })
                    ->get();
                foreach ($matches as $match) {
                    $match->fk_Teamid1 = null;
                    $match->fk_Teamid2 = null;
                    $match->save();
                }
            }
        }
        return redirect('/');
    }
    function isAlreadyGenerated($tournamentId){
        $matches = Matches::where(function ($query) use ($tournamentId) {
                $query->whereHas('team1', function ($team1Query) use ($tournamentId) {
                    $team1Query->where('fk_Tournamentid', $tournamentId);
                })
                    ->orWhereHas('team2', function ($team2Query) use ($tournamentId) {
                        $team2Query->where('fk_Tournamentid', $tournamentId);
                    });
            })
            ->get();
        return !$matches->isEmpty();
    }
    function insertLowestValueTeam($match, &$teams){
        $team = array_pop($teams);
        if ($this->checkLeafSide($match)=='left'){
            $match->fk_Teamid2 = $team['id'];

        } elseif ($this->checkLeafSide($match)=='right'){
            $match->fk_Teamid1 = $team['id'];
        }
        $match->save();
        return $match;
    }
    function selectHighesValueLeaf($tournamentId, $stage){
        $match = Matches::where('stage', $stage)
            ->where(function ($query) use ($tournamentId) {
                $query->where(function ($subquery) use ($tournamentId) {
                    $subquery->whereNull('fk_Teamid1')
                        ->whereHas('team2', function ($team2Query) use ($tournamentId) {
                            $team2Query->where('fk_Tournamentid', $tournamentId);
                        });
                })->orWhere(function ($subquery) use ($tournamentId) {
                    $subquery->whereNull('fk_Teamid2')
                        ->whereHas('team1', function ($team1Query) use ($tournamentId) {
                            $team1Query->where('fk_Tournamentid', $tournamentId);
                        });
                });
            })
            ->first();
        return $match;
    }
    function takeTeams(&$teams, $count){
        $t = [];
        for ($i = 0; $i < $count; $i++) {
            array_push($t, array_shift($teams));
        }
        return $t;
    }
    function createLeftLeaf($leaf){
        $leaf->fk_Teamid1 = $leaf->higher->fk_Teamid1;
        return $leaf;
    }
    function createRightLeaf($leaf){
        $leaf->fk_Teamid2 = $leaf->higher->fk_Teamid2;
        return $leaf;
    }
    function checkLeafSide($leaf){
        if ($leaf->id == $leaf->higher->fk_lower1) return 'left';
        elseif ($leaf->id == $leaf->higher->fk_lower2) return 'right';
    }
    function makeMatches($nodes){
        $matches = [];
        for ($i = 0; $i < count($nodes); $i++) {
            $node = Matches::findOrFail($nodes[$i]['id']);
            $left = new Matches();
            $left->fk_Matchesid = $nodes[$i]['id'];
            $left->stage = $nodes[$i]['stage']+1;
            $left->save();
            $node->fk_lower1 = $left->id;
            $right = new Matches();
            $right->fk_Matchesid = $nodes[$i]['id'];
            $right->stage = $nodes[$i]['stage']+1;
            $right->save();
            $node->fk_lower2 = $right->id;
            $node->save();
            array_push($matches, $left, $right);
        }
        return $matches;
    }
    function checkTeamsLeft($teamArray){
        return count($teamArray);
    }
    function stopTournament($tournament){
        $tournament->status = 'unconfirmed';
        $tournament->save();
    }
    function sortPlayers($players, $gameid){
        foreach ($players as $player){
            $elo = $player->elos()->where('fk_Gameid', $gameid)->first();
            if (!$elo){
                $elo = new Elo();
                $elo->points = self::DEFAULT_ELO;
                $elo->fk_Playerid = $player->id;
                $elo->fk_Gameid = $gameid;
                $elo->save();
            }
        }
        return $players->sortByDesc(function($player) use ($gameid){
           return $player->elos()->where('fk_Gameid', $gameid)->first()->points;
        });
    }
    function formPlayerPockets($tournament, $players){
        $pocketCount = $tournament->gamemode->team_size;
        $pocketSize = $tournament->player_count/$pocketCount;
        $pockets = [];
        for ($i = 0; $i < $pocketCount; $i++) {
            $pocket = [];
            for ($j = 0; $j < $pocketSize; $j++) {
                array_push($pocket, array_shift($players));
            }
            array_push($pockets, $pocket);
        }
        return $pockets;
    }
    function generateTeams($tournament, $teamsize, $pockets){
        $this->deleteTeams($tournament);
        for ($i = 0; $i < $tournament->max_team_count; $i++) {
            $team = new Team();
            $team->coefficient = 0;
            $team->fk_Tournamentid = $tournament->id;
            $team->save();
            for ($j = 0; $j < $teamsize; $j++) {
                $randomKey = array_rand($pockets[$j]);
                $player = $pockets[$j][$randomKey];
                unset($pockets[$j][$randomKey]);
                if ($j == 0){
                    $team->name = User::find($player['id'])->username.' team';
                    $team->save();
                }
                DB::table('belongs2')->insert([
                    'fk_Teamid' => $team->id,
                    'fk_Playerid' => $player['id']
                ]);
            }
        }
        $teams = Team::select('team.*')
            ->join('belongs2', 'team.id', '=', 'belongs2.fk_Teamid')
            ->join('elo', 'belongs2.fk_Playerid', '=', 'elo.fk_Playerid')
            ->where('team.fk_Tournamentid', $tournament->id)
            ->groupBy('team.id')
            ->orderBy(DB::raw('AVG(elo.points)'), 'desc')
            ->get();
        return $teams;
//        Team::where('fk_Tournamentid', $tournament->id)->get();
    }
    function deleteTeams($tournament): void
    {
        $teams = Team::where('fk_Tournamentid', $tournament->id)->get();
        foreach ($teams as $team){
            TeamPlayer::where('fk_Teamid', $team->id)->delete();
            // Disable foreign key constraints
            DB::statement('SET FOREIGN_KEY_CHECKS=0');

// Perform deletion operations here
            Matches::where(function ($query) use ($team) {
                $query->where('fk_Teamid', $team->id)
                    ->orWhere('fk_Teamid1', $team->id)
                    ->orWhere('fk_Teamid2', $team->id)
                    ->orWhere('stage', 1)->orWhere('stage', 2)->orWhere('stage', 3);
            })->delete();
// Enable foreign key constraints
            DB::statement('SET FOREIGN_KEY_CHECKS=1');

        }
        Team::where('fk_Tournamentid', $tournament->id)->delete();
    }
    function createBracketTree(&$teams){
        $t = $this->takeTwoTopTeams($teams);
        $left = $t[0];
        $right = $t[1];
        $match = new Matches();
        $root = $this->insertIntoBracketTree($match, $left, $right);
        return [$root];
    }
    function takeTwoTopTeams(&$teams){
        $left = array_shift($teams);
        $right = array_shift($teams);
        return [$left, $right];
    }
    function insertIntoBracketTree($node, $left, $right){
        $node->fk_Teamid1 = $left['id'];
        $node->fk_Teamid2 = $right['id'];
        $node->stage = 0;
        $node->save();
        return $node;
    }

    function updateBettingOdds($id) {
        $teams = Team::where('fk_Tournamentid', $id)->get();

        foreach($teams as $team) {
            $player_ids = Belongs2::where('fk_Teamid', $team->id)->pluck('fk_Playerid');
            $team->elo_sum = Elo::whereIn('fk_Playerid', $player_ids)->sum('points');
        }

        $matches = Matches::where('end_time', NULL)
                        ->whereIn('fk_Teamid1', $teams->pluck('id'))
                        ->whereIn('fk_Teamid2', $teams->pluck('id'))
                        ->get();

        $matchTeams = collect();

        foreach ($matches as $match) {
            $team1 = $teams->where('id', $match->fk_Teamid1)->first();
            $team2 = $teams->where('id', $match->fk_Teamid2)->first();

            $matchTeams->push($team1);
            $matchTeams->push($team2);
        }

        $uniqueTeams = $matchTeams->unique();

        $teams = $uniqueTeams->sortBy(function($team) use ($matchTeams) {
            return $matchTeams->search($team);
        });

        foreach ($teams as $team) {
            $team->coefficient = 0;
        }

        foreach ($matches as $match) {
            $team1 = $teams->where('id', $match->fk_Teamid1)->first();
            $team2 = $teams->where('id', $match->fk_Teamid2)->first();

            $team1->win_percentage = 1 / (1 + pow(10, ($team2->elo_sum - $team1->elo_sum) / 400));
            $team1->coefficient += 1 / $team1->win_percentage;

            $team2->win_percentage = 1 / (1 + pow(10, ($team1->elo_sum - $team2->elo_sum) / 400));
            $team2->coefficient += 1 / $team2->win_percentage;
        }

        foreach ($teams as $team) {
            Team::where('id', $team->id)->update(['coefficient' => $team->coefficient]);
        }

        return $matchTeams;
    }
}
