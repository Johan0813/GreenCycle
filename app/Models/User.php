<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';

    protected $primaryKey = 'id_user';

    protected $fillable = [
        'name',
        'email',
        'password',
        'coins',
    ];

    public function trees()
    {
        return $this->hasMany(Trees::class, 'id_user', 'id_user');
    }

    public function inventory()
    {
        return $this->hasMany(Inventory::class, 'id_user', 'id_user');
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class, 'id_user', 'id_user');
    }
}