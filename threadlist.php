
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
    <?php include 'partials/_dbconnect.php';?>
    <?php include 'partials/_header.php';?>
    <?php
        $id = $_GET['catid'];
        $sql = "SELECT * FROM `categories` WHERE category_id = $id";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)) {
            $catname = $row['category_name'];
            $catdesc = $row['category_description'];
        }
    ?>

    <?php
    // List of bad words to censor
    $badWords = array("badword1", "badword2", "badword3");

    $method = $_SERVER['REQUEST_METHOD'];
    $showAlert = false;

    if ($method == 'POST') {
        // Insert thread into db
        $th_title = $_POST['title'];
        $th_desc = $_POST['desc'];
        $sno = $_POST['sno'];

        // Check for empty fields or whitespace characters
        if (empty(trim($th_title)) || empty(trim($th_desc))) {
            echo '
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Please fill in all the fields.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>';
        } else {
            // Check for bad words in the title and description
            $isBadWord = false;
            foreach ($badWords as $badWord) {
                if (stripos($th_title, $badWord) !== false || stripos($th_desc, $badWord) !== false) {
                    $isBadWord = true;
                    break;
                }
            }

            if ($isBadWord) {
                echo '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Your post contains inappropriate content.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
            } else {
                // No empty fields or bad words found, insert the thread into the database
                $th_title = str_replace("<", "&lt;", $th_title);
                $th_title = str_replace(">", "&gt;", $th_title);
                $th_desc = str_replace("<", "&lt;", $th_desc);
                $th_desc = str_replace(">", "&gt;", $th_desc);

                $stmt = $conn->prepare("INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP())");
                $stmt->bind_param("ssii", $th_title, $th_desc, $id, $sno);

                if ($stmt->execute()) {
                    $showAlert = true;
                    echo '
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> Your Thread was Posted Successfully!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                } else {
                    $error = $stmt->error;
                    echo '
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> Unable to post your thread. Please try again later. Error: '.$error.'
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                }

                $stmt->close();
            }
        }
    }
    ?>

    <!-- Category container starts here -->
    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4">Welcome to <?php echo $catname;?> forum</h1>
            <p class="lead"> <?php echo $catname;?></p>
            <hr class="my-4">
            <p>
                This forum is for sharing knowledge with each other.
                This is a peer-to-peer platform to share and learn.</br>
                No Spam / Advertising / Self-promotion in the forums. ...</br>
                Do not post copyright-infringing material. ...</br>
                Do not post "offensive" posts, links, or images. ...</br>
                Do not cross-post questions. ...</br>
                Remain respectful of other members at all times.
            </p>
            <p class="lead">
                <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a>
            </p>
        </div>
    </div>

    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){ 
        echo '
        <div class="container">
            <h1 class="py-2">Start a Discussion</h1> 
            <form action="'. $_SERVER["REQUEST_URI"] . '" method="post">
                <div class="form-group">
                    <label for="exampleInputEmail1">Problem Title</label>
                    <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp" required>
                    <small id="emailHelp" class="form-text text-muted">Keep your title as short and crisp as possible</small>
                </div>
                <input type="hidden" name="sno" value="'. $_SESSION["sno"]. '">
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Elaborate Your Concern</label>
                    <textarea class="form-control" id="desc" name="desc" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>';
    } else {
        echo '
        <div class="container">
            <h1 class="py-2">Start a Discussion</h1>
            <p class="lead">You are not logged in. Please login to be able to start a Discussion</p>
        </div>
            ';
            }
        ?>
            </div>
            <!-- ...existing code... -->
        
            <div class="container" id="ques">
            <h1 class="py-2">Browse Questions</h1>
        
            <?php
            $id = $_GET['catid'];
            $sql = "SELECT * FROM `threads` WHERE thread_cat_id=$id";
            $result = mysqli_query($conn, $sql);
            $noResult = true;
            while ($row = mysqli_fetch_assoc($result)) {
                $noResult = false;
                $id = $row['thread_id'];
                $title = $row['thread_title'];
                $desc = $row['thread_desc'];
                $thread_time = $row['timestamp'];
                $thread_user_id = $row['thread_user_id'];
                $sql2 = "SELECT username, profile_pic FROM `users` WHERE sno='$thread_user_id'";
                $result2 = mysqli_query($conn, $sql2);
                $row2 = mysqli_fetch_assoc($result2);
                $username = $row2['username'];
                $profilePic = $row2['profile_pic'];
        
                // If the user doesn't have a profile picture, use a default image
                if (empty($profilePic)) {
                    $profilePic = 'imgs/userdefault.png';
                }
        
                echo '<div class="card my-3">
                    <div class="card-body">
                        <div class="media">
                            <img class="mr-3 rounded-circle img-fluid" src="'.$profilePic.'" width="50" height="50" alt="Profile Picture">
                            <div class="media-body">
                                <h5 class="mt-0" style="margin-bottom: 10px;">
                                    <a class="text-dark" href="thread.php?threadid='.$id.'">'.$title.' </a>
                                </h5>
                                <span class="d-inline-block text-truncate" style="max-width: 500px;">'.$desc.'</span> 
                                <p class="text-muted my-0">Posted by: '.$username.' On '.$thread_time.'</p>
                                <div class="collapse" id="collapse-'.$id.'">
                                    <p class="mt-3">
                                        Additional details and discussions related to this thread can be found by following the link above.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    ';
        
                // Check if the logged-in user is the author of the thread
                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $_SESSION['sno'] == $thread_user_id) {
                    echo '<div class="card-footer">
                        <a href="edit_thread.php?threadid=' . $id . '" class="btn btn-primary btn-sm">Edit</a>
                        <a href="delete_thread.php?threadid=' . $id . '&catid=' . $_GET['catid'] . '" class="btn btn-danger btn-sm">Delete</a>
                    </div>';
                }
                // Check if the logged-in user is an admin
                else if ((isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $_SESSION['sno'] == $thread_user_id) || (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1)) {
                    echo '<div class="card-footer">
                        <a href="delete_thread.php?threadid=' . $id . '&catid=' . $_GET['catid'] . '" class="btn btn-danger btn-sm">Delete</a>
                    </div>';
                }
                        echo '</div>';
                    }
        
                if ($noResult) {
                    echo '<div class="jumbotron jumbotron-fluid">
                            <div class="container">
                                <p class="display-4">No Threads Found</p>
                                <p class="lead">Be the First Person To Ask The Question.</p>
                            </div>
                        </div>';
                }
        ?>
    
    </div>  
<!-- ...remaining code... -->
<?php include 'partials/_footer.php';?>
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