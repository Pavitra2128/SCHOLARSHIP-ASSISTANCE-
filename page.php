<?php
session_start();

// Initialize the error variable
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $mobileNumber = $_POST['mobileNumber'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $gender = $_POST['gender'];
    $role = $_POST['role'];

    $conn = new mysqli('localhost', 'root', '', 'project');
    if ($conn->connect_error) {
        die('Connection Failed : ' . $conn->connect_error);
    } else {
        // Check if email already exists in the database
        $checkEmailQuery = $conn->prepare("SELECT * FROM signup WHERE email = ?");
        $checkEmailQuery->bind_param("s", $email);
        $checkEmailQuery->execute();
        $result = $checkEmailQuery->get_result();

        if ($result->num_rows > 0) {
            // Email already exists, set the error message
            $error = "Email already exists. Please use a different email.";
        } else {
            // Email doesn't exist, proceed with the signup process

            $insertQuery = $conn->prepare("INSERT INTO signup (firstname, lastname, email, mobileNumber, password, confirmPassword, gender, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $insertQuery->bind_param("sssissss", $firstName, $lastName, $email, $mobileNumber, $password, $confirmPassword, $gender, $role);

            // Execute the statement
            $insertQuery->execute();

            // Close the statement
            $insertQuery->close();

            // Close the connection
            $conn->close();

            // Redirect based on user role
            if ($role === 'sponsor') {
                header("Location: dashboard.html");
            } elseif ($role === 'student') {
                header("Location: student.html");
            } else {
                // Handle other roles if needed
                header("Location: home.html");
            }
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f2f2f2;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
  }
  .signup-container {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 500px;
  }
  h2 {
    text-align: center;
    color: #333;
  }
  input[type="email"]{
    width: calc(50% - 5px);
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-sizing: border-box;
    outline: none;
  }
  input[type="text"]{
    width: calc(50% - 5px);
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-sizing: border-box;
    outline: none;
  }
  input[type="password"] {
    width: calc(50% - 5px);
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-sizing: border-box;
    outline: none;
  }
  input[type="tel"] {
    width: calc(50% - 5px);
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-sizing: border-box;
    outline: none;
  }
  input[type="radio"] {
    margin: 10px;
  }
 
  select {
    width: calc(50% - 5px);
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-sizing: border-box;
    outline: none;
  }
  input[type="submit"] {
    width: 100%;
    padding: 10px;
    margin-top: 10px;
    background-color: #4caf50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    outline: none;
  }
  input[type="submit"]:hover {
    background-color: #45a049;
  }
</style>
</head>
<body>
<div class="signup-container">
    <h2>Sign Up</h2>

    <!-- Display the error message if it's not empty -->
    <?php if (!empty($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form action="page.php" method="post">
        <input type="text" name="firstName" placeholder="First Name" required>
        <input type="text" name="lastName" placeholder="Last Name" required>
        <input type="text" name="email" placeholder="Email" required>
        <input type="tel" name="mobileNumber" placeholder="Mobile Number" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirmPassword" placeholder="Confirm Password" required>
        
        <div>
            <input type="radio" id="male" name="gender" value="male" required>
            <label for="male">Male</label>
            <input type="radio" id="female" name="gender" value="female" required>
            <label for="female">Female</label>
        </div>
        <div>
            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="student">Student</option>
                <option value="sponsor">Sponsor</option>
            </select>
        </div>
        <input type="submit" value="Sign Up">
    </form>
</div>
</body>
</html>