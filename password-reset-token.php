<?php
if(isset($_POST['password-reset-token']) && $_POST['email'])
{
    include "php_action/db_connect.php";
     
    $emailId = $_POST['email'];
 
    $result = mysqli_query($connect,"SELECT * FROM users WHERE email='" . $emailId . "'");
 
    $row= mysqli_fetch_array($result);
 
  if($row)
  {
     
     $token = md5($emailId).rand(10,9999);
 
     $expFormat = mktime(
     date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y")
     );
 
    $expDate = date("Y-m-d H:i:s",$expFormat);
 
    $update = mysqli_query($connect,"UPDATE users set  password='" . $password . "', reset_link_token='" . $token . "' ,exp_date='" . $expDate . "' WHERE email='" . $emailId . "'");
 
    $link = "<a href='www.yourwebsite.com/reset-password.php?key=".$emailId."&token=".$token."'>Click To Reset password</a>";
 

    require 'phpmail/vendor/autoload.php';
 
    $mail = new \PHPMailer\PHPMailer\PHPMailer();


    
 
    $mail->CharSet =  "utf-8";
    $mail->IsSMTP();
    $mail->SMTPDebug = 3;
    // enable SMTP authentication
    $mail->SMTPAuth = true;                  
    // GMAIL username
    $mail->Username = "tanakwaguims@yahoo.com";
    // GMAIL password
    $mail->Password = "Tnkwgims00$";
    $mail->SMTPSecure = "ssl";  
    // sets GMAIL as the SMTP server
    $mail->Host = "smtp.gmail.com";
    // set the SMTP port for the GMAIL server
    $mail->Port = "465";
    $mail->From='tanakwaguims@gmail.com';
    $mail->FromName='your_name';
    $mail->AddAddress('azharchong00@gmail.com', 'reciever_name');
    $mail->Subject  =  'Reset Password';
    $mail->IsHTML(true);
    $mail->Body    = 'Click On This Link to Reset Password '.$link.'';
    if($mail->Send())
    {
      echo "Check Your Email and Click on the link sent to your email";
    }
    else
    {
      echo "Mail Error - >".$mail->ErrorInfo;
    }
  }else{
    echo "Invalid Email Address. Go back";
  }
}
?>