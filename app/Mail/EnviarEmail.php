<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EnviarEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $dataemail;
    /**
     * Create a new message instance.
     */
    public function __construct($dataemail)
    {
        /*
         * assunto
         * corpoemail
         *
        */
        $this->dataemail = $dataemail;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->dataemail['assunto']
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'envioemails.enviar.index',
            with: [
                'corpo'=>$this->dataemail['corpo'],
                'assinatura'=>$this->dataemail['assinatura'],
                'imagem_assinatura'=>$this->dataemail['imagem_assinatura']
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
        $attachments = [];

        if ($this->dataemail['anexos'] != null) {
            foreach ($this->dataemail['anexos'] as $anexo) {

                array_push(
                    $attachments,
                    Attachment::fromPath(base_path() . '/anexos/' . $anexo->hashname)
                        ->as($anexo->nome)
                );
            }
        }

        return $attachments;
    }
}
