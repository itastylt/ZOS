<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Tournament extends Model
{
    use HasFactory;
    protected $table = 'Tournament';
    public $timestamps = false;
    protected $fillable = [
        'max_team_count',
        'player_count',
        'prize_pool',
        'join_price',
        'registration-start',
        'registration-end',
        'status'
    ];
    protected $primaryKey = 'id';

    public function players(){
        return $this->belongsToMany(Player::class, 'participates_in');
    }
}
