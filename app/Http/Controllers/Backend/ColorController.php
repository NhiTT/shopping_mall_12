<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Color;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::paginate(10);

        return view('backend.colors.colorList', compact('colors'));
    }
}
