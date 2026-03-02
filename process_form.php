<?php
// process_form.php - Handles form submission and redirects to success.html

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get form data (sanitize for security)
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars($_POST['subject'] ?? '');
    $message = htmlspecialchars($_POST['message'] ?? '');
    
    // Basic validation
    $errors = [];
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address";
    }
    
    if (empty($subject)) {
        $errors[] = "Subject is required";
    }
    
    if (empty($message)) {
        $errors[] = "Message is required";
    }
    
    // If no errors, process the form
    if (empty($errors)) {
        
        // OPTIONAL: Save to database (if you have database.sql)
        /*
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "your_database_name";
        
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        $stmt = $conn->prepare("INSERT INTO contacts (email, subject, message, submitted_at) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("sss", $email, $subject, $message);
        $stmt->execute();
        $stmt->close();
        $conn->close();
        */
        
        // OPTIONAL: Send email
        /*
        $to = "admin@tupoucollege.com";
        $headers = "From: " . $email . "\r\n";
        $headers .= "Reply-To: " . $email . "\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();
        
        mail($to, $subject, $message, $headers);
        */
        
        // Redirect to success.html
        header("Location: success.html");
        exit();
        
    } else {
        // If there are errors, redirect back to form with error messages
        $error_string = implode(", ", $errors);
        header("Location: index.html?error=" . urlencode($error_string));
        exit();
    }
    
} else {
    // If someone tries to access this file directly without POST
    header("Location: index.html");
    exit();
}
?>