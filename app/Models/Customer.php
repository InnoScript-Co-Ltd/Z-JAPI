<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Customer extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name', 'photo', 'nrc', 'nrc_front', 'nrc_back', 'passport', 'passport_photo', 'dob', 'phone', 'email', 'content_by', 'social_app', 'socail_link_qrcode', 'remark', 'status', 'year_of_insurance', 'fees', 'deposit_amount', 'balance', 'pink_card', 'employer', 'employer_type', 'employer_photo', 'employer_household_photo', 'employer_company_data',
    ];

    protected function casts(): array
    {
        return [
            'dob' => 'date',
            'fees' => 'float',
            'deposit_amount' => 'float',
            'balance' => 'float',
        ];
    }
}
