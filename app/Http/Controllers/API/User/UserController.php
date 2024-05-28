<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseController
{
    public function index() {
        $users = User::all();
        return $this->sendResponse($users, true);
    }

//    public function store(UserStoreRequest $request) {
//        $data = $request->validated();
//
//        $user = User::create($data);
//        return $this->sendResponse($user, true);
//    }

    public function update(UserUpdateRequest $request) {
        $data = $request->validated();

        $user = Auth::user();
        Auth::user()->update($data);
        return $this->sendResponse($user, true);
    }

    public function destroy()
    {
        $user = Auth::user();

        $user->delete();
        return $this->sendResponse(true, 'User deleted');
    }
}
