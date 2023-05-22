<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matches extends Model
{
    protected $table = 'matches';
	public $timestamps = false;
    use HasFactory;
	    public $fillable = ['result', 'end_time', 'start_time', 'fk_Teamid', 'fk_Teamid1', 'fk_Matchesid', 'fk_Teamid2', 'fk_TOURNAMENTid'];
}
