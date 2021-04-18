<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReceiptEmail extends Mailable
{
    use Queueable, SerializesModels;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('receiptemail.message');
        /*
        return $this->view('emails.novoacesso')->with([
            'nome'  => $this->user->name,
            'email' => $this->user->email,
            'datahora' => now()->setTimezone('America/Sao_Paulo')->format('d-m-Y H:i:s')
        ])->attach(base_path() . '/arquivos/arquivo.pdf');
        */
    }
}
