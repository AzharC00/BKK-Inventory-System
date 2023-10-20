<?php 


require_once 'php_action/db_connect.php';
$userId = $_SESSION['userId'];
$email = "SELECT * FROM users WHERE user_id = $userId";
$emailquerry= mysqli_query($connect,$email);
$emailarr=mysqli_fetch_array($emailquerry,MYSQLI_ASSOC);

// echo $emailarr['email'];
// $to = $emailarr['email'];
// $subject = "Password Reset";
// $txt = "Please click on the link provided to send your email ";
// $headers = "From: tanakwaguims@gmail.com" . "\r\n" ;



// if(mail($to,$subject,$txt,$headers))
// {
//     echo "<br>sent";
// }



                    $to_email = $emailarr['email'];

                    $headers = "From: BKKNoReply@sabah.gov.my";

					$subject = "INVENTORY MANAGEMENT SYSTEM";
					$body = 
					'
					<html>
						<body>

							<p>Hi <b>'.$emailarr['username'].'</b>.</p>

							<p>Referring to the matter above. You have been assigned with one (1) ticket to handle. Please take action and give response.</p>

							<p>To login please click the system link <a href="http://inventorisistemBKK@sabah.gov.my/resetpassword.php">Reset Password</a>.</p>

							<p>-------------------------------------</p>
							<p>This message is auto generate by the system. Please do not reply this email as it is just a notification and for user acknowledgement.</p>

						</body>
					</html>

					';
					$headers = 'From: BKKNoReply@sabah.gov.my'. "\r\n";
					$headers .= 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type:text/html;charset=UTF-8' . "\r\n";

					if(mail($to_email, $subject, $body, $headers))
                    {
                        echo "ok";
                    }
                    else
                    {
                        echo "not send";
                        
                    }



?>