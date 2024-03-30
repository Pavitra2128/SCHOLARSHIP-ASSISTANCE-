<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Students</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>List of Students</h1>

    <?php
    // Database connection
    $con = new mysqli("localhost", "root", "", "project");
    if ($con->connect_error) {
        die("Failed to connect: " . $con->connect_error);
    }

    // Fetch data from the register table
    $result = $con->query("SELECT id, firstName, lastName, mobileNumber, marksObtained FROM register");

    // Check if there are rows in the result
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<thead><tr><th>ID</th><th>Student Name</th><th>Mobile Number</th><th>Percentage</th></tr></thead>";
        echo "<tbody>";

        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td><td>" . $row["firstName"] . " " . $row["lastName"] . "</td><td>" . $row["mobileNumber"] . "</td><td>" . $row["marksObtained"] . "</td>";
            echo "</tr>";
        }

        echo "</tbody></table>";
    } else {
        echo "0 results";
    }

    // Close the database connection
    $con->close();
    ?>
</div>

</body>
</html>
