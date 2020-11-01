<?php
return [
    //フロントエンドのURL
    'url' => env('FRONTEND_URL', 'http://localhost:3000'),
    // フロントエンドのパスワードリセットページのURL
    'reset_pass_url' => env('RESET_PASS_URL', '/reset?queryURL='),
    // メール認証用URL
    'email_verify_url' => env('FRONTEND_EMAIL_VERIFY_URL', '/verify?queryURL='),
];
