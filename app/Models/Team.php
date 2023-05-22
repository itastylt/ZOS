<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'team';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $fillable = ['coefficient', 'stage', 'fk_Tournamentid'];
    use HasFactory;

    public function players()
    {
        return $this->belongsToMany(Player::class, 'belongs2', 'fk_Teamid', 'fk_Playerid');
    }
}
