<?php

namespace App\Http\Controllers;

//we place the model that we want to use
use App\Models\User;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //function to return all the users
    public function index(){
        return User::all();
    }
    //function to return only the user with specific id
    public function show($id){
        return User::with(['playlists', 'favorites', 'listeningHistory'])->findOrFail($id);
    }
}
