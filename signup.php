<?php
  try{
    if(isset($_POST['register'])){
      $email = $_POST['email'];
      $password = $_POST['password'];
      $confirm_password = $_POST['confirm-password'];
      $user_name = $_POST['username'];
      $emailPattern = '/^[a-zA-Z0-9._%+-]+@dhvsu\.edu\.ph$/';
      $namePattern = '/^[A-Za-z]+(?: [A-Za-z]+)*$/';
  
      if (strlen($password) < 8 || strlen($password) > 32) {
        $password_error = 'Password must be 8 - 32 characters long';
      } elseif ($password !== $confirm_password){
        $confirmerror = 'Passwords do not match';
      } elseif (!preg_match($namePattern, $user_name)) {
        $usererror = 'Name should only contain letters';
      } elseif (!preg_match($emailPattern, $email)) {
          $error = 'Not a dhvsu account';
      } else{
          session_start();
          require_once 'dbcon.php';
          require_once 'mail.php';
  
          $sql = "SELECT * FROM user_details WHERE email = :email";
          $stmt = $pdo->prepare($sql);
          $stmt->bindParam(":email", $email);
          $stmt->execute();
  
          if ($stmt->rowCount() > 0) {
              echo '<script>alert("Email already Exist");</script>';
          } else {
              $_SESSION['email'] = $email;
              $_SESSION['password'] = $confirm_password;
              $_SESSION['user_name'] = $user_name;
              $otp = rand(100000, 999999);
              $_SESSION['otp'] = $otp;
              $message = "your code is " . $_SESSION['otp'];
              $subject = "Email verification";
              $recipient = $_SESSION['email'];
              send_mail($recipient, $subject, $message);
              echo '<script>alert("OTP Sent to your email");window.location.href = "verify.php";</script>';
              exit();
          }
      }
  }
}
catch(PDOException $e){
  $error_log = "Error: " . $e->getMessage();
  echo '<script>alert("' . $error_log . '"); window.location.href = "login.php";</script>';
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
        margin-bottom: 25px;
        color: #132043;
        text-align: center;
      }

      .wrapper .form{
        width: 100%;
      }

      .wrapper .form .inputfield{
        margin-bottom: 15px;
        display: block;
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
        text-transform:none;
      }

      .wrapper .form .inputfield .textarea{
        width: 100%;
        height: 125px;
        resize: none;
      }

      .wrapper .form .inputfield .custom_select{
        position: relative;
        width: 100%;
        height: 37px;
      }

      .wrapper .form .inputfield .custom_select:before{
        content: "";
        position: absolute;
        top: 12px;
        right: 10px;
        border: 8px solid;
        border-color: #d5dbd9 transparent transparent transparent;
        pointer-events: none;
      }

      .wrapper .form .inputfield .custom_select select{
        -webkit-appearance: none;
        -moz-appearance:   none;
        appearance:        none;
        outline: none;
        width: 100%;
        height: 100%;
        border: 0px;
        padding: 8px 10px;
        font-size: 15px;
        border: 1px solid #d5dbd9;
        border-radius: 3px;
      }


      .wrapper .form .inputfield .input:focus,
      .wrapper .form .inputfield .textarea:focus,
      .wrapper .form .inputfield .custom_select select:focus{
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
              Registration Form
            </div>
            <form action="signup.php" method="POST" class="form" id ="form">
              
            <div class="inputfield" <?php echo isset($error) ? 'data-error="' . htmlspecialchars($error) . '"' : ''; ?>>
                    <label>Email Address</label>
                    <input type="text" class="input" id="email" name="email" required>
                 </div> 
                  
                 <div class="inputfield"  <?php echo isset($password_error) ? 'data-error="' . htmlspecialchars($password_error) . '"' : ''; ?>>
                    <label>Password</label>
                    <input type="password" class="input" id="password" name="password" required>
                 </div>  
                 <div class="inputfield" <?php echo isset($confirmerror) ? 'data-error="' . htmlspecialchars($confirmerror) . '"' : ''; ?>>
                    <label>Confirm Password</label>
                    <input type="password" class="input" id="password2" name="confirm-password" required>
                 </div>  

               <div class="inputfield" <?php echo isset($usererror) ? 'data-error="' . htmlspecialchars($usererror) . '"' : ''; ?>>
                  <label>User Name</label>
                  <input type="text" class="input" id="username" name="username" required>
               </div>  

              <div class="inputfield">
                <input type="submit" value="Register" id="btn" class="btn" name="register">
              </div>
              <div class="inputfield">
                <p>Already have an account?</p><a href="login.php">Login</a>
              </div>
            </form>
        </div>
    </main>
    <footer class="footer">
               
        </footer>
</body>

</html>