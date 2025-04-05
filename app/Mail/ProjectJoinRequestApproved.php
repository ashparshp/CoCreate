<?php

namespace App\Mail;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProjectJoinRequestApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Request to Join "' . $this->project->title . '" Has Been Approved',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.projects.join-request-approved',
            with: [
                'project' => $this->project,
                'url' => url('/projects/' . $this->project->id),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}