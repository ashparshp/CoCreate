<?php

namespace App\Mail;

use App\Models\Project;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProjectInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public $project;
    public $inviter;

    public function __construct(Project $project, User $inviter)
    {
        $this->project = $project;
        $this->inviter = $inviter;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invitation to Join Project: ' . $this->project->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.projects.invitation',
            with: [
                'project' => $this->project,
                'inviter' => $this->inviter,
                'url' => url('/dashboard'),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}