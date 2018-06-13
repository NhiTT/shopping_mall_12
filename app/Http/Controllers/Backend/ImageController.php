<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Repositories\ImageRepositoryEloquent;

class ImageController extends Controller
{
    public function index()
    {
        $data = new ImageRepositoryEloquent;
        $images = $data->getAll(10);

        return view('backend.images.imageList', compact('images'));
    }
}
