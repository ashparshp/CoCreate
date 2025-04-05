<?php

namespace App\Mail;

use App\Models\JoinRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProjectJoinRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $joinRequest;

    public function __construct(JoinRequest $joinRequest)
    {
        $this->joinRequest = $joinRequest;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Project Join Request - ' . $this->joinRequest->project->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.projects.join-request',
            with: [
                'joinRequest' => $this->joinRequest,
                'url' => url('/projects/' . $this->joinRequest->project_id),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}