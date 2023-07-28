<?php
session_start();
if (isset($_POST['sno'])) {
    $sno = $_POST['sno'];
    echo "sno: " . $sno;
} else {
    echo "sno not set";
}

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    if (isset($_POST['sno'])) {
        $sno = $_POST['sno'];
        $profile_pic = $_FILES['profile_pic'];
        // Check if a file is selected
        if (!empty($profile_pic['name'])) {
            // Directory where the profile pictures will be stored
            $target_dir = "profile_pics/";

            // Generate a unique file name for the profile picture
            $file_extension = strtolower(pathinfo($profile_pic['name'], PATHINFO_EXTENSION));
            $file_name = uniqid() . '_' . time() . '.' . $file_extension;
            /* $file_name = $sno . '.'.$file_extension; */
            $target_file = $target_dir . $file_name;

            // Move the uploaded file to the target directory
            if (move_uploaded_file($profile_pic['tmp_name'], $target_file)) {
                // Database update logic
                // Establish a database connection
                $conn = mysqli_connect("localhost", "root", "", "idiscuss");
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                // Update the user's profile picture in the database
                $sql = "UPDATE users SET profile_pic='$target_file' WHERE sno='$sno'";
                if (mysqli_query($conn, $sql)) {
                    echo "Profile picture uploaded successfully.";

                    // Redirect back to profileEdit.php
                    header("Location: profileEdit.php");
                    exit();
                    
                } else {
                    echo "Failed to update profile picture. Please try again: " . mysqli_error($conn);
                    
                    
                }

                // Close the database connection
                mysqli_close($conn);
            } else {
                // Failed to move the uploaded file
                echo "Failed to move the uploaded file.";
                echo "Upload Error: " . $_FILES['profile_pic']['error'];
            }
        } else {
            // No file selected
            echo "Please select a profile picture.";
        }
    } else {
        // Invalid user ID
        echo "Invalid user ID.";
    }
} else {
    // User not logged in
    echo "User not logged in. Please log in to update the profile picture.";
}
?>