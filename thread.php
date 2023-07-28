<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <style>
    #ques {
        min-height: 433px;
    }
    </style>
    <title>Welcome to Acharya Forum - Coding Forums</title>
</head>

<body>
    <?php include "partials/_dbconnect.php"; ?>
    <?php include "partials/_header.php"; ?>
    <?php
    $id = $_GET["threadid"];
    $sql = "SELECT * FROM `threads` WHERE thread_id = $id";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $title = $row["thread_title"];
        $desc = $row["thread_desc"];
        $thread_user_id = $row["thread_user_id"];
        // Query the users table to find out the name of OP
        $sql2 = "SELECT username FROM `users` WHERE sno='$thread_user_id'";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result2);
        $posted_by = $row2["username"];
        // Query the users table to find out the profile picture of the OP
        $sql3 = "SELECT profile_pic FROM `users` WHERE sno='$thread_user_id'";
        $result3 = mysqli_query($conn, $sql3);
        $row3 = mysqli_fetch_assoc($result3);
        $profilePic = $row3["profile_pic"];
    }
    ?>

    <?php
include 'partials/_dbconnect.php';

$badWords = array("badword1", "badword2", "badword3");

$showAlert = false;
$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
    $comment = $_POST['comment'];
    $sno = $_POST['sno'];

    // Check for empty or whitespace comment
    if (empty(trim($comment))) {
        $showAlert = 'Comment cannot be empty.';
    }
    // Check for bad words in the comment
    else {
        $isBadWord = false;
        foreach ($badWords as $badWord) {
            if (stripos($comment, $badWord) !== false) {
                $isBadWord = true;
                break;
            }
        }

        if ($isBadWord) {
            $showAlert = 'Unable to post your comment. Your comment contains inappropriate content.';
        } else {
            // Insert comment into the database
            $comment = mysqli_real_escape_string($conn, $comment);
            $sql = "INSERT INTO `comments` ( `comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ( '$comment', '$id', '$sno', CURRENT_TIMESTAMP())";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                $showAlert = true;
            } else {
                $showAlert = 'Error posting comment. Please try again later. Error: ' . mysqli_error($conn);
            }
        }
    }
}

?>

    <?php if ($showAlert === true) { ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Your Comment was Posted Successfully!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php } else if ($showAlert !== false) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> <?php echo $showAlert; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php } ?>

    <?php
    // Function to wrap content based on word boundaries
function wrapContent($content, $maxLength) {
    $words = explode(' ', $content);
    $wrappedContent = '';
    $lineLength = 0;

    foreach ($words as $word) {
        $wordLength = strlen($word);
        $lineLength += $wordLength;

        if ($lineLength <= $maxLength) {
            $wrappedContent .= $word . ' ';
            $lineLength++; // Account for the space between words
        } else {
            $wrappedContent .= '<br>' . $word . ' ';
            $lineLength = $wordLength + 1;
        }
    }

    return rtrim($wrappedContent);
}
      
    ?>

 <!-- Category container starts here -->
<div class="container my-4">
    <div class="jumbotron">
        <h1 class="display-4"><?php echo $title; ?></h1>
        <hr class="my-4">
        <div class="thread-content">
            <?php echo '<pre>'.wrapContent($desc, 80).'</pre>'; ?>
        </div>
        <?php echo '<img class="mr-3 rounded-circle img-fluid" src="' .
        $profilePic .
        '" width="64px" alt="Profile Picture">
        <p class="text-muted my-0">Posted by: '.$posted_by.'</p>'; 
        ?>
    </div>
</div>


    </div>
    </div>
    <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
        echo '<div class="container">
        <h1 class="py-2">Post a Comment</h1> 
        <form action="' .
            $_SERVER["REQUEST_URI"] .
            '" method="post"> 
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Type your comment</label>
                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                <input type="hidden" name="sno" value="' .
            $_SESSION["sno"] .
            '">
            </div>
            <button type="submit" class="btn btn-success">Post Comment</button>
        </form> 
    </div>';
    } else {
        echo '   
        <div class="container">
        <h1 class="py-2">Post a Comment</h1> 
           <p class="lead">You are not logged in. Please login to be able to post comments.</p>
        </div>
        ';
    } ?>
    <!-- showing comments from db -->

    <div class="container" id="ques">
    <h1 class="py-2">Discussion</h1>

    <?php
    $id = $_GET["threadid"];
    $threadId = $_GET['threadid'];
    $sql = "SELECT * FROM `comments` WHERE thread_id=$id";
    $result = mysqli_query($conn, $sql);
    $noResult = true;
    while ($row = mysqli_fetch_assoc($result)) {
        $noResult = false;
        $commentId = $row["comment_Id"];
        $content = $row["comment_content"];
        $comment_time = $row["comment_time"];
        $comment_by = $row["comment_by"];
        $sql2 = "SELECT username FROM `users` WHERE sno='$comment_by'";
	    $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result2);
        $username = $row2["username"];
        // Query the users table to find out the profile picture of the user who commented
        $sql3 = "SELECT profile_pic FROM `users` WHERE sno='$comment_by'";
        $result3 = mysqli_query($conn, $sql3);
        $row3 = mysqli_fetch_assoc($result3);
        $profilePic = $row3["profile_pic"];

        // If the user doesn't have a profile picture, use a default image
        if (empty($profilePic)) {
            $profilePic = "imgs/userdefault.png";
        }



// Rest of your code...

echo '<div class="card my-3">
        <div class="card-body">
            <div class="media">
                <img class="mr-3 rounded-circle img-fluid" src="'.$profilePic.'" width="64px" alt="Profile Picture">
                <div class="media-body">
                    <p class="font-weight-bold my-0">'.$username.'</p>
                    <pre>'.wrapContent($content, 100).'</pre>
                    <p class="text-muted my-0">Posted by: '.$username.' On '.$comment_time.'</p>
                </div>
            </div>
        </div>';

       // Debugging Options to check if user is admin or owner of the said
       /* var_dump($_SESSION['loggedin']);
       var_dump($_SESSION['is_admin']);  */

    // Check if the logged-in user is the owner of the comment or an admin
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $_SESSION['sno'] == $comment_by) {
        echo '<div class="card-footer">
            <a href="edit_comment.php?commentid='.$commentId.'&threadid='.$id.'" class="btn btn-primary btn-sm">Edit</a>
            <a href="delete_comment.php?commentid='.$commentId.'&threadid='.$id.'" class="btn btn-danger btn-sm">Delete</a>
        </div>';
    } else if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true &&
($_SESSION['sno'] == $comment_by || (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1))) {
echo '<div class="card-footer">
    <a href="delete_comment.php?commentid='.$commentId.'&threadid='.$id.'" class="btn btn-danger btn-sm">Delete</a>
</div>';
}

        echo '</div>';
    }

    if ($noResult) {
        echo '<div class="jumbotron jumbotron-fluid">
            <div class="container">
                <p class="display-4">No Comments Found</p>
                <p class="lead">Be the First Person To Comment.</p>
            </div>
        </div>';
    }
    ?>
    

</div>
    <?php include "partials/_footer.php"; ?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
    </script>
</body>

</html>
