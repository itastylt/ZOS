<?php

namespace App\Http\Controllers;

use App\Models\Elo;
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
                dd($teams);
            }
        }
        return redirect('/');
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
        return Team::where('fk_Tournamentid', $tournament->id)->get();
    }
    function deleteTeams($tournament){
        $teams = Team::where('fk_Tournamentid', $tournament->id)->get();
        foreach ($teams as $team){
            TeamPlayer::where('fk_Teamid', $team->id)->delete();
        }
        Team::where('fk_Tournamentid', $tournament->id)->delete();
    }
}
