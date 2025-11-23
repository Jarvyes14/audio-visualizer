<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VisualizerController extends Controller
{
    public function index()
    {
        return view('visualizer.index');
    }
}
