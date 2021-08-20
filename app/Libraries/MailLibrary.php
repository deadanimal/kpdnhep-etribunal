<?php

namespace App\Libraries;

use Mail;

class MailLibrary
{
    public static function send($identification_no, $name, $email, $password, $language, $template = 'email.email')
    {
        $data = [
            'identification_no' => $identification_no,
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'language' => $language,
        ];

        $sendEmail = Mail::send($template, $data, function ($mail) use ($data) {
            $mail->from(config('mail.from.address'), config('mail.from.name'));
            $mail->to($data['email'], $data['name']);
            $mail->subject(env('APP_NAME'));
        });

        return $sendEmail;
    }
}