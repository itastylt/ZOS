<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamPlayer extends Model
{
    protected $table = 'belongs2';
    protected $primaryKey = ['fk_Teamid', 'fk_Playerid'];
    public $timestamps = false;
    use HasFactory;

    public function team()
    {
        return $this->belongsTo(Team::class, 'fk_Teamid', 'id');
    }

    public function player()
    {
        return $this->belongsTo(Player::class, 'fk_Playerid', 'id');
    }
}
