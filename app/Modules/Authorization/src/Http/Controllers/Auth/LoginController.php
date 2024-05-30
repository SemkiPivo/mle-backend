<?php

namespace Authorization\Http\Controllers\Auth;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use Authorization\Http\Requests\Auth\LoginFormRequest;
use Illuminate\Support\Facades\Auth;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Response;
use Knuckles\Scribe\Attributes\ResponseField;
use Knuckles\Scribe\Attributes\Subgroup;

#[Group("Авторизация")]
#[Subgroup("Вход", "Вход пользователя")]
class LoginController extends BaseController
{
    #[Endpoint("Войти в аккаунт", "Эндпоинт необходим для аутентификации пользователя в системе")]
    #[Response(["data" => ["token" => "1|zoBOyNT0SVZAX2yII1hsDs0kmOdvFERU0WAFvIjz370200e1"], "message" => "Успешный вход.",], 200)]
    #[Response(["data" => null, "message" => "Ошибка авторизации. Проверьте правильно ли указаны логин или пароль"], 404)]
    #[ResponseField("data", "array")]
    #[ResponseField("data.token", "string")]
    #[ResponseField("message", "string")]
    public function login(LoginFormRequest $request)
    {
        $data = $request->validated();
        $data['email'] = mb_strtolower($data['email']);

        if (Auth::attempt($data)) {
            $user = Auth::user();
            $user = auth()->user();
            $user->tokens()->delete();
            $user['token'] = $user->createToken(env("APP_NAME", "app"), ["*"], now()->addMonth())->plainTextToken;
            return $this->sendResponse($user, 'Успешный вход.');
//            return $this->sendResponse(["token" => $token], 'Успешный вход.');
        } else return $this->sendError(error: "Authorization error. Check if the input data is correct");

    }
}
