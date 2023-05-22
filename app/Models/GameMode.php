<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameMode extends Model
{
	protected $table = 'game_mode';
	public $timestamps = false;
    use HasFactory;
	    public $fillable = ['name', 'team_size', 'fk_Gameid'];
}
