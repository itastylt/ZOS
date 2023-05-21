<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Player extends User
{
    protected $table = 'player';
    public $timestamps = false;
    use HasFactory;
    public $fillable = ['block_date', 'block_comment'];
}
