<?php
  session_start();
  require_once 'dbcon.php';
  require_once 'mail.php';

  try{
    if(isset($_POST['forgot_password'])){
      $email = $_POST['email'];
      $token = bin2hex(random_bytes(16));
      $expiry = date("Y-m-d H:i:s", time() + 60 * 30);

      $sql = "SELECT * FROM user_details WHERE email = :email";
      $stmt = $pdo->prepare($sql);
      $stmt -> bindParam(':email', $email);
      $stmt -> execute();
      $row = $stmt->fetch();
      
      if($row['email'] === $email){
        $sql = "UPDATE user_details SET reset_token_hash = :token , reset_token_expiry = :expire WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt -> bindParam(':token', $token);
        $stmt -> bindParam(':expire', $expiry);
        $stmt -> bindParam(':email', $email);
        $stmt -> execute();
        if($stmt->rowCount() > 0){
          $message = "We received a request to reset your password. Click the link to reset your password: http://localhost/OTP-Verification/reset-password.php?token=$token";
          $subject = "Password Reset";
          $recipient = $email;
          send_mail($recipient, $subject, $message);
          echo "<script>alert('Check your inbox for a password reset link');</script>";
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
             Enter Email
            </div>
            <form action="forgot-password.php" method="POST" class="form">
                <div class="inputfield">
                    <label>Email Address</label>
                    <input type="text" class="input" id="email" name="email" required>
                </div> 

              <div class="inputfield">
                <input type="submit" value="Forgot Password" id="btn" class="btn" name="forgot_password">
              </div>
              <div class="inputfield">
                <p>Not a member?</p><a href="signup.php">Register</a>
              </div>

            </form>
        </div>
    </main>
    <footer class="footer">

    </footer>
</body>
</html>