<h3>
    <!-- <a href="{{ config('app.url') }}">{{ config('app.name') }}</a> -->
    SNS Clone　パスワードリセットのご案内
</h3>
<p>
    <!-- {{ __('Click link below and reset password.') }}<br> -->
    <!-- {{ __('If you did not request a password reset, no further action is required.') }} -->
    {{ __('下記のリンクをクリックしてパスワードをリセットしてください。') }}<br>
    {{ __('パスワードをリセットしない場合は、何も操作は必要ありません。') }}
</p>
<p>
    {{ $actionText }}: <a href="{{ $actionUrl }}">{{ $actionUrl }}</a>
</p>
<p>
    {{ __('本メールにお心当たりがない場合は、お手数ではございますが本メールの削除をお願いいたします。')}}
</p>
