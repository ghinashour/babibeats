<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;

class AlbumController extends Controller
{
    public function index(){
        return Album::with('artist')->get();
    }
    public function show($id){
        returnAlbum::with(['artist', 'tracks'])->findOrFail($id);
    }
}
