<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_insured',
        'prescription',
        'status',
        'pharmacy_id',
        'doctor_id',
        'user_id',
        'address_id',
    ];

    protected $casts = [
        'is_insured' => 'boolean',
        'prescription' => 'json',
    ];

    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(UserAddress::class);
    }

    public function medicines()
    {
        return $this->hasMany(OrderMedicine::class);
    }

    public function revenue()
    {
        return $this->medicines->sum('price');
    }

    public function cost()
    {
        return $this->medicines->sum('cost');
    }

    public function netIncome()
    {
        return $this->totalPrice() - $this->totalCost();
    }

}
