<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\API\BaseController;
use App\Models\User;
use http\Client\Request;

class UserController extends BaseController
{
    public function index() {
        $users = User::all();
        return $this->sendResponse($users, true);
    }

//    public function store(Request $request) {
//        $data = $request->validated;
//
//        $user = User::create($data);
//        return $this->sendResponse($users, true);
//    }
}
