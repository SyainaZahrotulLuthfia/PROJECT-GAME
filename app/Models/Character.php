<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Character extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'power', 'image'
    ];

    public function gameplays() : HasMany
    {
        return $this->hasMany(Gameplay::class);
    }
}
