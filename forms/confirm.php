<?php
// Set admin email
$admin_email = "bookings@dmluxe.co.za";

// Domain email (authorized sender)
$from_email = "bookings@dmluxe.co.za";

// Where to store confirmed subscribers (simple text file for now)
$subscribers_file = __DIR__ . "/subscribers.txt";

if (isset($_GET['email'])) {
    $subscriber = filter_var($_GET['email'], FILTER_SANITIZE_EMAIL);

    if (!filter_var($subscriber, FILTER_VALIDATE_EMAIL)) {
        die("❌ Invalid confirmation link.");
    }

    // Check if already subscribed
    if (file_exists($subscribers_file)) {
        $subscribers = file($subscribers_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if (in_array($subscriber, $subscribers)) {
            die("✅ This email is already subscribed.");
        }
    }

    // Save subscriber
    file_put_contents($subscribers_file, $subscriber . PHP_EOL, FILE_APPEND);

    // 1. Send Welcome Email to subscriber
    $welcome_subject = "Welcome to DM Luxe Voyages Newsletter";
    $welcome_message = "
    <html>
    <body>
      <h2>🎉 Welcome aboard!</h2>
      <p>Thank you for confirming your subscription to <b>DM Luxe Voyages</b>.</p>
      <p>From now on, you’ll receive exclusive updates, luxury travel tips, and VIP deals.</p>
      <br>
      <p>Safe travels,</p>
      <p><b>DM Luxe Voyages Team</b></p>
    </body>
    </html>";

    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8\r\n";
    $headers .= "From: DM Luxe Voyages <{$from_email}>\r\n";
    $headers .= "Reply-To: {$admin_email}\r\n";

    mail($subscriber, $welcome_subject, $welcome_message, $headers);

    // 2. Notify Admin
    $admin_subject = "✅ New Confirmed Newsletter Subscriber";
    $admin_message = "The following email has confirmed subscription: " . $subscriber;
    mail($admin_email, $admin_subject, $admin_message, "From: {$from_email}");

    // 3. Show confirmation page
    echo "
    <html>
      <head><title>Subscription Confirmed</title></head>
      <body style='text-align:center; font-family: Arial;'>
        <h2>🎉 Subscription Confirmed!</h2>
        <p>Thank you, <b>{$subscriber}</b>. You are now part of our luxury travel community.</p>
        <p>Look out for our next exclusive update in your inbox.</p>
        <br>
        <a href='index.html' style='background:#000; color:#fff; padding:10px 20px; text-decoration:none; border-radius:5px;'>Return to Homepage</a>
      </body>
    </html>
    ";
} else {
    echo "❌ Invalid request. No email found.";
}
?>
