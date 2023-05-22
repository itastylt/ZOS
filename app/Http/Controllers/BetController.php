<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Bet;
use App\Models\Transaction;

class BetController extends Controller
{
    public function openBetPage(Request $request, int $id) {
        $team = Team::find($id);
        $request->session()->put('team'.$id, $team->coefficient);

        return view("BetPage", compact("team"));
    }

    private function validateCoefficient(Request $request, Team $team) {
        if($request->session()->get('team'.$team->id) != $team->coefficient ) {

        }
        return false;
    }

    public function validatePayment(Transaction $transaction,int $price) {
        return $transaction->comment = "Confirmed ". $price." e transaction from PaySera";
    }

    public function checkConfirm(Request $request) {
        $bet = new Bet;
        $bet->placed_sum = $request->input('placed_sum');
        $bet->winning_sum = $request->input('winning_sum');
        $bet->fk_Teamid = $request->input('team');
        $bet->fk_Playerid = $request->session()->get('id');
        $bet->save();
        $transaction = new Transaction;
        $transaction->change_value = -$request->input('placed_sum');
        $transaction->comment = "Sent ".$request->input('placed_sum')." e transaction to PaySera";
        $transaction->time = date("Y/m/d");
        $transaction->fk_PlayerId = $request->session()->get('id');
        $transaction->save();
        $this->validatePayment($transaction, $request->input('placed_sum'));
        return redirect('/');
    }

    public function betOnTeam(Request $request) {
        $team = Team::find($request->input("id"));
        if($this->validateCoefficient($request, $team)) {
            $errors = ["Koefficientas pasikeitė"];
            return view("BetPage", compact("errors", "team"));
        } else {
            $bet = new Bet;
            $bet->placed_sum = $request->input('bet');
            $bet->winning_sum = $bet->placed_sum + $bet->placed_sum * $team->coefficient;
            $bet->fk_Teamid = $team->id;
            $bet->fk_Playerid = $request->session()->get('id');
            return view("BetConfirmPage", compact("bet"));
        }

    }
}
