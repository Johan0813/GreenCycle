<?php

namespace App\Http\Controllers;

use App\Models\Trees;
use Illuminate\Support\Facades\Gate;

class TreeCareController extends Controller
{
    public function care(Trees $tree)
    {
        Gate::authorize('care', $tree);

        if (in_array($tree->status, ['DEAD', 'MATURE'], true)) {
            return response()->json([
                'message' => 'Este arbol no puede recibir mas cuidados.',
                'status' => $tree->status,
            ], 409);
        }

        $tree->progress += 1;

        if ($tree->progress >= 5) {
            $tree->level += 1;
            $tree->progress = 0;
        }

        if ($tree->level >= 10) {
            $tree->level = 10;
            $tree->status = 'MATURE';
        }

        $tree->health = min(100, $tree->health + 20);

        $tree->last_cared_at = now();

        $tree->save();

        return response()->json([
            'message' => 'El arbol fue cuidado correctamente.',
            'id_tree' => $tree->id_tree,
            'progress' => $tree->progress,
            'health' => $tree->health,
            'last_cared_at' => $tree->last_cared_at,
        ], 200);
    }
}
