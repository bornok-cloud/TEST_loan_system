<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Login Page</title>
    <style>
        .container button {
            font-family: 'Verdana', 'Copperplate';
            background-color: rgba(20, 18, 10, 0.71);
            color: #fff;
            font-size: 15px;
            padding: 10px 45px;
            border: 1px solid transparent;
            border-radius: 20px;
            font-weight: 400;
            letter-spacing: 2.9px;
            text-transform: uppercase;
            margin-top: 10px;
            cursor: pointer;
        }

        .container button.hidden {
            background-color: transparent;
            border-color: #fff;
        }

        .container form {
            background-color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 70px;
            height: 100%;
        }

        .container input {
            background-color: #eee;
            border: none;
            margin: 8px 0;
            padding: 10px 15px;
            font-size: 13px;
            border-radius: 8px;
            width: 100%;
            outline: none;
        }

        .form-container {
            position: absolute;
            top: 0;
            height: 100%;
            transition: all 0.6s ease-in-out;
        }

        .sign-in {
            left: 0;
            width: 50%;
            z-index: 2;
        }

        .container.active .sign-in {
            transform: translateX(100%);
        }

        .sign-up {
            left: 0;
            width: 50%;
            opacity: 0;
            z-index: 2;
        }

        .container.active .sign-up {
            transform: translateX(100%);
            opacity: 1;
            z-index: 5;
            animation: move 0.65s ease-in-out;
        }

        @keyframes move {

            0%,
            49.99% {
                opacity: 0;
                z-index: 1;
            }

            50%,
            100% {
                opacity: 1;
                z-index: 5;
            }
        }

        .toggle-container {
            position: absolute;
            top: 0;
            left: 50%;
            width: 50%;
            height: 100%;
            overflow: hidden;
            transition: all 0.6s ease-in-out;
            border-radius: 150px 0 0 100px;
            z-index: 1000;
        }

        .container.active .toggle-container {
            transform: translateX(-100%);
            border-radius: 0 150px 100px 0;
        }

        .toggle {
            background-color: rgb(60, 255, 174);
            height: 100%;
            background: linear-gradient(to right, rgb(20, 55, 100), rgb(52, 89, 253));
            color: #fff;
            position: relative;
            left: -100%;
            height: 100%;
            width: 200%;
            transform: translate(0);
            transition: all 0.6s ease-in-out;
        }

        .container.active .toggle {
            transform: translateX(50%);
        }

        .toggle-panel {
            position: absolute;
            width: 50%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 30px;
            text-align: center;
            top: 0;
            transform: translate(0);
            transition: all 0.6s ease-in-out;
        }

        .toggle-left {
            transform: translate(-200%);
        }

        .container.active .toggle-left {
            transform: translateX(0);
        }

        .toggle-right {
            right: 0;
            transform: translate(0);
        }

        .container.active .toggle-right {
            transform: translateX(200%);
        }
        .toggle-panel button.hidden {
            background-color: transparent;
            border-color: #fff;
            padding: 8px 30px; /* width */
            font-size: 14px;
            margin-top: 10px;
            width:160px;
            cursor: pointer;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .toggle-panel button.hidden:hover {
            background-color: #fff;
            color: #333;
        }
    </style>
</head>

<body>
    <div class="container" id="container">
        <div class="form-container sign-up">
            <form method="POST">
                <div class="card-body">
                    <form method="post">
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
                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                    </form>
                    <p class="mt-3 text-center">Already have an account? <a href="LOGIN1.php"></a></p>
                </div>
            </form>
        </div>
        <div class="form-container sign-in">
            <form method="POST" action="dashboard.php">
                <h1>Sign In</h1>
                <span>use your email for login</span>
                <input type="email" placeholder="Email" id="username" name="username" required>
                <input type="password" placeholder="Password" id="Password" name="Password" required>
                <a href="LOGIN1.php">Forget Your Password?</a>
                <button type="submit" class="btn btn-dark btn-block" name="login">Sign in</button>
            </form>
        </div>

        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome to Uniqloan!</h1>
                    <p>Enter your personal details to use all of site features</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Welcome to Uniqloan!</h1>
                    <p>Register with your personal details to use all of site features</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>