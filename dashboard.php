<?php
require 'vendor/autoload.php'; // Include Composer's autoloader

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Check if the JWT cookie is set
if (isset($_COOKIE['jwt'])) {
    // Get the JWT token from the cookie
    $jwt = $_COOKIE['jwt'];

    try {
        // Decode the JWT token
        $decoded = JWT::decode($jwt, new Key($_ENV['JWT_SECRET_KEY'], 'HS256'));

        // Extract the user_id from the decoded token
        $user_id = $decoded->user_id;

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

        // Prepare and execute SQL statement to retrieve vegetables based on user_id
        $stmt = $conn->prepare("SELECT * FROM vegetables WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if there are vegetables for the user
        if ($result->num_rows > 0) {
            // Output vegetables
            echo "<h2>Vegetables</h2>";
            echo "<ul>";
            while ($row = $result->fetch_assoc()) {
                echo "<li>" . $row["name"] . "</li>";
            }
            echo "</ul>";
        } else {
            echo "No vegetables found for this user.";
        }

        // Close database connection
        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        // JWT validation failed or expired, redirect to the login page
        header("Location: index.html");
        exit;
    }
} else {
    // JWT cookie is not set, redirect to the login page
    header("Location: index.html");
    exit;
}
?>
