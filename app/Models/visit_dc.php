<?php

namespace App\Models;

use DarthSoup\WhmcsApi\Api\Products;
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
        'productId',
        'lead_ktp',
        'success',
        'lead_signature',
        'company_name',
        'reason',
        'data_center',
        'Date',
        'teams',
        'webcam',
        'file_surat',
        'server_maintenance'
    ];


    public function users(){
        return $this->belongsTo(User::class, "id_user");
    }

    public function surat(){
        return $this->hasMany(surat::class, "uuid_visitdc");
    }
}
