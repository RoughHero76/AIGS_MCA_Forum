<?php
$showError = "false";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '_dbconnect.php';
    $user_email = $_POST['signupEmail'];
    $username = $_POST['signupUserName'];
    $pass = $_POST['signupPassword'];
    $cpass = $_POST['signupcPassword'];
    $fullname = $_POST['signupFullName'];
    $sem = $_POST['signupSem'];
    $USN = $_POST['signupUSN'];

    // Check whether this email exists
    $existSql = "SELECT * FROM `users` WHERE user_email = '$user_email'";
    $result = mysqli_query($conn, $existSql);
    $numRows = mysqli_num_rows($result);
    
    if (empty($user_email) || empty($pass)) {
        exit("Email and password must be filled out");
    } else if ($numRows > 0) {
        exit("Email already in use");
    } else {
        if ($pass == $cpass) {
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users` (`username`, `user_email`, `user_pass`, `fullname`, `usn`, `semester`, `timestamp`) VALUES ('$username', '$user_email', '$hash', '$fullname', '$USN', '$sem', current_timestamp())";
            
            // Debug the SQL query
            echo "SQL Query: " . $sql . "<br>";
            
            $result = mysqli_query($conn, $sql);

            if ($result) {
                $showAlert = true;
                header("Location: /forum/index.php?signupsuccess=true");
                exit();
            } else {
                // Error inserting data
                echo "Error: " . mysqli_error($conn) . "<br>";
            }
        } else {
            $showError = "Passwords do not match";
        }
    }
    header("Location: /forum/index.php?signupsuccess=false&error=$showError");
}
?>
