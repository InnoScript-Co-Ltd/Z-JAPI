<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Activity extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'admin_id', 'name', 'action', 'data',
    ];

    protected $hidden = [];

    protected function casts(): array
    {
        return [
            'data' => 'json',
        ];
    }
}
