<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trees;

class TreesController extends Controller
{
    public function index(){
        $trees = Trees::all();
        return view('list', compact('trees'));
    }

    public function show($id){
        $tree = Trees::find($id);
        if ($tree) {
            return view('show', compact('tree'));
        } else {
            return 'Árbol no encontrado';
        }
    }

public function store(Request $request){
    $tree = new Trees();

    $tree->level = 0;
    $tree->health = 100;
    $tree->progress = 0;
    $tree->status = 'ACTIVE';

    $tree->save();
    return view('tree', compact('tree'));

}
}
