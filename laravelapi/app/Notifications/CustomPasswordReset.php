<?php

namespace App\Notifications;

use App;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CustomPasswordReset extends Notification
{
    use Queueable;
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('パスワードリセット') // 件名
            ->view('emails.resetpass') // メールテンプレートの指定
            ->action(
                'パスワードリセット', // メール本文の $actionText
                config('frontend.url') . config('frontend.reset_pass_url') .
                    // url('api/password/reset', $this->token) //アクセスするURL(HTTP)
                    secure_url('api/password/reset', $this->token) //アクセスするURL(HTTPS)
            );
    }
}
