<?php

namespace Services;

use Xcytek\EmailLibrary\Email;
use Xcytek\EmailLibrary\EmailSender;

class EmailXcytek implements IEmail
{

    public function sendRecovery(array $data) : bool
    {

        $user = $data['user'];
        $link = $data['link'];


        $email = new Email(__DIR__ . '/../vendor/xcytek/email_library/examples/templates/recovery.php', [
            'link' => $link,
            'name' => $user->first_name,
        ]);

        $email->setUse([
            'subject' => env('APP_NAME') . ' - Reset password',
            'to' => [
                [
                    'email' => $user->email,
                    'name'  => $user->first_name . ' ' . $user->last_name
                ]
            ]
        ]);

        $emailSender = new EmailSender();

        return $emailSender->send($email);

    }

}