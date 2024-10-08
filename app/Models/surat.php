<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class surat extends Model
{
    use HasFactory;
    protected $fillable = [
        'fullname',
        'email',
        'phone_number',
        'nik',
        'ktp',
        'address',
        'position',
        'company_name',
        'company_npwp',
        'company_address',
        'company_phone',
        'no_surat',
        'data_center',
        'no_rack',
        'switch',
        'port',
        'service',
        'waktu_layanan',
        'os',
        'arsitektur',
        'control_panel',
        'servers',
        'support_signature',
        'support_name',
        'support_email',
        'client_signature',
        'dokumentasi',
        'productId',
        'uuid_visitdc'
    ];

    public function product(){
        return $this->belongsTo(product::class, "productId");
    }
    public function visitdc(){
        return $this->belongsTo(visit_dc::class, "UID");
    }
}
