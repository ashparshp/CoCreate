<?php

namespace App\Mail;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProjectJoinRequestRejected extends Mailable
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
            subject: 'Your Request to Join "' . $this->project->title . '" Has Been Declined',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.projects.join-request-rejected',
            with: [
                'project' => $this->project,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}