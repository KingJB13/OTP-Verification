<?php
require 'dbcon.php';
try{
  $token = $_POST['token'];
  $sql = "SELECT * FROM user_details WHERE reset_token_hash = :token";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(":token",$token);
  $stmt->execute();
  $result = $stmt->fetch();
  if(empty($result['reset_token_hash'])){
    echo '<script>alert("token not found");</script>';
  }elseif(strtotime($result['reset_token_expiry']) <= time()){
    echo '<script>alert("Token expired, please generate a new token.");</script>';
  } else {
      $new_password = $_POST['password'];
      $confirm_password = $_POST['confirm_password'];
      if (strlen($new_password) < 8 || strlen($new_password) > 32) {
        $password_error = 'Password must be 8 - 32 characters long';
      }
      if($new_password !== $confirm_password){
        $confirmerror = 'Passwords do not match';
      }

      $password_hash = password_hash($confirm_password, PASSWORD_BCRYPT);
      $sql = "UPDATE user_details SET password = :password, reset_token_hash = NULL, reset_token_expiry = NULL WHERE id = :id";
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(":password",$password_hash);
      $stmt->bindParam(":id", $result['id']);
      $stmt->execute();
      $affectedRows = $stmt->rowCount();

      if($affectedRows > 0){
        echo '<script>alert("Password Recovered Successfully");window.location.href = "login.php";</script>';
        exit();
      }
      else{
        echo '<script>alert("Password Recovery Failed");window.location.href = "forgot-password.php";/script>';
        exit();
      }
  }
}
catch(PDOException $e){
  $error_log = "Error: " . $e->getMessage();
  echo '<script>alert("' . $error_log . '"); window.location.href = "login.php";</script>';
  exit();
}

?>