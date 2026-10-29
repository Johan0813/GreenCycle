<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';

    protected $primaryKey = 'id_item';

    protected $fillable = [
        'name',
        'description',
        'price',
        'item_type'
    ];

    public function inventory()
    {
        return $this->hasMany(Inventory::class, 'id_item', 'id_item');
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class, 'id_item', 'id_item');
    }

    public function seedType()
    {
        return $this->hasOne(SeedType::class, 'id_item', 'id_item');
    }
}