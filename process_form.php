<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web_project_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize Data
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    // Prepared SQL Statement (Prevents SQL Injection)
    $stmt = $conn->prepare("INSERT INTO contact_messages (user_email, subject_line, message_text) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email, $subject, $message);

    if ($stmt->execute()) {
        header("Location: success.html");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>
