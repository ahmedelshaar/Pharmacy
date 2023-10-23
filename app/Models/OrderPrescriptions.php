<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPrescriptions extends Model
{
    use HasFactory;
    protected $fillable = ['order_id','image'];
    protected function order(){
        return $this->belongsTo(Order::class);
    }
}
