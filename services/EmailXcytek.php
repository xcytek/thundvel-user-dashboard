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


    public function sendVerifyAccount(array $data): bool
    {
        $user = $data['user'];
        $code = $data['code'];


        $email = new Email(__DIR__ . '/../vendor/xcytek/email_library/examples/templates/verify-account.php', [
            'code' => $code,
            'name' => $user->first_name,
        ]);

        $email->setUse([
            'subject' => env('APP_NAME') . ' - Verify your account',
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