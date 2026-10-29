<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeedType extends Model
{
    protected $table = 'seed_types';

    protected $primaryKey = 'id_seed_type';

    protected $fillable = [
        'id_item',
        'name',
        'description',
        'cares_per_level',
        'harvest_reward'
    ];

    public function trees()
    {
        return $this->hasMany(Trees::class, 'id_seed_type', 'id_seed_type');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'id_item', 'id_item');
    }
}