<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 12/11/2016
 * Time: 12:27
 */

namespace App;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class ChangeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $change;
    public $subject;

    public function __construct(Change $change, $subject)
    {
        $this->change = $change;
        $this->subject = $subject;
    }

    public function build()
    {
        return $this->view('changeMail')->subject($this->subject);
    }

}