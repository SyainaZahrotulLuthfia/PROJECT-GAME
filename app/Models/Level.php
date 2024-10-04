<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Level extends Model
{
    use HasFactory;
    protected $fillable = [
        'level_name', 'number_of_enemies', 'heal_point', 'times'
    ];


    public function gameplays(): HasMany
    {
        return $this->hasMany(Gameplay::class);
    }
}
