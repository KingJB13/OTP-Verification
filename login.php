<?php
  session_start();
  require_once 'dbcon.php';
  try{
    if(isset($_POST['login'])){
      $email = $_POST['email'];
      $enteredPassword = $_POST['password'];
      $emailPattern = '/^[a-zA-Z0-9._%+-]+@dhvsu\.edu\.ph$/';

      if (!preg_match($emailPattern, $email)) {
        $error = 'Not a dhvsu account';
      }elseif (strlen($enteredPassword) < 8 || strlen($enteredPassword) > 32) {
        $password_error = 'Password must be 8 - 32 characters long';
      }else{
        $sql = "SELECT * FROM user_details WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        if($stmt->execute()){
            $user = $stmt->fetch();
  
            if ($user) {
                $hashedPassword = $user['password'];
                if (password_verify($enteredPassword, $hashedPassword)) {
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                      header("Location: home.php");
                      exit();
                } else {
                  echo '<script>alert("Invalid Password");window.location.href = "signup.php";</script>';
                }
            } else {
              echo '<script>alert("User does not Exist");</script>';
            }
        }
      }
    }
  }
  catch(PDOException $e){
    $error_log = "Error: " . $e->getMessage();
    echo '<script>alert("' . $error_log . '"); window.location.href = "index.php";</script>';
    exit();
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="nav-footer.css">
    <title>OTP</title>
    <style>

    .wrapper{
      max-width: 500px;
      width: 100%;
      background: #fff;
      margin: 50px auto;
      box-shadow: 2px 2px 4px rgba(0,0,0,0.125);
      padding: 30px;
    }

    .wrapper .title{
      font-size: 24px;
      font-weight: 700;
      margin-top: 50px;
      margin-bottom: 25px;
      color: #132043;
      text-align: center;
    }

    .wrapper .form{
      width: 100%;
    }

    .wrapper .form .inputfield{
      margin-bottom: 15px;
      display: flex;
      align-items: center;
    }

    .wrapper .form .inputfield:nth-child(7){
        margin-bottom: 20px;
    }
    .wrapper .form .inputfield[data-error] .input{
        border-color: #c92432;
        color: #c92432;
        background: #fffafa;
      }

    .wrapper .form .inputfield[data-error]::after{
        content: attr(data-error);
        font-size: 16px;
        color: #c92432;
        display: block;
        margin: 10px 0;
    }
    .wrapper .form .inputfield label{
      width: 200px;
      color: #757575;
      margin-right: 10px;
      font-size: 14px;
    }

    .wrapper .form .inputfield .input,
    .wrapper .form .inputfield .textarea{
      width: 100%;
      outline: none;
      border: 1px solid #d5dbd9;
      font-size: 15px;
      padding: 8px 10px;
      border-radius: 3px;
      transition: all 0.3s ease;
      text-transform: none;
    }

    .wrapper .form .inputfield .textarea{
      width: 100%;
      height: 125px;
      resize: none;
    }

    .wrapper .form .inputfield .input:focus{
      border: 1px solid #132043;
    }

    .wrapper .form .inputfield p{
      font-size: 14px;
      color: #757575;
    }

    .wrapper .form .inputfield .btn{
      width: 100%;
      padding: 8px 10px;
      font-size: 15px; 
      border: 0px;
      background:  #132043;
      color: #fff;
      cursor: pointer;
      border-radius: 3px;
      outline: none;
    }

    .wrapper .form .inputfield .btn:hover{
      background: #132043;
    }

    .wrapper .form .inputfield:last-child{
      margin-bottom: 0;
    }

    @media (max-width:420px) {
      .wrapper .form .inputfield{
        flex-direction: column;
        align-items: flex-start;
      }
      .wrapper .form .inputfield label{
        margin-bottom: 5px;
      }

    }
    </style>
</head>
<body>
    <div class="navbar" id="nav">
    </div> 
    <main>
        
        <div class="wrapper">
            <div class="title">
             Login
            </div>
            <form action="login.php" method="POST" class="form">
                <div class="inputfield" <?php echo isset($error) ? 'data-error="' . htmlspecialchars($error) . '"' : ''; ?>>
                    <label>Email Address</label>
                    <input type="text" class="input" id="email" name="email" required>
                 </div> 

                 <div class="inputfield" <?php echo isset($password_error) ? 'data-error="' . htmlspecialchars($password_error) . '"' : ''; ?>>
                    <label>Password</label>
                    <input type="password" class="input" id="password" name="password" required>
                 </div>  
               
              <div class="inputfield">
                <input type="submit" value="login" id="btn" class="btn" name="login">
              </div>
              <div class="inputfield">
                <p>Not a member?</p><a href="signup.php">Register</a>
              </div>
              <div class="inputfield">
                <p>Forgot Password?</p><a href="forgot-password.php">Forgot Password</a>
              </div>
            </form>
        </div>
    </main>
    <footer class="footer">
    </footer>
</body>
</html>