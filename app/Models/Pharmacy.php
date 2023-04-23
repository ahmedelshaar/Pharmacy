<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use illuminate\Database\Eloquent\SoftDeletes;

class Pharmacy extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'avatar',
        'priority',
        'area_id',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }



}