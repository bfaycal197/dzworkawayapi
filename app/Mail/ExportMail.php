<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Facades\Excel;

class ExportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pdfPath;
    public $degreePath;
    public $passportPath;
    public $firstName;
    public $lastName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pdfPath, $degreePath, $passportPath,$firstName, $lastName)
    {
        $this->pdfPath = $pdfPath;
        $this->degreePath = $degreePath; 
        $this->passportPath = $passportPath; 
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $message = $this->view('Client.export')
            ->subject('[DzWorkAway Forms] Un nouveau client ' . $this->firstName . ' ' . $this->lastName . ' vient de s inscrire ');


        if ($this->pdfPath) {
            $pdfContents = file_get_contents($this->pdfPath);
            $message->attachData($pdfContents, 'Cv.pdf', [
                'mime' => 'application/pdf'
            ]);
        }

        if ($this->degreePath) {
            $pdfContents = file_get_contents($this->degreePath);
            $message->attachData($pdfContents, 'degree.pdf', [
                'mime' => 'application/pdf'
            ]);
        }

        if ($this->passportPath) {
            $pdfContents = file_get_contents($this->passportPath);
            $message->attachData($pdfContents, 'passport.pdf', [
                'mime' => 'application/pdf'
            ]);
        }

        return $message;
    }
}
