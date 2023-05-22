<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Player;
use App\Models\Organizer;
use Illuminate\Support\Arr;
class UserController extends Controller
{
    public function logOff(Request $request) {
        $request->session()->flush();
        return redirect('/');
    }
    public function renderHomePage(Request $request) {
        $mostPopularGames = app(GameController::class)->viewMPGList();
        $logged_in = $request->session()->get('logged_in');
        if(!$logged_in) {
            $logged_in = false;
        }
        return view('HomePage', compact(['mostPopularGames', 'logged_in']));
    }
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

    public function renderRegistration(Request $request) {
        return view('RegistrationPage');
    }
    public function renderLoginPage(Request $request) {
        return view('LoginPage');
    }
    
    private function loginUser(Request $request,User $user) {
        $request->session()->put('logged_in', true);
        $request->session()->put('is_organisator', $user->isOrganizer());
        $request->session()->put('is_administrator', $user->isAdministrator());
        $request->session()->put('id', $user['id']);
        $this->renderHomePage($request);
    }

    public function validateForm(Request $request) {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('username', $request->input('username'))->where('password', $request->input('password'))->first();

        if($user) {
            $this->loginUser($request, $user);
            return redirect('/');
        }
    }
  
    public function validateForm1(Request $request) {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'email' => 'required',
            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $fileName = time() . '.' . $request->image_url->extension();
        $request->image_url->storeAs('public/images', $fileName);
        $existsName = User::where('username', $request->input('username'))->first();
        $existsEmail = User::where('email', $request->input('email'))->first();
        $exists = $existsName || $existsEmail ? 1 : 0;
        if(!$exists) {
            $user = new User;

            $user->username = $request->input('username');
            $user->password = $request->input('password');
            $user->email = $request->input('email');
            $user->registration_date = date("Y/m/d");
            $user->image_url = $fileName;
            $user->save();
            $player = new Player;
            $player->id = $user['id'];
            $player->save();
            return redirect('/login')->with('completed', 'Sėkmingai prisiregistravote!'); 
        } else {
            return view('RegistrationPage');
        }
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
