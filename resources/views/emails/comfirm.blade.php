@component('mail::message')
    # Hello {{ $user->name }}

    We Noticed your have Changed your e-Mail address, Plesea use the button below to comfirm your action:

    @component('mail::button', ['url' => route('verify', $user->verification_token)])
        Verify Account
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
