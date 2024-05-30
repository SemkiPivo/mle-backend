<?php

namespace Authorization\Http\Controllers\Auth;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Authorization\Http\Requests\Auth\PasswordRequest;
use Authorization\Http\Services\CodeServices;
use Authorization\Interfaces\Services\VerifyCodeServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Response;
use Knuckles\Scribe\Attributes\Subgroup;

#[Group("Авторизация")]
#[Subgroup("Востановление", "Востановление аккаунта пользователя, востановление осуществляется через этап запроса кода подтверждения")]
class ForgotPasswordController extends BaseController
{
    public function __construct(
        public VerifyCodeServiceInterface $codeService,
    ) {
    }

    #[Endpoint("Изменить пароль", "Эндпоинт необходим для изменения пароля")]
    #[Response(["data" => null, "message" => "Пароль успешно изменен"], 200)]
    public function restore(PasswordRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['ip'] = $request->ip();
        try {
            $this->codeService->check(
                code: $data['code'],
                subject: $data['email'],
                ip: $data['ip'],
            );
        } catch (\Throwable $th) {
            return $this->sendError('Error!', errorMessages: $th->getMessage());
        }

        $user_find = User::query()->where("email", $data['email'])->first();
        if ($user_find) {
            $user_find->update([
                "password" => Hash::make($data['password']),
            ]);
            return $this->sendResponse('Success' ,message: "Пароль успешно изменен", );
        }
        return $this->sendError('Error!', errorMessages: "Возникла ошибка при изменении пароля");
    }
}
