<?php

namespace App\Models;
use App\Models\Tournament;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameMode extends Model
{
	protected $table = 'game_mode';
	public $timestamps = false;
    use HasFactory;
	    public $fillable = ['name', 'team_size', 'fk_Gameid'];

    public function game(){
        return $this->belongsTo(Game::class, 'fk_Gameid');
    }

    public function tournament(){
        return $this->belongsToMany(Tournament::class, "tournament", 'fk_Gamemodeid');
    }
}
