<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
   public function agreement()
{
    // Get the logged-in user before logout
    $user = Auth::user();

    // If user exists, send email notification
    if ($user && $user->email) {
        $to = $user->email;
        $subject = "Logout Notification - Agreement Page";
        $message = "
            <html>
            <head>
                <title>Account Notice</title>
            </head>
            <body style='font-family: Arial, sans-serif; color: #333; line-height: 1.6;'>
                <p>Hi {$user->first_name},</p>

                <p>Thank you for creating your account with us. Your proposal has been successfully submitted and is currently under review by our team.</p>

                <p>We’ll notify you once it has been processed. In the meantime, feel free to log in anytime to check the status or update your information.</p>

                <br>
                <p>Best regards,<br><strong>The Support Team</strong></p>
            </body>
            </html>
            ";

        $headers  = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: noreply@yourdomain.com" . "\r\n"; // Replace with your domain email

        // Send email
        @mail($to, $subject, $message, $headers);
    }

    // Force logout
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    // Show agreement view
    return view('notifications.agreement');
}
}
