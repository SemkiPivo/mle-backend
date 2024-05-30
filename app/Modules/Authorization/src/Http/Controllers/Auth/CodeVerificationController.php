<?php

namespace Authorization\Http\Controllers\Auth;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use Authorization\Http\Requests\Auth\CodeConfirmationFormRequest;
use Authorization\Http\Requests\Auth\CodeFormRequest;
use Authorization\Interfaces\Services\VerifyCodeServiceInterface;
use Authorization\Mail\CodeVerification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\QueryParam;
use Knuckles\Scribe\Attributes\Response;
use Knuckles\Scribe\Attributes\ResponseField;
use Knuckles\Scribe\Attributes\Subgroup;

#[Group('Авторизация', 'API предназначенное для авторизации пользователя')]
#[Subgroup('Код подтверждения', 'Отправка кода подтверждения номера телефона')]
class CodeVerificationController extends BaseController
{
    public function __construct(
        public VerifyCodeServiceInterface $codeService,
    ) {
    }

    #[Endpoint('Отправить код', 'На электронную почту пользователя отправляется код подтверждения')]
    #[Response(['data' => null, 'message' => 'OK',], 200)]
    #[ResponseField('data', 'null')]
    #[ResponseField('message', 'string')]
    public function sendCode(CodeFormRequest $request): JsonResponse
    {
        $data = $request->validated();

        $data['ip_address'] = $request->ip();
        $data['confirmation_subject'] = $data['subject'];
        $data['code'] = $this->codeService->make($data);

       if (!config('code_verification.status')) {
            Mail::to($data['subject'])->send(new CodeVerification($data));
        } else {
           return $this->sendError('Сообщение не было отправлено', code: 400);
       }

        return $this->sendResponse(message: 'Verification code sent', result: ['code' => $data['code']]);
    }

    #[Endpoint('Проверить код', 'Проверка отправленного кода')]
    #[Response(['data' => null, 'message' => 'OK',], 200)]
    #[ResponseField('data', 'null')]
    #[ResponseField('message', 'string')]
    public function confirmCode(CodeConfirmationFormRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['ip'] = $request->ip();

        try {
            $true_code = $this->codeService->check(
                code: $data['code'],
                subject: $data['subject'],
                ip: $data['ip'],
            );

        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), 'Данные неверны');
        }


        $true_code->update(['status' => true]);

        return $this->sendResponse(message: 'OK', result: $true_code);
    }
}
