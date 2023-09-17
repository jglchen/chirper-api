<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFollow extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'followed_id',
    ];

    public function follower(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
