<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class teams extends Model
{
    use HasFactory;
    protected $primaryKey = 'UID';

    public $incrementing = false;

    protected $fillable = [
        'UID',
        'lead_id',
        'name',
        'email',
        'phone',
        'nik',
        'ktp',
    ];

    public function users(){
        return $this->belongsTo(User::class, "id_user");
    }
}
