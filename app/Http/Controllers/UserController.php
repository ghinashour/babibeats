<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function index(){
        return User::all();
    }

    public function show(UserRequest $request , $id){
        $user =  User::with(['playlists', 'favorites', 'listeningHistories'])->findOrFail($id);
        return new UserResource($user);
    }
}
