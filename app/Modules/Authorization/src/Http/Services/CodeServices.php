<?php
namespace Authorization\Http\Services;

use App\Http\Controllers\Controller;
use Authorization\Models\VerifyCode;
use Carbon\Carbon;


class CodeServices extends Controller
{
    public function checkCode(string $code,string $subject,string $ip){
        $true_code = VerifyCode::query()->where("code",$code)->where("status",true)->where("confirmation_subject",$subject)->where("ip_address",$ip)->latest()->first();
        if (!$true_code){
            return false;
        }
        if (!($true_code->created_at->timestamp > Carbon::now()->subMinutes(30)->timestamp)){
            return false;
        }
        return true;
    }
}
