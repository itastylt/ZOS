<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matches extends Model
{
    protected $table = 'matches';
	public $timestamps = false;
    protected $primaryKey = 'id';
    use HasFactory;
	    public $fillable = ['result', 'end_time', 'start_time', 'fk_Teamid', 'fk_Teamid1', 'fk_Matchesid', 'fk_Teamid2', 'fk_TOURNAMENTid'];

    public function winner()
    {
        return $this->belongsTo(Team::class, 'fk_Teamid', 'id');
    }

    public function team1()
    {
        return $this->belongsTo(Team::class, 'fk_Teamid1', 'id');
    }

    public function team2()
    {
        return $this->belongsTo(Team::class, 'fk_Teamid2', 'id');
    }
    public function lower1()
    {
        return $this->belongsTo(Matches::class, 'fk_lower1', 'id');
    }

    public function lower2()
    {
        return $this->belongsTo(Matches::class, 'fk_lower2', 'id');
    }
    public function higher(){
        return $this->belongsTo(Matches::class, 'fk_Matchesid', 'id');
    }
}
