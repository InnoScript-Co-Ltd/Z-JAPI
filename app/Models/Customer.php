<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class Customer extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'reference_id', 'name', 'photo', 'household_photo', 'nrc', 'nrc_front', 'nrc_back', 'passport', 'passport_photo', 'dob', 'phone', 'email', 'contact_by', 'social_app', 'social_link_qrcode', 'remark', 'status',
    ];

    protected function casts(): array
    {
        return [
            'dob' => 'date',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->reference_id = self::generateReferenceId();
        });
    }

    public static function generateReferenceId()
    {
        do {
            $id = 'Z&J'.date('Ymd').strtoupper(Str::random(8));
        } while (self::where('reference_id', $id)->exists());

        return $id;
    }
}
