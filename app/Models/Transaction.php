<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
	protected $table = 'transaction';
	public $timestamps = false;
    use HasFactory;
	    public $fillable = ['change_value', 'comment', 'time', 'fk_Playerid'];
}
