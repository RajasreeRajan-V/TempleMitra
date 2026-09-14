<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TemplesRegistration;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\TempleOneMonthNotificationMail;

class SettingsController extends Controller
{
    /**
     * Display one-month registration notifications.
     */
   public function notifications()
{
    $oneMonthAgo = Carbon::now()->subMonth();

    $notifications = TemplesRegistration::whereNotNull('created_at')
        ->where('created_at', '<=', $oneMonthAgo)
        ->orderBy('created_at', 'asc')
        ->get();

    return view('admin.notifications', [
        'notifications' => $notifications,
        'oneMonthAgo' => $oneMonthAgo,
    ]);
}

    /**
     * Check and send one-month notifications.
     */
    public function checkOneMonthNotifications()
    {
        $oneMonthAgo = Carbon::now()->subMonth();

        $temples = TemplesRegistration::whereNotNull('created_at')
            ->where('created_at', '<=', $oneMonthAgo)
            ->whereNull('one_month_notification_sent_at')
            ->get();

        $processed = 0;

        foreach ($temples as $temple) {

            /*
             * Send email to Temple
             */
            if (!empty($temple->email)) {
                Mail::to($temple->email)
                    ->send(new TempleOneMonthNotificationMail($temple));
            }

            /*
             * Send email to Admin
             */
            $adminEmail = config('mail.admin_email');

            if (!empty($adminEmail)) {
                Mail::to($adminEmail)
                    ->send(new TempleOneMonthNotificationMail($temple, true));
            }

            /*
             * Mark notification as sent
             */
            $temple->one_month_notification_sent_at = Carbon::now();
            $temple->save();

            $processed++;
        }

        return redirect()
            ->route('admin.notifications')
            ->with(
                'success',
                $processed . ' one-month notification(s) processed successfully.'
            );
    }
}