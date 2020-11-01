<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
// 追加
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    // --------------------
    // 以降追加

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function sendResetLinkEmail(Request $request)
    {
        // 下記エラー抑止のため@varを指定
        // expected type 'object'. found 'void'.intelephense(1006)
        /** @var object */
        $validate = $this->validateEmail($request->all());

        if ($validate->fails()) {
            return new JsonResponse('Email is Invalid');
        }

        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse($request, $response)
            : $this->sendResetLinkFailedResponse($request, $response);
    }

    protected function validateEmail(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email',
        ]);
    }

    protected function sendResetLinkResponse(): JsonResponse
    {
        return new JsonResponse('Send Reset Mail');
    }

    protected function sendResetLinkFailedResponse(Request $request, $response): JsonResponse
    {
        return new JsonResponse(trans($response));
    }
}
