<?php
// newsletter.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize email
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    
    // Validate email
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Email configuration
        $to = "bookings@dmluxe.co.za, dimpho@dmluxe.co.za";
        $subject = "New Newsletter Subscription - DM Luxe Voyages";
        
        // Email headers
        $headers = "From: bookings@dmluxe.co.za\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        
        // Email body for admin
        $admin_message = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #0d6efd; color: white; padding: 20px; text-align: center; }
                .content { margin: 20px 0; padding: 15px; }
                .footer { background: #f8f9fa; padding: 15px; text-align: center; font-size: 12px; color: #666; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>New Newsletter Subscription</h1>
                    <p>DM Luxe Voyages</p>
                </div>
                
                <div class='content'>
                    <h3>New Subscriber Details:</h3>
                    <p><strong>Email Address:</strong> $email</p>
                    <p><strong>Subscription Date:</strong> " . date('Y-m-d H:i:s') . "</p>
                </div>
                
                <div class='footer'>
                    <p>This subscription was received through the DM Luxe Voyages website newsletter form.</p>
                </div>
            </div>
        </body>
        </html>
        ";
        
        // Send email to admin
        if (mail($to, $subject, $admin_message, $headers)) {
            // Send welcome email to subscriber
            $welcome_subject = "Welcome to DM Luxe Voyages - Luxury Travel Insights";
            $welcome_message = "
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                    .header { background: #0d6efd; color: white; padding: 20px; text-align: center; }
                    .content { margin: 20px 0; padding: 15px; }
                    .benefits { background: #f8f9fa; padding: 15px; margin: 15px 0; border-radius: 5px; }
                    .footer { background: #f8f9fa; padding: 15px; text-align: center; font-size: 12px; color: #666; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h1>Welcome to DM Luxe Voyages</h1>
                        <p>Luxury Travel Insights Newsletter</p>
                    </div>
                    
                    <div class='content'>
                        <p>Dear Subscriber,</p>
                        
                        <p>Thank you for joining our exclusive luxury travel community! We're thrilled to have you on board.</p>
                        
                        <div class='benefits'>
                            <h3>What You'll Receive:</h3>
                            <ul>
                                <li>Exclusive tour and flight specials</li>
                                <li>Destination guides and insider tips</li>
                                <li>VIP travel experiences and offers</li>
                                <li>Early access to new tour packages</li>
                                <li>Luxury travel trends and insights</li>
                            </ul>
                        </div>
                        
                        <p>As a valued member of our travel community, you'll be the first to know about our premium offers and curated experiences.</p>
                        
                        <p>Stay tuned for our next newsletter filled with inspiring destinations and exclusive deals!</p>
                        
                        <p>Warm regards,<br>
                        The DM Luxe Voyages Team</p>
                    </div>
                    
                    <div class='footer'>
                        <p>DM Luxe Voyages | Luxury Travel Experiences</p>
                        <p>South Africa | +27 72 369 9937 | bookings@dmluxe.co.za</p>
                        <p><a href='[UNSUBSCRIBE_LINK]' style='color: #666;'>Unsubscribe</a></p>
                    </div>
                </div>
            </body>
            </html>
            ";
            
            $welcome_headers = "From: bookings@dmluxe.co.za\r\n";
            $welcome_headers .= "Reply-To: bookings@dmluxe.co.za\r\n";
            $welcome_headers .= "MIME-Version: 1.0\r\n";
            $welcome_headers .= "Content-Type: text/html; charset=UTF-8\r\n";
            
            // Send welcome email
            mail($email, $welcome_subject, $welcome_message, $welcome_headers);
            
            // Return success response for AJAX
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode(['status' => 'success', 'message' => 'Thank you for subscribing! A welcome email has been sent to you.']);
            } else {
                // Redirect to success page for non-AJAX submissions
                header("Location: newsletter-success.html");
            }
            exit();
        } else {
            // Email sending failed
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode(['status' => 'error', 'message' => 'Sorry, there was an error processing your subscription. Please try again.']);
            } else {
                header("Location: newsletter-error.html");
            }
            exit();
        }
    } else {
        // Invalid email
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            echo json_encode(['status' => 'error', 'message' => 'Please enter a valid email address.']);
        } else {
            header("Location: newsletter-error.html");
        }
        exit();
    }
} else {
    // If not POST request, redirect back
    header("Location: index.html");
    exit();
}
?>
