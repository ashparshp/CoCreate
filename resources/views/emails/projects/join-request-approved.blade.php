<x-mail::message>
# Join Request Approved

Good news! Your request to join the project "{{ $project->title }}" has been approved.

You can now access the project, view tasks, files, and collaborate with other team members.

<x-mail::button :url="$url">
View Project
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>