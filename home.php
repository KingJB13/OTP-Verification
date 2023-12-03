<?php
session_start();
 if(!isset($_SESSION['id'])){
    session_destroy();
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP</title>
    <link rel="stylesheet" href="nav-footer.css">
</head>

<body>
<div class="navbar" id="nav">
    <label class="logo"><?php echo "WELCOME, ".$_SESSION['username']; ?></label>
    <ul>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</div> 
            <main>

            </main>            
<footer class="footer">
</footer>
</body>
</html>

