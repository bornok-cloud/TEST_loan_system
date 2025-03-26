
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Login Page</title>
    <link rel="stylesheet" href="../stylekuno/LOGIN.css">
</head>

<body>
    <div class="container" id="container">
        <!-- Sign Up Form -->
        <div class="form-container sign-up">
            <form method="POST" action="register.php">
                <h1>Sign up</h1>
                <span></span>
                <div class="form-group">
                    <label for="username"></label>
                    <input type="text" Placeholder="Username" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password"></label>
                    <input type="password" Placeholder="Password" class="form-control" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="email"></label>
                    <input type="email" Placeholder="Email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="userType">Account Type</label>
                    <select id="userType" name="userType" class="form-control">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Register</button>
            </form>
            <p class="mt-3 text-center">Already have an account? <a href="LOGIN1.php">Login</a></p>
        </div>

        <!-- Sign In Form -->
        <div class="form-container sign-in">
            <form method="POST" action="login.php">
                <h1>Sign In</h1>
                <span>Use your email for login</span>
                <input type="email" placeholder="Email" id="username" name="username" required>
                <input type="password" placeholder="Password" id="Password" name="Password" required>
                <a href="LOGIN1.php">Forget Your Password?</a>
                <button type="submit" class="btn btn-dark btn-block" name="login">Sign in</button>
            </form>
        </div>

        <!-- Toggle between Sign Up and Sign In -->
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome to Uniqloan!</h1>
                    <p>Enter your personal details to use all of the site features</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Welcome to Uniqloan!</h1>
                    <p>Register with your personal details to use all of the site features</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../javascript/adminuserLogin.js"></script>
</body>

</html>
