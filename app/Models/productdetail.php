<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class productdetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'productId',
        'merek',
        'visit_id',
        'jenis_server',
        'SN',
        'ukuran',
        'psu',
        'railkit',
        'datacenter',
    ];
}
