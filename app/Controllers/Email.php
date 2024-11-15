<?php

namespace App\Controllers;

use App\Models\EmailModel;
use ReflectionException;

class Email extends BaseController
{
    /**
     * @throws ReflectionException
     */
    public function send():string
    {
        $emailService   = service('email');

        $emails         = model(EmailModel::class)->where("in_process IS NULL")->limit(50)->findAll();

        $message        = "E-mail by send: ".count($emails)."<hr>";

        foreach ($emails as $email)
            model(EmailModel::class)->update($email->id, row:["in_process" => '1']);

        foreach ($emails as $email){

            if(!empty($email->emailFrom) && !empty($email->name))
                $emailService->setFrom     ($email->emailFrom,$email->name);
            else
                $emailService->setFrom     ("no-reply@mgu-mlt.ru","No Reply MelSU");

            $emailService->setBCC('copy@mgu-mlt.ru');

            if(!empty($email->replyTo))
                $emailService->setReplyTo  ($email->replyTo);

            if(!empty($email->protocol))
                $emailService->setProtocol($email->protocol);


            $emailService->setTo           ($email->emailTo);
            $emailService->setSubject      ($email->theme);
            $emailService->setMessage      ($email->message);
            $emailService->send();

            $message.= "$email->emailTo<br>$email->theme<hr>";

            model(EmailModel::class)->delete($email->id);
        }

        return $message;

    }
}
