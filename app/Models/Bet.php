<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bet extends Model
{
	protected $table = 'bet';
	public $timestamps = false;
    use HasFactory;
	    protected $fillable = ['placed_sum', 'winning_sum', 'fk_Teamid', 'fk_Playerid'];
}
