<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasFactory, HasRoles,Notifiable;
    protected $guard = 'admin';
    public static $rules = [
        'email' => 'required|email|unique:admins',
        'password' => 'required|min:6',
    ];
    /**
     * @var array|bool|mixed|string|null
     */
    protected $fillable = [
        'email',
        'password',
        'name',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    // add validations
    protected $table = 'admins';

    // auto assign as admin
    public static function boot()
    {
        parent::boot();
        static::created(function ($admin) {
            $admin->assignRole('admin');
        });
    }
}
