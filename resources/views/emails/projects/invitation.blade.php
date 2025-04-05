<x-mail::message>
# Project Invitation

{{ $inviter->name }} has invited you to join the project "{{ $project->title }}".

## Project Description:
{{ $project->description }}

You can accept or decline this invitation from your dashboard.

<x-mail::button :url="$url">
View Invitation
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>