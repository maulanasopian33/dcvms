<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;
    protected $fillable = ['orderId','id_user','productName','domain','status','regDate'];

    public function users(){
        return $this->belongsTo(User::class, "id_user");
    }
    public function surat(){
        return $this->hasMany(surat::class, "id");
    }

    public function productdetail(){
        return $this->hasMany(productdetail::class, "productId");
    }
}
