<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TemplesRegistration;
use App\Mail\TempleOneMonthNotificationMail;
use Illuminate\Support\Facades\Mail;

class NotificationController extends Controller
{
   // NotificationController.php
 public function sendSingle($id)
    {
        $temple = TemplesRegistration::findOrFail($id);

        // Check registered email
        if (empty($temple->email)) {
            return back()->with(
                'error',
                'No registered email found for ' . $temple->temple_name
            );
        }

        // Prevent duplicate notification
        if (!is_null($temple->one_month_notification_sent_at)) {
            return back()->with(
                'error',
                'Notification has already been sent to ' . $temple->temple_name
            );
        }

        try {

            // Send mail to the temple's registered email ID
            Mail::to($temple->email)->send(
                new TempleOneMonthNotificationMail(
                    $temple,
                    false
                )
            );

            // Mark notification as sent only after mail is sent
            $temple->update([
                'one_month_notification_sent_at' => now(),
            ]);

            return back()->with(
                'success',
                'Notification sent successfully to ' .
                $temple->temple_name .
                ' (' . $temple->email . ')'
            );

        } catch (\Exception $e) {

            return back()->with(
                'error',
                'Mail could not be sent: ' . $e->getMessage()
            );
        }
    }
}
