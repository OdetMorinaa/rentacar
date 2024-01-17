<?php
// Connect to MySQL server (replace with your credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "admin_login";
$tbname = "user";

// Specify the port as an integer (e.g., 3306 is the default port for MySQL)
$port = 3306;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Valid credentials
$valid_username = "admin";
$valid_password = "jeton12";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve values from POST data
    $entered_username = $_POST["username"];
    $entered_password = $_POST["password"];

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO $tbname (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $entered_username, $entered_password);

    // Execute the statement
    if ($stmt->execute()) {
        // Check if entered credentials match the valid credentials
        if ($entered_username == $valid_username && $entered_password == $valid_password) {
            // Redirect to index.html on successful login
            header("Location: index.html");
            exit();
        } else {
            echo "Invalid username or password";
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

$conn->close();
?>
