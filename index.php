<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="css/LRstyle.css">
    <title></title>
</head>

<body>

    <div class="container" id="container">
        <div class="form-container sign-up">

            <form action="signup.php" method="post" onsubmit="return validateForm(this)">
                <h1>Create Account</h1>
                <span>Use your email for registration</span>
                <input type="text" placeholder="Name" name="username" id="username" autocomplete="off">
                <input type="email" placeholder="Email" name="email" id="email" autocomplete="off">
                <input type="text" placeholder="Contact Number" name="cnum" id="cnum" autocomplete="off">
                <!-- <input type="text" placeholder="Address" name="address" id="address" autocomplete="off"> -->
                <input type="password" placeholder="Password" name="pass" id="pass" autocomplete="off">
                <div class="button">
                    <input type="submit" class="btn" name="submit" value="Sign Up">
                </div>

                <!-- this os the js to validate form before submition -->
                       
             <script>                
                function validateForm(form) {
                    var username = form.username.value.trim();
                    var email = form.email.value.trim();
                    var cnum = form.cnum.value.trim();
                   // var address = form.address.value.trim();
                    var pass = form.pass.value.trim();

                    var errors = [];

                    if (!username || !email || !cnum  || !pass) {
                        errors.push("All fields are required");
                    } else {
                        if (!isValidEmail(email)) {
                            errors.push("Email is not valid");
                        }
                        if (cnum.length !== 10) {
                            errors.push("Invalid Phone Number");
                        }
                        if (pass.length < 8) {
                            errors.push("Password must be at least 8 characters");
                        }
                    }

                    if (errors.length > 0) {
                        displayErrors(errors);
                        return false; // Prevent form submission
                    }

                    return true; // Allow form submission if no errors
                }

                function isValidEmail(email) {
                    // Regular expression for email validation
                    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    return emailRegex.test(email);

                }

                function displayErrors(errors) {
                    var errorContainer = document.createElement('div');
                    errorContainer.className = 'alert alert-danger';
                    errors.forEach(function(error) {
                        var errorMessage = document.createTextNode(error);
                        var br = document.createElement('br');
                        errorContainer.appendChild(errorMessage);
                        errorContainer.appendChild(br);
                    });
                    var signUpForm = document.querySelector('.form-container.sign-up');
                    signUpForm.insertBefore(errorContainer, signUpForm.firstChild);
                }
                
            </script>
            
        
        </form>
        </div>

        <div class="form-container sign-in">
                 <?php
            session_start();
            if (isset($_SESSION["error"])) {
                echo '<div class="error-message">' . $_SESSION["error"] . '</div>';
                unset($_SESSION["error"]);
            }
            ?>   
            <form action ="signin.php" method="post"  >
                <h1>Sign In</h1>
                <span>Use your User ID password</span>
                <input type="email" placeholder="Email" name="semail" id="semail" >
                <input type="password" placeholder="Password" name="spass" id="spass" autocomplete="off">
                <a href="#">Forget Your Password?</a>
                <div class="button">
                    <input type="submit" class="btn" name="submit" value="Sign IN">
                </div>
            </form>
        </div>

        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Enter your personal details to use all of site features</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Hello, Friend!</h1>
                    <p>Register with your personal details to use all of site features</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    
    <script src ="js/script.js"></script>
</body>
</html>