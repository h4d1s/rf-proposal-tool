<x-mail::message>
# New comment

Hello {{ $name }},

{{ $proposal->user->name }} commented on your proposal {{ $proposal->name }}:<br>
{{ $message }}

You can reply here:
<x-mail::button :url="$url">
  Proposal
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>