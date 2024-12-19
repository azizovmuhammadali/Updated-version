<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\UserStoreRequest;
use App\Http\Requests\v1\UserUpdateRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
       return $this->success(UserResource::collection($users));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        $requestData = $request->validated();
        $user = new User();
        $user->name = $requestData['name'];
        $user->save();
        return $this->success(new UserResource($user));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return $this->success(new UserResource($user));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, string $id)
    {
        $requestData = $request->validated();
        $user =  User::findOrFail($id);
        $user->name = $requestData['name'] ?? $user->name;
        $user->save();
        return $this->success(new UserResource($user));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response([
            'message' => 'Successfully deleted',
        ]);
    }
}
