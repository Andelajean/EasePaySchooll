<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','parent_id', 'nom_complet',
    ];

    public function parent()
    {
        return $this->belongsTo(User::class);
    }
}
