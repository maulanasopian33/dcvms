<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
class admin extends Model implements Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, AuthenticableTrait;
    // Sesuaikan sesuai dengan nama tabel dan kolom yang digunakan untuk admin
    protected $table = 'admins';
    protected $primaryKey = 'id';
    // ... definisikan atribut lainnya

    public function getAuthIdentifierName()
    {
        return 'id'; // Ganti dengan nama kolom yang merupakan identifier untuk admin
    }

    public function getAuthIdentifier()
    {
        return $this->{$this->getAuthIdentifierName()};
    }

    protected $fillable=['username','fullname','password'];
}
