<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    //use Queueable, SerializesModels;
    protected $name;
    protected $email;
    //protected $subject;
    protected $task_name;
    protected $task_project_name;
    protected $status;

    /**
     * SendMail constructor.
     * @param $name
     * @param $email
     * @param $subject
     * @param $message
     */
    public function __construct($name, $email,$task_name,$task_project_name,$status)
    {
        $this->name = $name;
        $this->email = $email;
        $this->task_name = $task_name;
        $this->task_project_name = $task_project_name;
        $this->status = $status;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $resp['name'] = $this->name;
        $resp['email'] = $this->email;
        $resp['task_name'] = $this->task_name;
        $resp['task_project_name'] = $this->task_project_name;
        $resp['status'] = $this->status;

        return $this->view('mail.send_mail', compact('resp'));
    }
}
