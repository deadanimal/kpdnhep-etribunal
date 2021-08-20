<?php

namespace App\Libraries;

class NotificationLibrary
{
    public static function send($notification_method_id, $request, $mail_template = null)
    {
        if (in_array($notification_method_id, [2,3])) { // Send Email
            MailLibrary::send("********" . substr($request->identification_no, -4),
                $request->name, $request->email, $request->password, $request->language_id, $mail_template);
        }

        if (in_array($notification_method_id, [1,3])) { // Send SMS
            SmsLibrary::send($request->phone_mobile, $request->language_id);
        }

        return;
    }
}