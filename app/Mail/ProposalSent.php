<?php

namespace App\Mail;

use App\Models\Proposal as ModelsProposal;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;

class ProposalSent extends Mailable
{
    use Queueable, SerializesModels;

    public string $token;

    private function replace_tags($content)
    {
        $customer = $this->proposal->project->projectable;
        $user = $this->proposal->user;

        $customer_name = "";
        if($customer->getMorphClass() === "App\Models\Client") {
            $customer_name = $customer->full_name;
        } else {
            $customer_name = $customer->name;
        }

        $url = route("proposals.show", ["proposal" => $this->proposal, "t" => $this->token]);

        // proposal tags

        $htmlButton = $this->markdownRenderer()->render(
            "components.mail.button",
            ["url" => $url, "text" => "Proposal"]
        );

        $content = str_replace('[LinkToProposal]', $htmlButton, $content);
        $content = str_replace('[ProposalName]', $this->proposal->name, $content);
        $content = str_replace('[ProposalCreatedOn]', $this->proposal->created_at, $content);
        $content = str_replace('[ProposalExpiresOn]', $this->proposal->expiration_date, $content);

        // customer tags

        $content = str_replace('[CustomerName]', $customer_name, $content);
        $content = str_replace('[CustomerEmail]', $customer->email, $content);
        $content = str_replace('[CustomerPhone]', $customer->phone, $content);
        $content = str_replace('[CustomerCountry]', $customer->address->country, $content);
        $content = str_replace('[CustomerCity]', $customer->address->city, $content);
        $content = str_replace('[CustomerZip]', $customer->address->zip, $content);
        $content = str_replace('[CustomerAddress]', $customer->address->address, $content);

        // user tags

        $content = str_replace('[UserName]', $user->name, $content);
        $content = str_replace('[UserEmail]', $user->email, $content);
        $content = str_replace('[UserPhone]', $user->phone, $content);

        return $content;
    }

    /**
     * Create a new message instance.
     */
    public function __construct(
        public ModelsProposal $proposal,
    )
    {
        $this->token = "";
        $customer = $this->proposal->project->projectable;

        if($customer->getMorphClass() === "App\Models\Client") {
            $clientQuery = $this->proposal->clients()
                ->where('email_proposalable_id', $customer->id)
                ->where('email_proposalable_type', $customer->getMorphClass());

            if($clientQuery->exists()) {
                $this->token = $clientQuery
                    ->first()
                    ->pivot
                    ->token;
            }
        } else {
            $companyQuery = $this->proposal->companies()
                ->where('email_proposalable_id', $customer->id)
                ->where('email_proposalable_type', $customer->getMorphClass());
                
            if($companyQuery->exists()) {
                $this->token = $companyQuery
                    ->first()
                    ->pivot
                    ->token;
            }
        }

        if(empty($this->token)) {
            $this->token = Str::random(60);
            if($customer->getMorphClass() === "App\Models\Client") {
                $proposal->clients()->attach($customer, ['token' => $this->token]);
            } else {
                $proposal->companies()->attach($customer, ['token' => $this->token]);
            }
        }
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->proposal->emailTemplate->subject;
        $subject = $this->replace_tags($subject);

        return new Envelope(subject: $subject);
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $content = $this->proposal->emailTemplate->body;
        $content = $this->replace_tags($content);

        // # Proposal {{ $proposal->name }}
        // Hello {{ $name }},

        // I'm sending you our proposal, you can view it here:
        // <x-mail::button :url="$url">
        //     Proposal
        // </x-mail::button>
        
        // Thanks,<br>
        // {{ config('app.name') }}

        return new Content(
            markdown: 'mail.proposals.sent',
            with: [
                "content" => $content,
            ],
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
