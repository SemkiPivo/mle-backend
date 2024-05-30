<?php

namespace Authorization\Http\Controllers\Auth;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Authorization\Http\Requests\Auth\RegisterCheckFormRequest;
use Authorization\Http\Requests\Auth\RegisterFormRequest;
use Authorization\Interfaces\Services\VerifyCodeServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Response;
use Knuckles\Scribe\Attributes\ResponseField;
use Knuckles\Scribe\Attributes\Subgroup;

#[Group("Авторизация")]
#[Subgroup("Регистрация", "Регистрация пользователя")]
class RegisterController extends BaseController
{
    public function __construct(

    ) {
    }


    #[Endpoint("Зарегистрировать пользователя", "Эндпоинт повторно проверяет данные вместе с паролем и авторизует пользователя")]
    #[Response(["data" => ["token" => "1|YS6hb29ybsALdzkAKghukjgny0Fzju3awd6iRTvvd4155e61"], "message" => "OK",], 200)]
    #[Response(["data" => null, "message" => "Код устарел",], status: 400, description: "Отправлен не валидный код")]
    #[ResponseField("data", "array")]
    #[ResponseField("data.token", "string")]
    #[ResponseField("message", "string")]
    public function register(RegisterFormRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = User::create($data);
        $token = $user->createToken(env("APP_NAME", "app"), ["*"], now()->addMonth())->plainTextToken;
        return $this->sendResponse(message: "OK", result: ["token" => $token]);

    }

    public function store(array $data): Model
    {
        $email = $data['email']
            ? mb_strtolower($data['email'])
            : null;

        return User::query()->create([
            "email" => $email,
            "phone" => $data['phone'],
            "first_name" => $data['first_name'],
            "middle_name" => $data['middle_name'] ?? null,
            "last_name" => $data['last_name'],
            "password" => Hash::make($data['password']),
        ]);
    }


}
