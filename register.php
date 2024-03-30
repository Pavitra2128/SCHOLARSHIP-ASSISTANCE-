<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Your existing code for form data collection
    $firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
    $lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $mobileNumber = isset($_POST['mobileNumber']) ? $_POST['mobileNumber'] : '';
    $school = isset($_POST['school']) ? $_POST['school'] : '';
    $major = isset($_POST['major']) ? $_POST['major'] : '';
    $currentGPA = isset($_POST['currentGPA']) ? $_POST['currentGPA'] : '';
    $prevYearCGPA = isset($_POST['prevYearCGPA']) ? $_POST['prevYearCGPA'] : '';
    $reason = isset($_POST['reason']) ? $_POST['reason'] : '';
    $photo = isset($_FILES['photo']['name']) ? $_FILES['photo']['name'] : '';
    $incomeCertificate = isset($_FILES['incomeCertificate']['name']) ? $_FILES['incomeCertificate']['name'] : '';
    $institution = isset($_POST['institution']) ? $_POST['institution'] : '';
    $stream = isset($_POST['stream']) ? $_POST['stream'] : '';
    $state = isset($_POST['state']) ? $_POST['state'] : '';
    $district = isset($_POST['district']) ? $_POST['district'] : '';
    $passingYear = isset($_POST['passingYear']) ? $_POST['passingYear'] : '';
    $marksObtained = isset($_POST['marksObtained']) ? $_POST['marksObtained'] : '';
    $totalMarks = isset($_POST['totalMarks']) ? $_POST['totalMarks'] : '';
    $applicationReason = isset($_POST['applicationReason']) ? $_POST['applicationReason'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';

    // Your existing code for file uploads
    $photoDestination = 'uploads/' . $photo;
    $incomeCertificateDestination = 'uploads/' . $incomeCertificate;
    move_uploaded_file($_FILES['photo']['tmp_name'], $photoDestination);
    move_uploaded_file($_FILES['incomeCertificate']['tmp_name'], $incomeCertificateDestination);

    // Database connection
    $con = new mysqli("localhost", "root", "", "project");
    if ($con->connect_error) {
        die("Failed to connect: " . $con->connect_error);
    }

    // Prepare and execute SQL query with placeholders
    $stmt = $con->prepare("INSERT INTO register (firstName, lastName, email, mobileNumber, school, major, currentGPA, prevYearCGPA, reason, photo, incomeCertificate, institution, stream, state, district, passingYear, marksObtained, totalMarks, applicationReason, password, gender) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Bind parameters
    $stmt->bind_param("sssisssssssssssiiisss", $firstName, $lastName, $email, $mobileNumber, $school, $major, $currentGPA, $prevYearCGPA, $reason, $photoDestination, $incomeCertificateDestination, $institution, $stream, $state, $district, $passingYear, $marksObtained, $totalMarks, $applicationReason, $password, $gender);

    if ($stmt->execute()) {
        echo "Application submitted successfully!";
        header("Location: home.html"); // Redirect to a success page
        exit();
    } else {
        echo "Error submitting application: " . $stmt->error;
    }

    $stmt->close();
    $con->close();
} else {
    echo "Invalid request.";
}
?>
