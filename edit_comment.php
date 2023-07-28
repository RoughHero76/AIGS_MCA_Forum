<?php
include 'partials/_dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $commentId = $_POST['commentid'];
    $newContent = $_POST['new_content'];

    // Update the comment in the database
    $sql = "UPDATE `comments` SET `comment_content`='$newContent' WHERE `comment_Id`='$commentId'";
    
    // Debug: Print the SQL query
   /*  echo "SQL query: " . $sql . "<br>"; */

    $result = mysqli_query($conn, $sql);
    if ($result) {
        // Comment updated successfully
        header("Location: thread.php?threadid=".$_POST['threadid']);
        exit();
    } else {
        // Error updating comment
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Failed to update comment. Please try again later.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>';
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $commentId = $_GET['commentid'];

    // Fetch the existing comment content from the database
    $sql = "SELECT `comment_content` FROM `comments` WHERE `comment_Id`='$commentId'";
    
    // Debug: Print the SQL query
    /* echo "SQL query: " . $sql . "<br>"; */

    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $oldContent = $row['comment_content'];
    } else {
        // Comment not found in the database
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Comment not found. Please try again later.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>';
        exit();
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>Edit Comment</title>
    <style>
    .container{
      min-height: 77.6vh;
    }
    </style>
</head>

<body>
    <?php include 'partials/_header.php'; ?>

    <div class="container my-4">
        <h1>Edit Comment</h1>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <input type="hidden" name="commentid" value="<?php echo $_GET['commentid']; ?>">
            <input type="hidden" name="threadid" value="<?php echo $_GET['threadid']; ?>">
            <div class="form-group">
                <label for="new_content">New Content</label>
                <textarea class="form-control" id="new_content" name="new_content" rows="3" required><?php echo $oldContent; ?></textarea>
           
            </div>
            <button type="submit" class="btn btn-primary">Update Comment</button>
        </form>
    </div>

    <?php include 'partials/_footer.php'; ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
    </script>
</body>

</html>
