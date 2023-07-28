<?php
include 'partials/_dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $commentId = $_GET['commentid'];
    $threadId = $_GET['threadid'];

    // Delete the comment from the database
    $sql = "DELETE FROM `comments` WHERE `comment_Id`='$commentId'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        // Comment deleted successfully
        echo '<script>window.location.href = "thread.php?threadid='.$threadId.'";</script>';
        exit();
    } else {
        // Error deleting comment
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Failed to delete comment. Please try again later.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>';
    }
}
?>
