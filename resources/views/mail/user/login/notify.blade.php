@component('mail::message')
# Hello, {{ $user->name }}

You just login {{ config('app.name') }} Application, the time is at {{ now() }}.

If this is not your operation, be careful that your password may be leaked.

@component('mail::button', ['url' => config('app.url').'/password/reset'])
Password reset
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
