# Laravel 12 Gmail SMTP Emailer -- Full Documentation

## Overview

This documentation explains how to successfully set up Gmail SMTP as
your email sender in Laravel 12 using Google's latest security
standards. As Google removed "Less Secure Apps," the only correct way is
to use **App Password authentication**.

------------------------------------------------------------------------

## 1. Requirements

-   Laravel 12 application
-   Gmail account
-   Google 2-Step Verification enabled
-   Gmail App Password (16‑character)

------------------------------------------------------------------------

## 2. Enable Google 2‑Step Verification

Google requires 2FA before generating app passwords.

1.  Go to **Google Account → Security**\
2.  Turn ON **2-Step Verification**\
3.  Complete the setup using your device

Link:\
https://myaccount.google.com/security

------------------------------------------------------------------------

## 3. Generate Gmail App Password

Once 2-step verification is enabled:

1.  Visit: https://myaccount.google.com/apppasswords\
2.  Select:
    -   **App:** Mail
    -   **Device:** Other → type `Laravel App`
3.  Google will generate a **16‑character App Password**\
    Example: `abcd efgh ijkl mnop`

Use it without spaces.

------------------------------------------------------------------------

## 4. Configure Your `.env`

Open `.env` and set:

``` env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=yourgmail@gmail.com
MAIL_PASSWORD=your_app_password_here
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=yourgmail@gmail.com
MAIL_FROM_NAME="Your App Name"
```

> ⚠️ IMPORTANT\
> Use your **App Password**, NOT your real Gmail login password.

------------------------------------------------------------------------

## 5. Confirm `config/mail.php`

The default Laravel 12 `mail.php` should already support SMTP, but
ensure this exists:

``` php
'mailers' => [
    'smtp' => [
        'transport' => 'smtp',
        'host' => env('MAIL_HOST', 'smtp.gmail.com'),
        'port' => env('MAIL_PORT', 587),
        'encryption' => env('MAIL_ENCRYPTION', 'tls'),
        'username' => env('MAIL_USERNAME'),
        'password' => env('MAIL_PASSWORD'),
    ],
],
```

------------------------------------------------------------------------

## 6. Create a Test Email Route

Add this to `routes/web.php`:

``` php
use Illuminate\Support\Facades\Mail;

Route::get('/test-email', function () {
    Mail::raw('This is a test email from Laravel Gmail SMTP!', function ($message) {
        $message->to('yourreceiver@gmail.com')
                ->subject('Gmail SMTP Test');
    });

    return 'Email sent!';
});
```

Run the route in browser:

    http://yourapp.test/test-email

If configured correctly, you'll receive the email instantly.

------------------------------------------------------------------------

## 7. Fix Common Gmail SMTP Errors

### **Error: "Connection Could Not Be Established"**

Run Google's unlock captcha:

https://accounts.google.com/DisplayUnlockCaptcha\
Click **Allow**.

Then retry sending the email.

------------------------------------------------------------------------

## 8. Clear Config Cache

Laravel may cache old settings. Run:

    php artisan config:clear
    php artisan cache:clear
    php artisan optimize:clear

------------------------------------------------------------------------

## 9. Optional Enhancements

### **HTML Email Templates**

Create Mailable:

``` bash
php artisan make:mail WelcomeMail
```

Use Blade templates:

    resources/views/emails/welcome.blade.php

### **Password Reset Emails**

Laravel provides built-in email verification and password reset using
this same Gmail SMTP configuration.

### **Queued Email Sending (Recommended)**

    Mail::to($email)->queue(new WelcomeMail());

### **Contact Form Emailer**

Use a controller to send support messages directly to your Gmail.

------------------------------------------------------------------------

## 10. Summary

  Step                    Description
  ----------------------- -----------------------
  Enable 2FA              Required by Google
  Generate App Password   Needed for SMTP login
  Update `.env`           Configure Gmail SMTP
  Test route              Verify sending works
  Clear caches            Avoid config issues

------------------------------------------------------------------------

## Final Notes

-   Gmail SMTP has a daily limit (\~500 emails/day)
-   For production apps, consider SendGrid / Mailgun
-   App Password is safe because it can be deleted anytime

------------------------------------------------------------------------

## License

This documentation is provided free for personal and commercial use.

------------------------------------------------------------------------

**Created for: Nelmar Dapulang**\
**Assistant: ChatGPT -- Laravel Specialist**
