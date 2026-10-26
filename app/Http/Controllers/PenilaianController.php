<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    public function index()
    {
        return view('penilaian.index');
    }

    public function show($id)
    {
        return view('penilaian.show', compact('id'));
    }    
}
