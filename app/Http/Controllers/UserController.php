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

        //$mergedData = DB::table('user')
        //->join('player', 'user.id', '=', 'player.id')
        //->select('user.*', 'player.*')
        //->get();
        $mergedPlayers = User::join('player', 'user.id', '=', 'player.id')
        ->select('user.*', 'player.block_date', 'player.block_comment')
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
        // Retrieve the custom value from the query string
        $customValue = $request->query('custom');

        // Find the user by the given ID
        $user = User::find($userId);

        // Check if the custom value is "player"
        if ($user && $customValue === 'player') {
            // Update the user's role or perform any other necessary actions
            $user->role = $customValue;
            $user->save();

            // Redirect to a desired page or return a response
            return redirect()->back()->with('success', 'User role updated successfully.');
        }

        // Invalid custom value or user not found, handle the error
        print_r($userId);
        die();
        return redirect()->back()->with('error', 'Invalid custom value or user not found.');
    }
}
