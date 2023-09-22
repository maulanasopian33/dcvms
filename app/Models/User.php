<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = 'id_user';
    public $incrementing = false;
    protected $fillable = [
        'id_user',
        'name',
        'email',
        'ktp',
        'nik'
    ];

    public function teams(){
        return $this->hasMany(teams::class, "lead_id");
    }
    public function product(){
        return $this->hasMany(product::class, "id_user");
    }

}
