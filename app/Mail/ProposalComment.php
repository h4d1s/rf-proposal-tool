<?php

namespace App\Mail;

use App\Models\Proposal;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class ProposalComment extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public Proposal $proposal,
        public string $message
    )
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "New comment in {$this->proposal->name}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $customer = $this->proposal->project->projectable;
        $customer_name = "";
        $pivot_exists = false;

        if($customer->getMorphClass() === "App\Models\Client") {
            $pivot_exists = $this->proposal->clients()
                ->where('email_proposalable_id', $customer->id)
                ->exists();
        } else {
            $pivot_exists = $this->proposal->companies()
                ->where('email_proposalable_id', $customer->id)
                ->exists();
        }
        
        $token = "";

        if(!$pivot_exists) {
            $token = Str::random(60);
            if($customer->getMorphClass() === "App\Models\Client") {
                $this->proposal->clients()->attach($customer, ['token' => $token]);
            } else {
                $this->proposal->companies()->attach($customer, ['token' => $token]);
            }
        } else {
            if($customer->getMorphClass() === "App\Models\Client") {
                $token = $this->proposal->clients()
                    ->where('email_proposalable_id', $customer->id)
                    ->first()
                    ->pivot
                    ->token;
            } else {
                $token = $this->proposal->companies()
                    ->where('email_proposalable_id', $customer->id)
                    ->first()
                    ->pivot
                    ->token;
            }
        }

        if($customer->getMorphClass() === "App\Models\Client") {
            $customer_name = $this->proposal->project->projectable->full_name;
        } else {
            $customer_name = $this->proposal->project->projectable->name;
        }

        return new Content(
            markdown: 'mail.proposals.comment',
            with: [
                'proposal' => $this->proposal,
                'url' => route("proposals.show", [
                    "proposal" => $this->proposal,
                    "t" => $token,
                    "comment" => "true"
                ]),
                'name' => $customer_name,
                'message' => $this->message
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
