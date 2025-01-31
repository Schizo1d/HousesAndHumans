<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id'];

    // Связь с пользователем
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
