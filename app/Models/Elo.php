<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Elo extends Model
{
    protected $table = 'elo';
    protected $primaryKey = 'id';
    public $timestamps = false;
    use HasFactory;

    public function game()
    {
        return $this->belongsTo(Game::class, 'fk_Gameid');
    }
}
