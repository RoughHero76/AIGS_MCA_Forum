<?php
include 'partials/_dbconnect.php';
include 'partials/_header.php';
?>
<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">


<?php
if(!isset($_SESSION['loggedin'])){
    echo '
        <div class="container">
        <h1 class="py-2">ERROR</h1> 
           <p class="lead">You are not logged in. </p>
        </div>
        ';
    die();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sno = $_SESSION['sno'];
    $fullName = $_POST['fullname'];
    $userName = $_POST['username'];
    $password = $_POST['password'];

    // Update the user's profile in the database
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "UPDATE users SET fullname='$fullName', username='$userName', user_pass='$hash' WHERE sno='$sno'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Profile updated successfully
        $_SESSION['fullname'] = $fullName;
        $_SESSION['username'] = $userName;

        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Profile updated successfully!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
              </div>';
    } else {
        // Error updating profile
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                Error updating profile. Please try again later. '. mysqli_error($conn) .'
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
              </div>';
    }
}

$sno = $_SESSION['sno'];
$sql = "SELECT * FROM users WHERE sno='$sno'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$fullName = $row['fullname'];
$userName = $row['username'];
?>

<!doctype html>
<html lang="en">

<head>
    
    <title>Welcome to AIGS MCA</title>

    <style>
    body {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    main {
        flex: 1;
    }
    </style>
</head>

<body>
   

    <main>
        <?php 
        /* if(!isset($_SESSION['loggedin'])){
            echo '
                <div class="container">
                <h1 class="py-2">ERROR</h1> 
                   <p class="lead">You are not logged in. </p>
                </div>
                ';
            die();
        } */
        
        // Retrieve the user's profile picture from the database
        $sno = $_SESSION['sno'];
        $sql = "SELECT profile_pic FROM users WHERE sno='$sno'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $profilePic = $row['profile_pic'];
        if(empty($profilePic)) {
            // Set a default profile picture
            $defaultProfilePic = 'imgs/userdefault.png';
            $profilePic = $defaultProfilePic;
        }
        ?>

        <div class="container">
            <h1>Edit Profile</h1>
            <hr>
            <div class="row">
                <!-- left column -->
                <div class="col-md-3">
                    <div class="text-center">
                        <form action="uploadProfilePic.php" method="post" enctype="multipart/form-data">
                            <div class="text-center">
                                <?php echo '<img src="'.$profilePic.'" class="avatar img-fluid rounded-circle img-fluid" alt="avatar">' ?>
                                <h6>Upload a different photo...</h6>
                                <input type="file" class="form-control" name="profile_pic">
                                <input type="hidden" name="sno" value="<?php echo $sno; ?>">
                                <input type="submit" class="btn btn-primary" value="Upload Picture">
                            </div>
                        </form>
                    </div>
                </div>
                <!-- edit form column -->
                <div class="col-md-9 personal-info">
                    <div class="alert alert-info alert-dismissable">
                        <a class="panel-close close" data-dismiss="alert">×</a>
                        <i class="fa fa-coffee"></i>
                        <strong>You cannot change your email </strong> Once email provided by college is verified it
                        cannot
                        be changed again.
                    </div>
                    <h3>Personal info</h3>

                    <form class="form-horizontal" role="form" method="post">
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Full name:</label>
                            <div class="col-lg-8">
                                <input class="form-control" type="text" name="fullname" value="<?php echo $fullName; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Username:</label>
                            <div class="col-md-8">
                                <input class="form-control" type="text" name="username" value="<?php echo $userName; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Password:</label>
                            <div class="col-md-8">
                                <input class="form-control" type="password" name="password" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                <a href="Profile.php" class="btn btn-danger ml-2">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <?php include 'partials/_footer.php';?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>
</head>