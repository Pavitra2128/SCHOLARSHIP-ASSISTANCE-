<!-- admin_dashboard.php -->
<?php
session_start(); // Start the session to store user login status

// Check if the user is not logged in, redirect to the login page
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: admin_login.php");
    exit();
}

// Database connection
$con = new mysqli("localhost", "root", "", "project");
if ($con->connect_error) {
    die("Failed to connect: " . $con->connect_error);
}

// Fetch all documents from the database
$result = $con->query("SELECT * FROM register");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Add your styles for the admin dashboard here -->
</head>
<body>
    <h2>Admin Dashboard</h2>

    <!-- Display student documents -->
    <div id="documentContainer">
        <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div>";
                    echo "<p>Name: " . $row['firstName'] . " " . $row['lastName'] . "</p>";
                    echo "<p>Email: " . $row['email'] . "</p>";
                    // Add more fields as needed
                    echo "<p><a href='" . $row['photo'] . "' target='_blank'>View Photo</a></p>";
                    echo "<p><a href='" . $row['incomeCertificate'] . "' target='_blank'>View Income Certificate</a></p>";
                    // Add more document links as needed
                    echo "<hr>";
                    echo "</div>";
                }
            } else {
                echo "No documents found.";
            }

            // Close the database connection
            $con->close();
        ?>
    </div>
</body>
</html>
