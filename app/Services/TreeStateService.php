<?php

namespace App\Services;

use App\Models\Trees;


class TreeStateService
{
    public function updateState(Trees $tree): void
    {
        if ($tree->status === 'MATURE') {
            return;
        }

        if ($tree->status === 'DEAD') {
            return;
        }

        if ($tree->health <= 0) {
            $tree->health = 0;
            $tree->status = 'DEAD';
            $tree->save();
        }
    }
}