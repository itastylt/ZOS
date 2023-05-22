<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use Illuminate\Support\Facades\Cache;
use App\Models\MostPopularGame;
use Carbon\Carbon;
class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $game = Game::all();
        return view('GameManagmentPage', compact('game'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('GameAddPage');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $fileName = time() . '.' . $request->image_url->extension();
        $request->image_url->storeAs('public/images', $fileName);
        
		$game = new Game;
        $game->name = $request->input('name');
        $game->description = $request->input('description');
        $game->image_url = $fileName;
        $game->save();

        return redirect('/GameManagmentPage')->with(
            'completed', 'Game has been saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $game = Game::findOrFail($id);
        return view('GameEditPage', compact('game'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
		$fileName = time() . '.' . $request->image_url->extension();
        $request->image_url->storeAs('public/images', $fileName);
		        
		$game = Game::find($id);
        $game->name = $request->input('name');
        $game->description = $request->input('description');
        $game->image_url = $fileName;
		$game->save();
        return redirect('/GameManagmentPage')->with('completed', 'Game has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $game = Game::findOrFail($id);
        $game->delete();
        return redirect('/GameManagmentPage')->with('completed', 'Game has been deleted');
    }
    
    public function viewMPGList()
    {
        $cacheKey = 'mostPopularGames';
        $cacheDuration = 1440; // Duration in minutes (1 day)
    
        $mostPopularGames = $this->checkCachedMPGList($cacheKey, $cacheDuration);
    
        return $mostPopularGames;
    }
    
    private function checkCachedMPGList($cacheKey, $cacheDuration)
    {
        $mostPopularGames = Cache::get($cacheKey);
        $cachedUpdateDate = Cache::get($cacheKey . '_update_date');
    
        // Check if the cached data exists and is up to date
        if ($this->checkListDate($cachedUpdateDate)) {
            // Cached data is up to date, return it
            return $mostPopularGames;
        }
    
        // Cached data is not up to date, update it
        return $this->updateCachedMPGList($cacheKey, $cacheDuration);
    }
    
    private function checkListDate($cachedUpdateDate)
    {
        // Check if the cached update date exists and is equal to today's date
        if ($cachedUpdateDate && Carbon::today()->eq(Carbon::parse($cachedUpdateDate)->format('Y-m-d'))) {
            // Cached data is up to date
            return true;
        }
    
        // Cached data is not up to date
        return false;
    }
    
    private function updateCachedMPGList($cacheKey, $cacheDuration)
    {
        // Retrieve the most popular games from the database
        $mostPopularGames = MostPopularGame::orderBy('quantity', 'desc')->get();
    
        // Update the cached data and update date
        Cache::put($cacheKey, $mostPopularGames, $cacheDuration);
        Cache::put($cacheKey . '_update_date', Carbon::today()->format('Y-m-d'), $cacheDuration);
    
        // Return the updated data
        return $mostPopularGames;
    }
}
