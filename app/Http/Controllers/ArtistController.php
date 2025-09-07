<?php

namespace App\Http\Controllers;
use App\Models\Artist;

use Illuminate\Http\Request;

class ArtistController extends Controller
{
    public function index(){
        return Artist::all();
    }
    public function sohw($id){
        return Artist::with('albums.tracks')->findOrFail($id);
    }
}
