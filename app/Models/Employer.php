<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class Employer extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'code', 'full_name', 'national_card_number', 'household_photo', 'national_card_photo', 'employer_type', 'company_documents',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->code = self::generateReferenceId();
        });
    }

    public static function generateReferenceId()
    {
        do {
            $id = 'Z&J_EMPLOYER'.date('Ymd').strtoupper(Str::random(8));
        } while (self::where('code', $id)->exists());

        return $id;
    }
}
