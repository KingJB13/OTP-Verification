<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="nav-footer.css">
    <title>OTP</title>
    <style>
    .landing-container {
    text-align: center;
    }

    .card {
        background: rgba(31, 65, 114, 0.8);
        padding: 100px 300px;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .card h2{
        font-size: 30px;
        color: white;
    }
    .top-image {
        width: 100%;
        max-width: 300px; 
        margin: 0 auto 20px; 
        border-radius: 10px;
        z-index: 0;
    }

    .signup,
    .login {
        margin: 10px;
        padding: 10px 20px;
        background: #0082e6;
        background-size: cover;
        border-radius: 10px;
        display: inline-block;
        text-decoration: none;
        color: #fff;
    }

    .signup a{
        text-decoration: none;
        color: #fff;
        font-size: 15px;
    }
    .login a {
        text-decoration: none;
        color: #fff;
        font-size: 18px;
    }
    </style>
</head>
<body>
    <div class="navbar" id="nav">
    </div> 
    <main>
        <div class="landing-container">
            <div class="card">
                <div class="signup"><a href="signup.php">Sign Up</a></div>
                <div class="login"><a href="login.php">Log In</a></div> 
            </div>
        </div>
    </main>
    <footer class="footer">

</footer>
</body>
</html>