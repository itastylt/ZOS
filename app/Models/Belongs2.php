<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Belongs2 extends Model
{
    use HasFactory;

    protected $table = 'belongs2';
    public $timestamps = false;

    protected $fillable = ['fk_Teamid', 'fk_Playerid'];
}
