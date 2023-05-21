<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Player;

class UserController extends Controller
{
    //
    public function renderUsersPage(){
        $users = User::all();
        $players = Player::all();

        $mergedData = DB::table('user')
        ->join('player', 'user.id', '=', 'player.id')
        ->select('user.*', 'player.*')
        ->get();

        //print_r($mergedData);
        //die();
        return view('UsersPage', compact('mergedData'));
    }
    public function openUserRolePage(User $user){
        return view('UserRolePage');
    }
    
}
