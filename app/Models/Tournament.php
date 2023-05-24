<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Tournament extends Model
{
    use HasFactory;
    protected $table = 'Tournament';
    public $timestamps = false;
    public $fillable = [
        'current_stage',
        'max_team_count',
        'player_count',
        'prize_pool',
        'join_price',
        'registration_start',
        'registration_end',
        'status',
        'tournament_start',
        'fk_Gamemodeid',
        'fk_Organizerid'

    ];
    protected $primaryKey = 'id';

    public function players(){
        return $this->belongsToMany(Player::class, 'participates_in', 'fk_Tournamentid', 'fk_Playerid');
    }
    public function gameMode(){
        return $this->belongsTo(GameMode::class, 'fk_Gamemodeid');
    }
}
