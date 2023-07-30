<?php
$showError = "false";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '_dbconnect.php';
    $email = $_POST['loginEmail'];
    $pass = $_POST['loginPass'];

    $sql = "SELECT * FROM users WHERE user_email='$email'";
    $result = mysqli_query($conn, $sql);
    $numRows = mysqli_num_rows($result);
    if ($numRows == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($pass, $row['user_pass'])) {
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['sno'] = $row['sno'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['fullname'] = $row['fullname'];
            $_SESSION['usn'] = $row['usn'];
            $_SESSION['semester'] = $row['semester'];
            $_SESSION['useremail'] = $email;

            // Check if the 'is_admin' column exists in the $row array
            if (isset($row['is_admin'])) {
                $_SESSION['is_admin'] = $row['is_admin'];
            } else {
                $_SESSION['is_admin'] = 0; // Set a default value if 'is_admin' is not present
            }

            header("Location: /forum/index.php");
            exit();
        } else {
            $showError = "true";
        }
    } else {
        $showError = "true";
    }
}

// Display error message if the password doesn't match
if ($showError === "true") {
    echo "Wrong email or password. Please try again.";
}
?>
