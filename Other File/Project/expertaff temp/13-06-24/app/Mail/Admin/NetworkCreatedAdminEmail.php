<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NetworkCreatedAdminEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $admins;
    protected $user;
    protected $network;
    /**
     * Create a new message instance.
     */
    public function __construct($admins, $user, $network)
    {
        $this->admins = $admins;
        $this->user = $user;
        $this->network = $network;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Network Created email To Admin',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'web.pages.email.networkcreated',
            with: [
                'network_name' => $this->network->network_name,
                'network_type' => $this->network->network_type,
                'network_url' => $this->network->network_url,
                'affiliate_tracking_software' => $this->network->affiliate_tracking_software,
                'offer_count' => $this->network->offer_count,
                'min_payout' => $this->network->min_payout,
                'payout_frequency' => $this->network->payout_frequency,
                'referral_commission' => $this->network->referral_commission,
                'user_name' => $this->user->name,
                'user_email' => $this->user->email,
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
