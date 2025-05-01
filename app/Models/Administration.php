<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Administration extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'administrations';

    protected $fillable = [
        'nom',
        'telephone',
        'email',
        'identifiant',
    ];

    protected $hidden = [
        'identifiant',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAuthPassword()
    {
        return $this->identifiant;
    }
}