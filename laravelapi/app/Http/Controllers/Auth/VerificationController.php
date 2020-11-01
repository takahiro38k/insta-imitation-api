<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use App\User;
use Illuminate\Http\JsonResponse;

class VerificationController extends Controller
{
    use VerifiesEmails;

    public function __construct()
    {
        $this->middleware('throttle:6,1');
    }

    public function verify(Request $request)
    {
        $user = User::find($request->route('id'));
        if (!$user->email_verified_at) {
            $user->markEmailAsVerified();
            event(new Verified($user));
            return new JsonResponse('Email Verified');
        }
        return new JsonResponse('Email Verify Failed');
    }

    public function resend(Request $request)
    {
        $user = User::where('email', $request->get('email'))->get()->first();
        if (!$user) {
            return new JsonResponse('No Such User');
        }
        if ($user->hasVerifiedEmail()) {
            return new JsonResponse('Already Verified User');
        }

        $user->sendEmailVerificationNotification();

        return new JsonResponse('Send Verify Email');
    }
}

// 以下 default

// namespace App\Http\Controllers\Auth;

// use App\Http\Controllers\Controller;
// use App\Providers\RouteServiceProvider;
// use Illuminate\Foundation\Auth\VerifiesEmails;

// class VerificationController extends Controller
// {
//     /*
//     |--------------------------------------------------------------------------
//     | Email Verification Controller
//     |--------------------------------------------------------------------------
//     |
//     | This controller is responsible for handling email verification for any
//     | user that recently registered with the application. Emails may also
//     | be re-sent if the user didn't receive the original email message.
//     |
//     */

//     use VerifiesEmails;

//     /**
//      * Where to redirect users after verification.
//      *
//      * @var string
//      */
//     protected $redirectTo = RouteServiceProvider::HOME;

//     /**
//      * Create a new controller instance.
//      *
//      * @return void
//      */
//     public function __construct()
//     {
//         $this->middleware('auth');
//         $this->middleware('signed')->only('verify');
//         $this->middleware('throttle:6,1')->only('verify', 'resend');
//     }
// }
