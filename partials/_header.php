<?php
session_start();

echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<a class="navbar-brand" href="/forum">Acharya Forum</a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="navbarSupportedContent">
  <ul class="navbar-nav mr-auto">
    <li class="nav-item active">
      <a class="nav-link" href="/forum">Home <span class="sr-only">(current)</span></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="about.php">About</a>
    </li>
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Top Categories
      </a>
      <div class="dropdown-menu" aria-labelledby="navbarDropdown">';

      $sql = "SELECT category_name, category_id FROM `categories` LIMIT 3";
      $result = mysqli_query($conn, $sql); 
      while($row = mysqli_fetch_assoc($result)){
        echo '<a class="dropdown-item" href="threadlist.php?catid='. $row['category_id']. '">' . $row['category_name']. '</a>'; 
      }
        
      echo '</div>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="contact.php" >Contact</a>
    </li>
  </ul>
  <div class="row mx-2">';
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
  // Fetch profile picture from the database
  $sno = $_SESSION['sno'];
  $sql = "SELECT profile_pic FROM users WHERE sno='$sno'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  $profilePic = $row['profile_pic'];

  // If the user doesn't have a profile picture, use a default image
  if (empty($profilePic)) {
    $profilePic = 'imgs/userdefault.png';
  }

  echo '<form class="form-inline my-2 my-lg-0" method="get" action="search.php">
    <input class="form-control mr-sm-2" name="search" type="search" actiion="search.php" placeholder="Search" aria-label="Search">
    <button class="btn btn-success my-2 my-sm-0" type="submit">Search</button>
      <p class="text-light my-0 mx-2">Welcome '. $_SESSION['username']. ' </p>
      <a href="partials/_logout.php" class="btn btn-outline-success ml-2">Logout</a>
      <a href="profile.php" class="btn btn-outline-success ml-2">Profile</a>
      

      <a href="profile.php" class="nav-link">
          <img src="'.$profilePic.'" class="rounded-circle" width="30" height="30" alt="Profile Picture">
        </a>
      </form>';
}
else{ 
  echo '<form class="form-inline my-2 my-lg-0">
    <input class="form-control mr-sm-2" type="search" placeholder="Please Login to Search" aria-label="Search" disabled>
    <button class="btn btn-outline-secondary"   type="submit" disabled >Search</button>
    </form>
    <button class="btn btn-outline-success ml-2" data-toggle="modal" data-target="#loginModal">Login</button>
    <button class="btn btn-outline-success mx-2" data-toggle="modal" data-target="#signupModal">Signup</button>';
}

echo '</div>
  </div>
  </nav>'; 

include 'partials/_loginModal.php';
include 'partials/_signupModal.php';  
/* include */

?>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  