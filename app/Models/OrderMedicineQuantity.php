<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderMedicineQuantity extends Model
{
    use HasFactory;

    protected $table = 'order_medicine_quantity';
    protected $fillable = [
        'order_id',
        'medicine_id',
        'quantity',
        'price'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }


}
