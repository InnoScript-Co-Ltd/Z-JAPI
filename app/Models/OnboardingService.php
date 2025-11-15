<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class OnboardingService extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'customer_id', 'category_id', 'category_service_id', 'employer_id', 'customer_name', 'category', 'service', 'fees', 'deposit', 'balance', 'employer_type', 'employer_name', 'remark', 'status',
    ];
}
