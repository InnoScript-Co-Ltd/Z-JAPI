<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class CategoryService extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'category_id', 'name', 'description', 'fees', 'status',
    ];

    protected function casts(): array
    {
        return [
            'fees' => 'float',
        ];
    }

    public function category()
    {
        return $this->belongsTo(Categories::class);
    }
}
