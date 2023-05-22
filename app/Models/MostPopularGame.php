<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MostPopularGame extends Model
{
    protected $table = 'most_popular_game';
    protected $primaryKey = 'id';
    public $timestamps = false;
    use HasFactory;
    protected $fillable = ['name', 'quantity', 'update_date'];
}
