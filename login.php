<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $con = new mysqli("localhost", "root", "", "project");
    if ($con->connect_error) {
        die("Failed to connect: " . $con->connect_error);
    } else {
        $stmt = $con->prepare("SELECT * FROM signup WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt_result = $stmt->get_result();

        if ($stmt_result->num_rows > 0) {
            $data = $stmt_result->fetch_assoc();
            
            var_dump($data); 

            if ($password == $data['password']) {
                $_SESSION['email'] = $email;
                
    
                if ($data['role'] == 'sponsor') {
                    header("Location: dashboard.html"); 
                } elseif ($data['role'] == 'student') {
                    header("Location: student.html"); 
                } else {
                    echo "Invalid role"; 
                }
                
                exit();
            } else {
                echo "Invalid password";
            }
        } else {
            echo "Invalid email";
        }

        $stmt->close();
        $con->close();
    }
}
?>
