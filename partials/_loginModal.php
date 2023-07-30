<!-- Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login to Acharya Forum</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/forum/partials/_handleLogin.php" method="post" onsubmit="return validateLoginForm()">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="loginEmail">Email Address</label>
                        <input type="email" class="form-control" id="loginEmail" name="loginEmail"
                            aria-describedby="emailHelp" required>
                        <div class="invalid-feedback">Please enter a valid email address.</div>
                    </div>
                    <div class="form-group">
                        <label for="loginPass">Password</label>
                        <input type="password" class="form-control" id="loginPass" name="loginPass" required>
                        <div class="invalid-feedback">Please enter a password.</div>
                    </div>

                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function validateLoginForm() {
        var emailInput = document.getElementById("loginEmail");
        var passwordInput = document.getElementById("loginPass");

        if (!emailInput.checkValidity()) {
            emailInput.classList.add("is-invalid");
            return false;
        } else {
            emailInput.classList.remove("is-invalid");
        }

        if (passwordInput.value.trim() === "") {
            passwordInput.classList.add("is-invalid");
            return false;
        } else {
            passwordInput.classList.remove("is-invalid");
        }

        if (emailInput.value.trim() === "" && passwordInput.value.trim() === "") {
            emailInput.classList.add("is-invalid");
            passwordInput.classList.add("is-invalid");
            return false;
        }

        return true;
    }
</script>
