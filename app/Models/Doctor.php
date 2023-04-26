<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Doctor extends Authenticatable
{
    use HasFactory, HasRoles;
    public string $guard_name = 'web';
    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'national_id',
        'pharmacy_id',
        'is_banned'
    ];

    protected $hidden = [
        'password',
    ];


    public function scopeBanned($query)
    {
        return $query->where('is_banned', true);
    }

    public function scopeNotBanned($query)
    {
        return $query->where('is_banned', false);
    }

    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class);
    }

}
