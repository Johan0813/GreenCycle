<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Arboles;

class ArbolesController extends Controller
{
    public function index()
    {
        $arboles = Arboles::all();
        return view('list', compact('arboles'));
    }

    public function show($id)
    {
        $arboles = Arboles::find($id);
        if ($arboles) {
            return view('show', compact('arboles'));
        } else {
            return 'Árbol no encontrado';
        }
    }

    public function create(...)
    {
   ...
    }
}
