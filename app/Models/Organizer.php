<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Player;
class Organizer extends Model
{
    protected $table = 'organizer';
    protected $primaryKey = 'id';
    public $timestamps = false;
    use HasFactory;
    public function player()
    {
        return $this->belongsTo(Player::class, 'id');
    }
}
