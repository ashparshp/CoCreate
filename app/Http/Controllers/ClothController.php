<?php

// app/Http/Controllers/ClothController.php
namespace App\Http\Controllers;

use App\Models\Cloth;
use Illuminate\Http\Request;

class ClothController extends Controller
{
    public function index()
    {
        $clothes = Cloth::all();
        return view('clothes.index', compact('clothes'));
    }
    
    public function show($id)
    {
        $cloth = Cloth::find($id);
        
        if (!$cloth) {
            abort(404);
        }
        
        return view('clothes.show', compact('cloth'));
    }
}