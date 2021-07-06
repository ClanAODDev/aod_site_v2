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
        if (!view()->exists("division.content.{$division}")) {
            abort(404, 'Page not found');
        }

        return view('division.show', compact('division'));
    }
}
