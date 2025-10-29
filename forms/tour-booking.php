<?php
// tour-booking.php - Handles both main booking form and tour-specific booking form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Determine which form was submitted
    $form_type = 'main_booking'; // Default
    
    // Check if it's the tour-specific booking form
    if (isset($_POST['travel-date']) || isset($_POST['tour_name'])) {
        $form_type = 'tour_booking';
    }
    
    if ($form_type === 'main_booking') {
        // Process main booking form (your original form)
        processMainBooking();
    } else {
        // Process tour-specific booking form
        processTourBooking();
    }
} else {
    // If not POST request, redirect back to form
    header("Location: index.html");
    exit();
}

function processMainBooking() {
    // Your existing main booking processing code
    $services = isset($_POST['services']) ? implode(", ", $_POST['services']) : 'None selected';
    $price_range = isset($_POST['price_range']) ? htmlspecialchars($_POST['price_range']) : 'Not specified';
    $from_location = isset($_POST['from_location']) ? htmlspecialchars($_POST['from_location']) : 'Not specified';
    $to_location = isset($_POST['to_location']) ? htmlspecialchars($_POST['to_location']) : 'Not specified';
    $departure_date = isset($_POST['departure_date']) ? htmlspecialchars($_POST['departure_date']) : 'Not specified';
    $return_date = isset($_POST['return_date']) ? htmlspecialchars($_POST['return_date']) : 'Not specified';
    $adults = isset($_POST['adults']) ? htmlspecialchars($_POST['adults']) : 'Not specified';
    $children = isset($_POST['children']) ? htmlspecialchars($_POST['children']) : 'Not specified';
    $infants = isset($_POST['infants']) ? htmlspecialchars($_POST['infants']) : 'Not specified';
    $first_name = isset($_POST['first_name']) ? htmlspecialchars($_POST['first_name']) : 'Not specified';
    $last_name = isset($_POST['last_name']) ? htmlspecialchars($_POST['last_name']) : 'Not specified';
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : 'Not specified';
    $phone = isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : 'Not specified';
    $nationality = isset($_POST['nationality']) ? htmlspecialchars($_POST['nationality']) : 'Not specified';
    $passport = isset($_POST['passport']) ? htmlspecialchars($_POST['passport']) : 'Not specified';
    $dietary = isset($_POST['dietary']) ? htmlspecialchars($_POST['dietary']) : 'None';
    $special_requests = isset($_POST['special_requests']) ? htmlspecialchars($_POST['special_requests']) : 'None';
    $travel_purpose = isset($_POST['travel_purpose']) ? htmlspecialchars($_POST['travel_purpose']) : 'Not specified';
    
    // Email configuration
    $to = "bookings@dmluxe.co.za, dimpho@dmluxe.co.za";
    $subject = "New Luxury Travel Booking Request - DM Luxe Voyages";
    
    // Email headers
    $headers = "From: bookings@dmluxe.co.za\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    
    // Email body (your existing email template)
    $message = "
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: #0d6efd; color: white; padding: 20px; text-align: center; }
            .section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
            .section-title { color: #0d6efd; border-bottom: 2px solid #0d6efd; padding-bottom: 10px; }
            .footer { background: #f8f9fa; padding: 15px; text-align: center; font-size: 12px; color: #666; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>New Luxury Travel Booking Request</h1>
                <p>DM Luxe Voyages</p>
            </div>
            
            <div class='section'>
                <h2 class='section-title'>Client Information</h2>
                <p><strong>Name:</strong> $first_name $last_name</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Phone:</strong> $phone</p>
                <p><strong>Nationality:</strong> $nationality</p>
                <p><strong>Passport Number:</strong> $passport</p>
            </div>
            
            <div class='section'>
                <h2 class='section-title'>Travel Details</h2>
                <p><strong>From:</strong> $from_location</p>
                <p><strong>To:</strong> $to_location</p>
                <p><strong>Departure Date:</strong> $departure_date</p>
                <p><strong>Return Date:</strong> $return_date</p>
                <p><strong>Purpose of Travel:</strong> $travel_purpose</p>
            </div>
            
            <div class='section'>
                <h2 class='section-title'>Travelers</h2>
                <p><strong>Adults:</strong> $adults</p>
                <p><strong>Children:</strong> $children</p>
                <p><strong>Infants:</strong> $infants</p>
            </div>
            
            <div class='section'>
                <h2 class='section-title'>Services Requested</h2>
                <p>$services</p>
                <p><strong>Budget Range:</strong> R$price_range</p>
            </div>
            
            <div class='section'>
                <h2 class='section-title'>Additional Information</h2>
                <p><strong>Dietary Restrictions:</strong> $dietary</p>
                <p><strong>Special Requests:</strong> $special_requests</p>
            </div>
            
            <div class='footer'>
                <p>This booking request was submitted through the DM Luxe Voyages website.</p>
                <p>Please contact the client within 24 hours to confirm booking details.</p>
            </div>
        </div>
    </body>
    </html>
    ";
    
    // Send email and handle response
    handleEmailSending($to, $subject, $message, $headers, $email, $first_name, $last_name, 'main');
}

function processTourBooking() {
    // Process tour-specific booking form
    $travel_date = isset($_POST['travel-date']) ? htmlspecialchars($_POST['travel-date']) : 'Not specified';
    $travelers = isset($_POST['travelers']) ? htmlspecialchars($_POST['travelers']) : 'Not specified';
    $name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : 'Not specified';
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : 'Not specified';
    $phone = isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : 'Not specified';
    $message = isset($_POST['message']) ? htmlspecialchars($_POST['message']) : 'None';
    $tour_name = isset($_POST['tour_name']) ? htmlspecialchars($_POST['tour_name']) : 'Specific Tour';
    
    // Email configuration
    $to = "bookings@dmluxe.co.za, dimpho@dmluxe.co.za";
    $subject = "New Tour Booking Request - $tour_name - DM Luxe Voyages";
    
    // Email headers
    $headers = "From: bookings@dmluxe.co.za\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    
    // Email body for tour booking
    $message = "
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: #0d6efd; color: white; padding: 20px; text-align: center; }
            .section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
            .section-title { color: #0d6efd; border-bottom: 2px solid #0d6efd; padding-bottom: 10px; }
            .footer { background: #f8f9fa; padding: 15px; text-align: center; font-size: 12px; color: #666; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>New Tour Booking Request</h1>
                <p>$tour_name - DM Luxe Voyages</p>
            </div>
            
            <div class='section'>
                <h2 class='section-title'>Tour Details</h2>
                <p><strong>Tour:</strong> $tour_name</p>
                <p><strong>Preferred Travel Date:</strong> $travel_date</p>
                <p><strong>Number of Travelers:</strong> $travelers</p>
            </div>
            
            <div class='section'>
                <h2 class='section-title'>Client Information</h2>
                <p><strong>Name:</strong> $name</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Phone:</strong> $phone</p>
            </div>
            
            <div class='section'>
                <h2 class='section-title'>Special Requests & Questions</h2>
                <p>$message</p>
            </div>
            
            <div class='footer'>
                <p>This tour booking request was submitted through the DM Luxe Voyages website.</p>
                <p>Please contact the client within 24 hours to confirm booking details.</p>
            </div>
        </div>
    </body>
    </html>
    ";
    
    // Send email and handle response
    handleEmailSending($to, $subject, $message, $headers, $email, $name, '', 'tour');
}

function handleEmailSending($to, $subject, $message, $headers, $client_email, $client_name, $client_last_name = '', $type = 'main') {
    // Send email to admin
    if (mail($to, $subject, $message, $headers)) {
        // Send confirmation email to client
        sendClientConfirmation($client_email, $client_name, $client_last_name, $type);
        
        // Return success response
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            echo json_encode(['status' => 'success', 'message' => 'Thank you for your booking request! We will contact you within 24 hours.']);
        } else {
            header("Location: booking-success.html");
        }
        exit();
    } else {
        // Return error response
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            echo json_encode(['status' => 'error', 'message' => 'Sorry, there was an error processing your request. Please try again.']);
        } else {
            header("Location: booking-error.html");
        }
        exit();
    }
}

function sendClientConfirmation($email, $first_name, $last_name = '', $type = 'main') {
    $full_name = $last_name ? "$first_name $last_name" : $first_name;
    $subject = "Thank You for Your Booking Request - DM Luxe Voyages";
    
    $message = "
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
                <h1>Thank You for Your Booking Request</h1>
            </div>
            
            <div class='content'>
                <p>Dear $full_name,</p>
                
                <p>Thank you for choosing DM Luxe Voyages for your luxury travel experience. We have received your booking request and our team is reviewing it.</p>
                
                <p>Our luxury travel consultant will contact you within 24 hours to discuss your itinerary and provide you with a personalized quote.</p>
                
                <p>If you have any immediate questions, please don't hesitate to contact us:</p>
                <p>Phone: +27 72 369 9937<br>
                Email: info@dmdeluxevoyages.co.za</p>
                
                <p>We look forward to crafting your perfect journey!</p>
                
                <p>Warm regards,<br>
                The DM Luxe Voyages Team</p>
            </div>
            
            <div class='footer'>
                <p>DM Luxe Voyages | Luxury Travel Experiences</p>
                <p>South Africa | +27 72 369 9937 | bookings@dmluxe.co.za</p>
            </div>
        </div>
    </body>
    </html>
    ";
    
    $client_headers = "From: bookings@dmluxe.co.za\r\n";
    $client_headers .= "Reply-To: bookings@dmluxe.co.za\r\n";
    $client_headers .= "MIME-Version: 1.0\r\n";
    $client_headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    
    mail($email, $subject, $message, $client_headers);
}
?>