<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Welcome to AIGS MCA</title>
</head>

<body>
    <?php include "partials/_dbconnect.php"; ?>
    <?php include "partials/_header.php"; ?>
    <?php
    if (!isset($_SESSION["loggedin"])) {
        echo '
            <div class="container">
            <h1 class="py-2">ERROR</h1> 
               <p class="lead">You are not logged in. </p>
            </div>
            ';
        die();
    }

    // Retrieve the user's profile picture from the database
    $sno = $_SESSION["sno"];
    $sql = "SELECT profile_pic FROM users WHERE sno='$sno'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $profilePic = $row["profile_pic"];
    if (empty($profilePic)) {
        // Set a default profile picture
        $defaultProfilePic = "imgs/userdefault.png";
        $profilePic = $defaultProfilePic;
    }
    ?>

    <section style="background-color: #eee;">
        <!--   <div class="container py-5">
    <div class="row">
      <div class="col">
        <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-4">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">User</a></li>
            <li class="breadcrumb-item active" aria-current="page">User Profile</li>
          </ol>
        </nav>
      </div>
    </div> -->

        <div class="row">
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <?php echo '<img src="' .
                            $profilePic .
                            '" class="rounded-circle img-fluid"  style="width: 300px; height: 250px ">'; ?>
                        <!-- <img src="imgs/userdefault.png" alt="avatar" class="rounded-circle img-fluid" style="width: 150px;"> -->
                        <?php echo '<h5 class="my-3">' .
                            $_SESSION["username"] .
                            "</h5>"; ?>
                        <p class="text-muted mb-1">Full Stack Developer</p>
                        <p class="text-muted mb-4">Soldev, Acharya College</p>
                        <div class="d-flex justify-content-center mb-2">
                            <button type="button" class="btn btn-outline-primary mr-1">Follow</button>
                            <a href="profileEdit.php" class="btn btn-outline-primary"> Edit Profile </a>
                        </div>
                    </div>
                </div>
                <div class="card mt-3">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <h6 class="align-items-center"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-globe mr-2 icon-inline">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="2" y1="12" x2="22" y2="12"></line>
                                    <path
                                        d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z">
                                    </path>
                                </svg>Website</h6>

                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-github mr-2 icon-inline">
                                    <path
                                        d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22">
                                    </path>
                                </svg>Github</h6>

                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-twitter mr-2 icon-inline text-info">
                                    <path
                                        d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z">
                                    </path>
                                </svg>Twitter</h6>

                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-instagram mr-2 icon-inline text-danger">
                                    <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                    <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                    <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                                </svg>Instagram</h6>

                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-facebook mr-2 icon-inline text-primary">
                                    <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                                </svg>Facebook</h6>

                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Full Name</p>
                            </div>
                            <div class="col-sm-9">
                                <?php echo '<p class="text-muted mb-0">' .
                                    $_SESSION["fullname"] .
                                    "</p>"; ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Username</p>
                            </div>
                            <div class="col-sm-9">
                                <?php echo '<p class="text-muted mb-0">' .
                                    $_SESSION["username"] .
                                    "</p>"; ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Email</p>
                            </div>
                            <div class="col-sm-9">
                                <?php echo '<p class="text-muted mb-0">' .
                                    $_SESSION["useremail"] .
                                    "</p>"; ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">USN</p>
                            </div>
                            <div class="col-sm-9">
                                <?php echo '<p class="text-muted mb-0">' .
                                    $_SESSION["usn"] .
                                    "</p>"; ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Semester</p>
                            </div>
                            
                            <div class="col-sm-9">
                                <?php echo '<p class="text-muted mb-0">' .
                                    $_SESSION["semester"] .
                                    "</p>"; ?>
                                    
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row">
  <div class="col-md-6">
    <div class="card mb-4 mb-md-0">
      <div class="card-body">
        <p class="mb-4">
          <span class="text-primary font-italic me-1"></span>
          <button class="btn btn-link text-decoration-none" onclick="toggleQuestions()">Questions Asked</button>
        </p>
        <div id="questionsContainer" style="display: none;">
          <!-- Display the questions here -->
          <?php
          // Fetch and display the questions
          $sno = $_SESSION["sno"];
          $threadsSql = "SELECT * FROM threads WHERE thread_user_id='$sno'";
          $threadsResult = mysqli_query($conn, $threadsSql);

          if ($threadsResult && mysqli_num_rows($threadsResult) > 0) {
              while ($row = mysqli_fetch_assoc($threadsResult)) {
                  // Display each question
                  // ...
                  echo '<div class="card mb-3">';
                  echo '<div class="card-body">';
                  
                  echo '<h5 class="card-title">'.$row["thread_title"]."</h5>";
                  echo '<p class="card-text">' . $row["thread_desc"] . "</p>";
                  echo "</div>";
                  echo "</div>";
              }
          } else {
              echo "No questions found.";
          }
          ?>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card mb-4 mb-md-0">
      <div class="card-body">
        <p class="mb-4">
          <span class="text-primary font-italic me-1"></span>
          <button class="btn btn-link text-decoration-none" onclick="toggleComments()">Comments</button>
        </p>
        <div id="commentsContainer" style="display: none;">
          <!-- Display the comments here -->
          <?php
          // Fetch and display the comments
          $commentsSql = "SELECT * FROM comments WHERE comment_by='$sno'";
          $commentsResult = mysqli_query($conn, $commentsSql);

          if ($commentsResult && mysqli_num_rows($commentsResult) > 0) {
              while ($row = mysqli_fetch_assoc($commentsResult)) {
                  // Display each comment
                  // ...
                  echo '<div class="card mb-3">';
                  echo '<div class="card-body">';
                  echo '<span class="d-inline-block text-truncate" style="max-width: 300px;" >' .$row["comment_content"] ."</span>"; 
                  echo "</div>";
                  echo "</div>";
              }
          } else {
              echo "No comments found.";
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function toggleQuestions() {
  var questionsContainer = document.getElementById('questionsContainer');
  if (questionsContainer.style.display === 'none') {
    questionsContainer.style.display = 'block';
  } else {
    questionsContainer.style.display = 'none';
  }
}

function toggleComments() {
  var commentsContainer = document.getElementById('commentsContainer');
  if (commentsContainer.style.display === 'none') {
    commentsContainer.style.display = 'block';
  } else {
    commentsContainer.style.display = 'none';
  }
}
</script>
    </section>


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
    <?php include "partials/_footer.php"; ?>
</body>


</html>