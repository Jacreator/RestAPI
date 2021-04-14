@component('mail::message')
    # Hello {{ $user->name }}

    Thank your for Creating an Account with us. Use the button below to verify your Account

    @component('mail::button', ['url' => route('verify', $user->verification_token)])
        Verify Account
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent