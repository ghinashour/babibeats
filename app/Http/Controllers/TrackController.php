<?php

namespace App\Http\Controllers;

use App/Models/Track;

use Illuminate\Http\Request;

class TrackController extends Controller
{
    public function index(){
        return Track::with(['artist', 'album'])->paginate(20);
    }
    public function show($id){
        return Track::with(['artist', 'album'])->findOrFail($id);
    }
}
