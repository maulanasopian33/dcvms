<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class visit_dc extends Model
{
    use HasFactory;
    protected $primaryKey = 'UID';

    public $incrementing = false;

    protected $fillable = [
        'UID',
        'id_user',
        'lead_name',
        'lead_email',
        'lead_phone',
        'lead_nik',
        'lead_ktp',
        'lead_signature',
        'company_name',
        'reason',
        'data_center',
        'Date',
        'teams',
        'webcam'
    ];
}
