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
    <?php include 'partials/_dbconnect.php';?>
    <?php include 'partials/_header.php';?>

    <?php
    function getRegisteredMemberCount($conn)
    {
        $sql = "SELECT COUNT(sno) as count FROM users";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row['count'];
    }

    function getQuestionsAsked($conn)
    {
        $sql = "SELECT COUNT(thread_id) as count FROM threads";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row['count'];
    }

    function getTotalComments($conn)
    {
        $sql = "SELECT COUNT(comment_id) as count FROM comments";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row['count'];
    }

    function getRegisteredUsers($conn)
    {
        $sql = "SELECT username FROM users";
        $result = mysqli_query($conn, $sql);
        $users = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $users[] = $row['username'];
        }
        return $users;
    }

    function getQuestions($conn)
    {
        $sql = "SELECT thread_title FROM threads";
        $result = mysqli_query($conn, $sql);
        $questions = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $questions[] = $row['thread_title'];
        }
        return $questions;
    }

    function getComments($conn)
    {
        $sql = "SELECT comment_content FROM comments";
        $result = mysqli_query($conn, $sql);
        $comments = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $comments[] = $row['comment_content'];
        }
        return $comments;
    }
    ?>

    <main>
        <div class="container" id="ques">
            <h1 style="font-weight: bold" class="py-4">About</h1>
            <div class="accordion" id="accordionExample">
                <h3>Currently Registered Users: <?php echo getRegisteredMemberCount($conn); ?></h3>
                <h3>Total Number of Questions Asked: <?php echo getQuestionsAsked($conn); ?></h3>
                <h3>Total Number of Comments/Answers: <?php echo getTotalComments($conn); ?></h3>
                <br>
                <br>
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="button"
                                data-toggle="collapse" data-target="#collapseOne" aria-expanded="false"
                                aria-controls="collapseOne">
                                Registered Users Name
                            </button>
                        </h2>
                    </div>
                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                        <div class="card-body">
                            <?php
                            $registeredUsers = getRegisteredUsers($conn);
                            if (count($registeredUsers) > 0) {
                                echo '<ul>';
                                foreach ($registeredUsers as $user) {
                                    echo '<li>' . $user . '</li>';
                                    echo ' <br></br> <!-- Add space here -->';
                                }
                                echo '</ul>';
                            } else {
                                echo 'No registered users found.';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="button"
                                data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
                                aria-controls="collapseTwo">
                                Questions Asked
                            </button>
                        </h2>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                        <div class="card-body">
                            <?php
                            $questions = getQuestions($conn);
                            if (count($questions) > 0) {
                                echo '<ul>';
                                foreach ($questions as $question) {
                                    echo '<li>' . $question . '</li>';
                                    echo ' <br></br> <!-- Add space here -->';
                                }
                                echo '</ul>';
                            } else {
                                echo 'No questions found.';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingThree">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="button"
                                data-toggle="collapse" data-target="#collapseThree" aria-expanded="false"
                                aria-controls="collapseThree">
                                Comments/Answers
                            </button>
                        </h2>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                        data-parent="#accordionExample">
                        <div class="card-body">
                            <?php
                         $comments = getComments($conn);
                         if (count($comments) > 0) {
                             echo '<ul>';
                             foreach ($comments as $comment) {
                                 echo '<li>' . $comment . '</li>';
                                 echo ' <br></br> <!-- Add space here -->';
                             }
                             echo '</ul>';
                         } else {
                             echo 'No comments found.';
                         }
                         ?>
                        </div>
                    </div>
                </div>
            </div>
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

</body>

</html>