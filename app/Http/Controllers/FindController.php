<?php

namespace App\Http\Controllers;

use App\Http\Resources\V1\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\v2\UserResource as V2UserResource;

class FindController extends Controller
{
    public function FindMethod(Request $request)
    {
        $version = $request->query('version') ?? 1;
        if ($version == 1) {
            $users = User::when($request->q, function ($query) use ($request) {
                return $query->where('name', 'like', "%" . $request->q . "%");
            })->paginate(2);
    
            return $this->responsePagination($users, UserResource::collection($users));
        } 
        elseif ($version == 2) {
            $users = User::when($request->q, function ($query) use ($request) {
                return $query->where('name', 'like', "%" . $request->q . "%");
            })->paginate(2);
    
            return $this->responsePagination($users, V2UserResource::collection($users));
        } 
        return $this->error();
    }
}
