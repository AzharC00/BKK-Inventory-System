<?php 
require_once 'php_action/db_connect.php';

session_start();


if(isset($_SESSION['userId'])) {
	header('location: dashboard.php');	
}

$errors = array();

if($_POST) {		

	$username = $_POST['username'];
	$password = $_POST['password'];
    if(empty($username) || empty($password)) {
        if($username == "") {
            $errors[] = "Username is required";
        } 
    
        if($password == "") {
            $errors[] = "Password is required";
        }
    } else {
        $uppercase = preg_match('@[A-Z]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);
        if(!$uppercase || !$specialChars || strlen($password) < 8) {
            $errors[] = "**Password should contain at least one uppercase letter, one special character and be at least 8 characters long";
        }
        else {
            $sql = "SELECT * FROM users WHERE username = '$username'";
            $result = $connect->query($sql);
    
            if($result->num_rows == 1) {
                $password = $password;
                // exists
                $mainSql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
                $mainResult = $connect->query($mainSql);
    
                if($mainResult->num_rows == 1) {
                    $value = $mainResult->fetch_assoc();
                    $user_id = $value['user_id'];
    
                    // set session
                    $_SESSION['userId'] = $user_id;
    
                    if($value['email'] == ""){
                        header('location: setup.php');
                    }
                    else{
                        header('location: dashboard.php');
                    }
                } else{
                    
                    $errors[] = "**Incorrect username/password combination";
                } // /else
            } else {        
                $errors[] = "**Username does not exist";        
            } // /else
        } // /else not empty username // password
        
    } // /if $_POST
}    

?>
<style>
	@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700;800&display=swap');

*{
    margin: 0;
    padding:0;
    box-sizing: border-box;
    
}
body{
    font-family: 'Poppins', sans-serif;
    overflow: hidden;
 

}
.wave{
    position: fixed;
    bottom: 0;
    left: 0;
    height: 100%;
    z-index: -1;
}
.container{
    width: 100vw;
    height: 100vh;
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    grid-gap: 7rem;
    padding: 0 2rem;
     /* Change to the desired lighter background color */

}
.img{
    display: flex;
    justify-content: flex-end;
    align-items: center;
}
.login-content{
    display: flex;
    justify-content: flex-start;
    align-items: center;
    text-align: center;
}
.img img{
    width: 500px;
}
form{
    width: 360px;
}
.login-content img{
    height: 100px;
}
.title{
    margin: 15px 0;
    color: #333;
    font-size: 1.9rem;
}
.login-content .input-div{
    position: relative;
    display: grid;
    grid-template-columns: 7% 93%;
    margin: 25px 0;
    padding: 5px 0;
    border-bottom: 2px solid #d9d9d9;
}
.login-content .input-div.one{
    margin-top: 0;
}
.i{
    color: #d9d9d9;
    display: flex;
    justify-content: center;
    align-items: center;
}
.i i{
    transition: .3s;
}
.input-div > div{
    position: relative;
    height: 45px;
}
.input-div > div > h5{
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: #999;
    font-size: 18px;
    transition: .3s;
}
.input-div:before, .input-div:after{
    content: '';
    position: absolute;
    bottom: -2px;
    width: 0%;
    height: 2px;
    background-color: #6b5cff;
    transition: .4s;
}
.input-div:before{
    right: 50%;
}
.input-div:after{
    left: 50%;
}
.input-div.focus:before, .input-div.focus:after{
    width: 50%;
}
.input-div.focus > div > h5{
    top: -5px;
    font-size: 15px;
}
.input-div.focus > .i > i{
    color: #6b5cff;
}
.input-div > div > input{
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    border: none;
    outline: none;
    background: none;
    padding: 0.5rem 0.7rem;
    font-size: 1.2rem;
    color: #555;
}
.input-div.pass{
    margin-bottom: 4px;
}
a{
    display: block;
    text-align: center;
    text-decoration: none;
    color: #999;
    font-size: 0.9rem;
    transition: .3s;
}
a:hover{
    color: #6b5cff;
}
.btn{
    display: block;
    width: 100%;
    height: 50px;
    outline: none;
    border: none;
    background-image: linear-gradient(to right, #32cd32, #32cd32, #98fb98);
    font-size: 1.2rem;
    text-transform: uppercase;
    margin: 1rem 0;
    transition: .5s;
    border-radius:0px;
}
.btn:hover{
    background-position: right;
}

@media screen and (max-width: 1050px){
    .container{
        grid-gap: 5rem;
    }
}
@media screen and (max-width: 1000px){
    form{
        width: 290px;
    }
    .title{
        margin: 8px 0;
        font-size: 2.4rem;
    }
    .img img{
        width: 400px;
    }
}
    .wave {
        position: fixed;
        bottom: 0;
        left: 0;
        height: 100%;
        z-index: -1;
    }

@media screen and (max-width: 900px){
    body{
        background-color: #6b5cff;
    }
    .container{
        grid-template-columns: 1fr;
    }
    .img{
        display:none;
    }
    .wave{
        display:none;
    }
    .login-content{
        justify-content: center;
        color: #6b5cff;
    }
    .form-login{
        padding: 40px;
        background-color: #fff;
        width: 420px;
        border-radius: 8px;
        box-shadow: 3px 3px 15px rgba(88, 34, 160, 0.2);
    }
}</style>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   	<title >BKK Inventory Management System</title>
	        <!-- Favicon -->
        <link rel="shortcut icon" href="assests/jpkn.png">
     <link rel="icon" href="assests/jpkn.png" type="image/x-icon">
    <!----CSS link----->
    <link rel="stylesheet" href="style.css">
    <!----FontAwesome CDN Link---->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  </head>
  <body>  
      <div class="container">
          <div class="img">
              <img src="assests/images/177351644762bcec420515a.png">
			  
          </div>
          <div class="login-content">
          <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" id="loginForm">
          <h1 class="title">Welcome, Staff</h1>
                  <div class="messages">
				<?php if($errors) {
					foreach ($errors as $key => $value) {
						echo '<div class="alert alert-warning" role="alert">
						<i class="glyphicon glyphicon-exclamation-sign"></i>
						'.$value.'</div>';										
						}
					} ?>
			</div>
<div class="form-group">
  <div class="input-group">
    <div class="input-group-prepend">
      <span class="input-group-text">
        <i class="fa fa-user"></i>
      </span>
    </div>
    <input type="text" class="form-control" id="username" placeholder="Enter username" name="username">
  </div>
</div>

<div class="form-group">
  <div class="input-group">
    <div class="input-group-prepend">
      <span class="input-group-text">
        <i class="fa fa-lock"></i>
      </span>
    </div>
    <input type="password" class="form-control" id="password" placeholder="Enter password" name="password">
    <div class="input-group-append">
      <span class="input-group-text">
        <i class="fa fa-eye-slash" id="togglePassword"></i>
      </span>
    </div>
  </div>
</div>

    <button style="border:none" type="submit" class="btn btn-primary">Login</button>
    <a href="resetpassword.php">Forgot your password?</a>
    <a href="admin.php"><b>Login as Admin</b></a>
  </form>
          </div>
          
      </div>
	  <p style ="color:#fff;">
	© 2022 Hak Cipta Terpelihara Bahagian Komunikasi Korporat JPKN
		
	</p>

    <!---JS CDN Link---->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!--Custom File Link--->
    <script src="js.js"></script>
    <script>
  $(document).ready(function() {
    $('#togglePassword').click(function() {
      var passwordInput = $('#password');
      var passwordFieldType = passwordInput.attr('type');

      if (passwordFieldType === 'password') {
        passwordInput.attr('type', 'text');
        $(this).removeClass('fa-eye-slash').addClass('fa-eye');
      } else {
        passwordInput.attr('type', 'password');
        $(this).removeClass('fa-eye').addClass('fa-eye-slash');
      }
    });
  });
</script>
  </body>
</html>