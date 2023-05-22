<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TournamentPlayer extends Model
{
    protected $table = 'participates_in';
    protected $primaryKey = ['fk_Playerid', 'fk_Tournamentid'];
    use HasFactory;

    public $incrementing = false;
    public $timestamps = false;
    public function tournament()
    {
        return $this->belongsTo(Tournament::class, 'fk_Tournamentid');
    }

    public function player()
    {
        return $this->belongsTo(Player::class, 'fk_Playerid');
    }

}
