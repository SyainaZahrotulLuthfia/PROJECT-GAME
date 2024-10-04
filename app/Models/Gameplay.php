<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Gameplay extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'character_id', 'level_id', 'score'
    ];


    public function character(): BelongsTo
    {
        return $this->belongsTo(Character::class);
    }

    public function level() : BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
