<?php

namespace Services;

use Xcytek\EmailLibrary\Email;
use Xcytek\EmailLibrary\EmailSender;

/**
 * @property Email emailInstance
 * @property EmailSender emailSenderInstance
 */
class EmailXcytek implements IEmail
{

    public function __construct()
    {
        $this->emailSenderInstance = new EmailSender();
        $this->emailInstance = new Email('');
        $this->emailInstance->config['username'] = env('EMAIL_USERNAME');
        $this->emailInstance->config['password'] = env('EMAIL_PASSWORD');
        $this->emailInstance->config['who_sent'] = env('EMAIL_WHO_SENT');
    }

    public function sendRecovery(array $data) : bool
    {

        $user = $data['user'];
        $link = $data['link'];

        $this->emailInstance->setView(
            __DIR__ . '/../resources/emails/recovery.php',
            [
                'link' => $link,
                'name' => $user->first_name,
            ]
        );

        $this->emailInstance->setUse([
            'subject' => env('APP_NAME') . ' - Reset password',
            'to' => [
                [
                    'email' => $user->email,
                    'name'  => $user->first_name . ' ' . $user->last_name
                ]
            ]
        ]);

        return $this->emailSenderInstance->send($this->emailInstance);

    }


    public function sendVerifyAccount(array $data): bool
    {
        $user = $data['user'];
        $code = $data['code'];


        $this->emailInstance->setView(
            __DIR__ . '/../resources/emails/verify-account.php',
            [
                'code' => $code,
                'name' => $user->first_name,
            ]
        );

        $this->emailInstance->setUse([
            'subject' => env('APP_NAME') . ' - Verify your account',
            'to' => [
                [
                    'email' => $user->email,
                    'name'  => $user->first_name . ' ' . $user->last_name
                ]
            ]
        ]);

        return $this->emailSenderInstance->send($this->emailInstance);
    }
}