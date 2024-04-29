<?php
require 'vendor/autoload.php'; // Include Composer's autoloader

use Firebase\JWT\JWT;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Database connection configuration using environment variables
$servername = $_ENV['DB_HOST'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];
$dbname = $_ENV['DB_NAME'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username and password from the form
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Prepare and execute SQL statement to retrieve user information based on username
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // User found, verify password
        $user = $result->fetch_assoc();
        if (password_verify($password, $user["password"])) {
            // Authentication successful, generate JWT
            $payload = [
                "user_id" => $user["id"],
                "username" => $user["username"],
                "exp" => time() + 3600 // Token expiration time (1 hour)
            ];
            $jwt = JWT::encode($payload, $_ENV['JWT_SECRET_KEY'], 'HS256');

            // Set JWT as a cookie (HTTP-only and secure)
            setcookie('jwt', $jwt, time() + 3600, '/', '', true, true);

            // Redirect to the dashboard or home page
            header("Location: dashboard.php");
            exit;
        }
    }

    // Authentication failed, redirect back to the login page with error message
    header("Location: index.html?error=1");
    exit;
} else {
    // If the form is not submitted, redirect to the login page
    header("Location: index.html");
    exit;
}

// Close database connection
$stmt->close();
$conn->close();
?>
