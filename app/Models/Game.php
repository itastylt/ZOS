<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
	protected $table = 'game';
	public $timestamps = false;
    use HasFactory;
	    protected $fillable = ['name', 'description', 'image_url'];

    public function game_mode() {
        return $this->belongsToMany(GameMode::class, 'game_mode', 'fk_Gameid');
    }
    public function has1() {
        return $this->belongsToMany(Player::class, 'has1', 'fk_Gameid');
    }
    public function elo() {
        return $this->belongsToMany(Elo::class, 'elo','fk_Gameid');
    }
}
