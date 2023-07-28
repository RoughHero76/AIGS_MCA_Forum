<?php
include 'partials/_dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $threadId = $_GET['threadid'];
    $catid = $_GET['catid'];

    // Delete the thread from the database
    $sql = "DELETE FROM `threads` WHERE `thread_id`='$threadId'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Thread deleted successfully
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Thread deleted successfully!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
              </div>';
        // Redirect back to the thread list with the catid parameter
        header("Location: threadlist.php?catid=$catid");
        exit();
    } else {
        // Error deleting thread
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                Error deleting thread. Please try again later.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
              </div>';
    }
} else {
    // Invalid request
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Invalid request. Please try again later.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
          </div>';
}
?>
