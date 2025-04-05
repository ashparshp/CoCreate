<x-mail::message>
# New Join Request

{{ $joinRequest->user->name }} has requested to join your project "{{ $joinRequest->project->title }}".

@if($joinRequest->message)
## Message from {{ $joinRequest->user->name }}:
"{{ $joinRequest->message }}"
@endif

Please review this request in your project dashboard.

<x-mail::button :url="$url">
View Request
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>