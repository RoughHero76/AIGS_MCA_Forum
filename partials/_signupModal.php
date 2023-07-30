<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <!-- <title>Signup Form with Validation</title> -->

    <style>
    .error {
        color: red;
    }
    </style>
</head>

<body>
    <!-- Modal -->
    <div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="signupModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="signupModalLabel">Signup for an Acharya Forum Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/forum/partials/_handleSignup.php" method="post" onsubmit="return validateSignupForm()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="signupUserName">
                            <small class="error" id="usernameError"></small>
                        </div>
                        <div class="form-group">
                            <label for="fullName">Full Name</label>
                            <input type="text" class="form-control" id="fullName" name="signupFullName">
                            <small class="error" id="fullNameError"></small>
                        </div>
                        <div class="form-group">
                            <label for="sem">Your Current Sem; Limit One Digit</label>
                            <input type="text" class="form-control" id="sem" name="signupSem">
                            <small class="error" id="semError"></small>
                        </div>
                        <div class="form-group">
                            <label for="usn">USN</label>
                            <input type="text" class="form-control" id="usn" name="signupUSN">
                            <small class="error" id="usnError"></small>
                        </div>
                        <div class="form-group">
                            <label for="signupEmail">Email Address</label>
                            <input type="email" class="form-control" id="signupEmail" name="signupEmail">
                            <small class="error" id="emailError"></small>
                        </div>
                        <div class="form-group">
                            <label for="signupPassword">Password</label>
                            <input type="password" class="form-control" id="signupPassword" name="signupPassword">
                            <small class="error" id="passwordError"></small>
                        </div>
                        <div class="form-group">
                            <label for="signupcPassword">Confirm Password</label>
                            <input type="password" class="form-control" id="signupcPassword" name="signupcPassword">
                            <small class="error" id="confirmPasswordError"></small>
                        </div>

                        <button type="submit" class="btn btn-primary">Signup</button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-i1q8iOzqlvC0PcY1KjwvhPPwlYwYG+MvSZ7RSdbfhCv7jY/d2ABWTgLffTLeGr6h" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
    </script>

    <script>
    function validateSignupForm() {
        var usernameInput = document.getElementById("username");
        var fullNameInput = document.getElementById("fullName");
        var semInput = document.getElementById("sem");
        var usnInput = document.getElementById("usn");
        var emailInput = document.getElementById("signupEmail");
        var passwordInput = document.getElementById("signupPassword");
        var confirmPasswordInput = document.getElementById("signupcPassword");

        var isValid = true;

        if (usernameInput.value.trim() === "") {
            document.getElementById("usernameError").textContent = "Please enter a username.";
            isValid = false;
        } else {
            document.getElementById("usernameError").textContent = "";
        }

        if (fullNameInput.value.trim() === "") {
            document.getElementById("fullNameError").textContent = "Please enter your full name.";
            isValid = false;
        } else {
            document.getElementById("fullNameError").textContent = "";
        }

        if (semInput.value.trim() === "") {
            document.getElementById("semError").textContent = "Please enter your current sem.";
            isValid = false;
        } else {
            document.getElementById("semError").textContent = "";
        }

        if (usnInput.value.trim() === "") {
            document.getElementById("usnError").textContent = "Please enter your USN.";
            isValid = false;
        } else {
            document.getElementById("usnError").textContent = "";
        }

        if (emailInput.value.trim() === "") {
            document.getElementById("emailError").textContent = "Please enter your email address.";
            isValid = false;
        } else {
            document.getElementById("emailError").textContent = "";
        }

        if (passwordInput.value.trim() === "") {
            document.getElementById("passwordError").textContent = "Please enter a password.";
            isValid = false;
        } else {
            document.getElementById("passwordError").textContent = "";
        }

        if (confirmPasswordInput.value.trim() === "") {
            document.getElementById("confirmPasswordError").textContent = "Please confirm your password.";
            isValid = false;
        } else if (confirmPasswordInput.value !== passwordInput.value) {
            document.getElementById("confirmPasswordError").textContent = "Passwords do not match.";
            isValid = false;
        } else {
            document.getElementById("confirmPasswordError").textContent = "";
        }
        return isValid;
    }
    </script>
</body>

</html>