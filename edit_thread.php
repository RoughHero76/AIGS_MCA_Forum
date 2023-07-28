<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <title>Welcome to AIGS MCA - Coding Forums</title>
    <style>
    #ques {
        min-height: 400px;
    }

    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    main {
        flex: 1;
    }
    </style>
</head>

<body>
    <main>

    <?php
include 'partials/_dbconnect.php';
include 'partials/_header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $threadId = $_POST['threadid'];
    $threadTitle = $_POST['title'];
    $threadDesc = $_POST['desc'];

    // Update the thread in the database
    $sql = "UPDATE `threads` SET `thread_title`='$threadTitle', `thread_desc`='$threadDesc' WHERE `thread_id`='$threadId'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Fetch the category ID for redirection
        $sql = "SELECT thread_cat_id FROM `threads` WHERE thread_id='$threadId'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $catId = $row['thread_cat_id'];

        // Thread updated successfully
        echo '<script>window.location.href = "threadlist.php?catid=' . $catId . '";</script>';
        exit();
    } else {
        // Error updating thread
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                Error updating thread. Please try again later.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
              </div>';
    }
}

// Fetch the thread details
$threadId = $_GET['threadid'];
$sql = "SELECT * FROM `threads` WHERE thread_id='$threadId'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$threadTitle = $row['thread_title'];
$threadDesc = $row['thread_desc'];
?>

<!-- Display the thread details --> 
<div class="container">
    <h1><?php echo $threadTitle; ?></h1>
    <div class="jumbotron">
        <?php echo $threadDesc; ?>
    </div>
</div>

<!-- Edit form for the thread -->
<div class="container">
    <h1>Edit Thread</h1>
    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
        <input type="hidden" name="threadid" value="<?php echo $threadId; ?>">
        <div class="form-group">
            <label for="title">Thread Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo $threadTitle; ?>">
        </div>
        <div class="form-group">
            <label for="desc">Thread Description</label>
            <textarea class="form-control" id="desc" name="desc" rows="5"><?php echo $threadDesc; ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Thread</button>
        <a href="threadlist.php?catid=<?php echo $row['thread_cat_id']; ?>" class="btn btn-danger ml-2">Cancel</a>

    </form>
</div>



    </main>
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