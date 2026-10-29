<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Trees extends Model
{
    protected $table = 'trees';

    protected $primaryKey = 'id_tree';

    protected $fillable = [
        'id_user',
        'id_seed_type',
        'level',
        'health',
        'progress',
        'status',
        'last_cared_at',
        'next_care_at',
        'last_decay_at',
        'harvested_at',
    ];

    protected $attributes = [
        'level' => 0,
        'health' => 100,
        'progress' => 0,
        'status' => 'ACTIVE',
    ];

    protected function casts(): array
    {
        return [
            'level' => 'integer',
            'health' => 'integer',
            'progress' => 'integer',
            'last_cared_at' => 'datetime',
            'next_care_at' => 'datetime',
            'last_decay_at' => 'datetime',
            'harvested_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'id_user',
            'id_user'
        );
    }

    public function seedType(): BelongsTo
    {
        return $this->belongsTo(
            SeedType::class,
            'id_seed_type',
            'id_seed_type'
        );
    }
}