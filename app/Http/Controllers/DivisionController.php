<?php

namespace App\Http\Controllers;

class DivisionController extends Controller
{
    public function index()
    {
        return view('division.index');
    }

    public function show($division)
    {
        return view('division.show', compact('division'));
    }
}
