<?php

namespace App\Services;

use App\Models\Trees;
use Carbon\CarbonInterface;

class TreeHealthService
{
    public function applyDecay(Trees $tree): int
    {
        $start = $tree->last_cared_at ?? $tree->created_at;

        if ($start === null) {
            return 0;
        }

        if ($tree->last_decay_at !== null &&
            $tree->last_decay_at->greaterThan($start)) {
            $start = $tree->last_decay_at;
        }

        $hours = $start->diffInSeconds(now(), false) / 3600;

        if ($hours < 24) {
            return 0;
        }

        $periods = (int) floor($hours / 24);

        $previousHealth = $tree->health;
        $tree->health = max(0, $tree->health - ($periods * 20));

        $tree->last_decay_at = $start->copy()->addHours($periods * 24);

        $tree->save();

        return $previousHealth - $tree->health;
    }
}