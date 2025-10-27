<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class VisaService extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name', 'passport', 'passport_image',  'service_type', 'visa_type', 'visa_entry_date', 'visa_expiry_date', 'appointment_date', 'status', 'new_visa_expired_date',
    ];

    protected $hidden = [];

    protected function casts(): array
    {
        return [
            'visa_expiry_date' => 'date',
            'visa_entry_date' => 'date',
            'appointment_date' => 'date',
            'new_visa_expired_date' => 'date',
        ];
    }
}
