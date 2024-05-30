<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Subgroup;

#[Group('Пользователи', 'API для взаимодействия с профилями пользователей')]
class UserController extends BaseController
{
    #[Endpoint('Список пользователей', 'Отобразить список зарегистрированных пользователей')]
    public function index() {
        $users = User::all();
        return $this->sendResponse($users, true);
    }

    #[Endpoint('Профиль пользователя', 'Отобразить профиль пользователя')]
    public function show(User $user) {
        return $this->sendResponse($user, true);
    }

//    public function profile() {
//        $user = Auth::user();
//        return $this->sendResponse($user, true);
//    }

    #[Endpoint('Редактирование профиля', 'Редактирование профиля авторизированного пользователя')]
    public function update(UserUpdateRequest $request) {
        $data = $request->validated();

        $user = Auth::user();
        Auth::user()->update($data);
        return $this->sendResponse($user, true);
    }

//    public function destroy()
//    {
//        $user = Auth::user();
//
//        $user->delete();
//        return $this->sendResponse(true, 'User deleted');
//    }
}
