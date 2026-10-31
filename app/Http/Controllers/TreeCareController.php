<?php

namespace App\Http\Controllers;

use App\Models\Trees;
use Illuminate\Support\Facades\Gate;
use App\Services\TreeHealthService;
use App\Services\TreeStateService;
use Illuminate\Support\Facades\DB;

class TreeCareController extends Controller
{
    public function care(
        Trees $tree,
        TreeHealthService $healthService,
        TreeStateService $stateService
    ) {
        return DB::transaction(function () use ($tree, $healthService, $stateService) {
            $tree = Trees::whereKey($tree->getKey())
                ->lockForUpdate()
                ->firstOrFail();
            Gate::authorize('care', $tree);

            if ($tree->status !== 'ACTIVE') {
                return response()->json([
                    'message' => 'Este arbol no puede recibir mas cuidados.',
                    'status' => $tree->status,
                ], 409);
            }
            if ($tree->next_care_at && now()->lt($tree->next_care_at)) {
                return response()->json([
                    'message' => 'El arbol no puede recibir cuidados aun.',
                    'next_care_at' => $tree->next_care_at->toISOString(),
                ], 409);
            }
            $healthService->applyDecay($tree);
            $stateService->updateState($tree);

            if ($tree->status === 'DEAD') {
                return response()->json([
                    'message' => 'El arbol ha muerto por falta de cuidados.',
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
            $tree->next_care_at = $tree->last_cared_at->copy()->addMinutes(60);

            $tree->save();

            return response()->json([
                'message' => 'El arbol fue cuidado correctamente.',
                'id_tree' => $tree->id_tree,
                'progress' => $tree->progress,
                'health' => $tree->health,
                'last_cared_at' => $tree->last_cared_at->toISOString(),
                'next_care_at' => $tree->next_care_at->toISOString(),
            ], 200);
        });
    }
}