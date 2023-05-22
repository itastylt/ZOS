<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Player;
use App\Models\Organizer;

class UserController extends Controller
{
    //
    public function renderUsersPage(){
        $users = User::all();
        $players = Player::all();

        //$mergedData = DB::table('user')
        //->join('player', 'user.id', '=', 'player.id')
        //->select('user.*', 'player.*')
        //->get();
        $mergedPlayers = User::join('player', 'user.id', '=', 'player.id')
        ->leftJoin('organizer', 'user.id', '=', 'organizer.id')
        ->select('user.*', 'player.block_date', 'player.block_comment', 'organizer.id as organizer_id')
        ->get();

        //print_r($mergedData);
        //die();
        return view('UsersPage', compact('mergedPlayers'));
    }
    public function openUserRolePage(User $user){
        return view('UserRolePage', compact('user'));
    }
    public function changeUserRole(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        $customValue = $request->query('custom');
        print_r($customValue);
        if ($customValue === 'player') {
            $player = $user->player;
            $organizer = $player->organizer;
            if ($organizer) {
                $organizer->delete();
            }
        } elseif ($customValue === 'organizer') {
            $player = $user->player;
            if (!$player->organizer) {
                $organizer = new Organizer();
                $organizer->id = $user->id;
                $organizer->save();
            }
        } else {
            return redirect()->back()->with('error', 'Invalid custom value');
        }

        return redirect('/UsersPage')->with('success', 'User role changed successfully');
    }
}
