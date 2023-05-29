<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matches;
use App\Models\Team;
use App\Models\Belongs2;
use App\Models\Elo;

class MatchController extends Controller
{
    public function calculateWinChance($winner_elo_sum, $loser_elo_sum)
    {
        return 1 / (1 + pow(10, ($loser_elo_sum - $winner_elo_sum) / 400));
    }

    public function calculateWinnerElo($team_players, $win_chance)
    {
        foreach ($team_players as $player_id) {
            $elo = Elo::where('fk_Playerid', $player_id)->first();
            $elo->points += 32 * (1 - $win_chance);
            $elo->save();
        }
    }

    public function calculateLoserElo($team_players, $win_chance)
    {
        foreach ($team_players as $player_id) {
            $elo = Elo::where('fk_Playerid', $player_id)->first();
            $elo->points -= 32 * (1 - $win_chance);
            $elo->save();
        }
    }

    public function updateOutcome($id, $result)
    {
        $match = Matches::find($id);

        if (!$match) {
            return response()->json(['message' => 'Match not found'], 404);
        }

        $team1 = Team::find($match->fk_Teamid1);
        $team2 = Team::find($match->fk_Teamid2);

        $team1_players = Belongs2::where('fk_Teamid', $team1->id)->pluck('fk_Playerid')->toArray();
        $team2_players = Belongs2::where('fk_Teamid', $team2->id)->pluck('fk_Playerid')->toArray();

        $team1_elo_sum = Elo::whereIn('fk_Playerid', $team1_players)->sum('points');
        $team2_elo_sum = Elo::whereIn('fk_Playerid', $team2_players)->sum('points');

        $winner_id = $result == 1 ? $team1->id : $team2->id;
        $loser_id = $result == 1 ? $team2->id : $team1->id;
        $winner_elo_sum = $result == 1 ? $team1_elo_sum : $team2_elo_sum;
        $loser_elo_sum = $result == 1 ? $team2_elo_sum : $team1_elo_sum;

        $win_chance = $this->calculateWinChance($winner_elo_sum, $loser_elo_sum);

        if ($result == 1) {
            $this->calculateWinnerElo($team1_players, $win_chance);
            $this->calculateLoserElo($team2_players, $win_chance);
        } else {
            $this->calculateWinnerElo($team2_players, $win_chance);
            $this->calculateLoserElo($team1_players, $win_chance);
        }

        return response()->json([
            'winner_id' => $winner_id,
            'loser_id' => $loser_id,
            'team1_players' => $team1_players,
            'team2_players' => $team2_players,
            'team1_elo_sum' => $team1_elo_sum,
            'team2_elo_sum' => $team2_elo_sum,
            'win_chance' => $win_chance,
        ], 200);
    }
}
