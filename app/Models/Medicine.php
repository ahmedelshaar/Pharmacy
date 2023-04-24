<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'cost',
    ];

    public function getPriceAttribute($value)
    {
        return $value / 100;
    }

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = $value * 100;
    }

    public function getCostAttribute($value)
    {
        return $value / 100;
    }

    public function setCostAttribute($value)
    {
        $this->attributes['cost'] = $value * 100;
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_medicine', 'medicine_id', 'order_id');
    }
}
