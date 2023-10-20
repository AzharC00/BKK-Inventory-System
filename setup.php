<?php require_once 'php_action/core.php'; ?>
<?php require_once 'includes/setup.php'; ?>

<?php 
$user_id = $_SESSION['userId'];
$sql = "SELECT * FROM users WHERE user_id = {$user_id}";
$query = $connect->query($sql);
$result = $query->fetch_assoc();

$valid['success'] = array('success' => false, 'messages' => array());


?>

<?php 
$errors3 = array();
$errors = array();
$errors1 = array();
$errors2 = array();
if($_POST) {		

	$setEmail = $_POST['email'];
	$npassword = $_POST['npassword'];
	$cpassword = $_POST['cpassword'];

	if(empty($setEmail) || empty($npassword) || empty($cpassword)) {
		if($setEmail == "") {
			$errors[] = "Email is required";
		} 
	
		if($npassword == "") {
			$errors1[] = "New Password is required";
		}
		if($cpassword == "") {
			$errors2[] = "Confirm Password is required";
		}
	} else {

		if($npassword != $cpassword){
			$errors1[] = "New Password and Confirm Password does not match";
		} else {
			// regex pattern for password validation
			$password_pattern = '/^(?=.*[!@#$%^&*(),.?":{}|<>])(?=.*[A-Z])(?=.*\d)[A-Za-z\d!@#$%^&*(),.?":{}|<>]{8,}$/';
			$email_pattern = '/^[^\s@]+@[^\s@]+\.[^\s@]+$/';
			// check if password meets the requirements
			if (!preg_match($password_pattern, $npassword)) {
				$errors1[] = "Password must contain at least 8 characters, one special character, and one uppercase letter";
			} else {
				$npassword = $npassword;

				if (!preg_match($email_pattern, $setEmail)) {
					$errors3[] = "Invalid email format";
				}
				
				$sql = "UPDATE users SET email = '$setEmail', password = '$npassword' WHERE user_id = {$user_id }";
				if($connect->query($sql) === TRUE) {
					$valid['success'] = true;
					$valid['messages'] = "Successfully Updated";
					$connect->close();
					echo json_encode($valid);
					header('location: dashboard.php');
				} else {
					$valid['success'] = false;
					$valid['messages'] = "Error while updating the password";	
				}
			}
		}
	}
}

?>



<div class="row">
	<div class="col-md-12">
		<ol class="breadcrumb">  
		  <li class="active">Setup</li>
		</ol>

		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="page-heading"> <i class="glyphicon glyphicon-wrench"></i> Setup</div>
			</div> <!-- /panel-heading -->

			

			<div class="panel-body">

				
				<!-- THIS is for email -->
				<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="form-horizontal" id="changeEmail" >
					<fieldset>
						<legend>Setup Email</legend>

					<!-- Email Error message -->
						<div class="messages">
							<?php if($errors) {
								foreach ($errors as $key => $value) {
									echo '<div class="alert alert-warning" role="alert" ">
									<i class="glyphicon glyphicon-exclamation-sign"></i>
									'.$value.'</div>';										
									}
								} ?>
						</div>

											<!-- Email Error message -->
											<div class="messages">
							<?php if($errors3) {
								foreach ($errors3 as $key => $value) {
									echo '<div class="alert alert-warning" role="alert" ">
									<i class="glyphicon glyphicon-exclamation-sign"></i>
									'.$value.'</div>';										
									}
								} ?>
						</div>

						<div class="form-group">
					    <label for="username" class="col-sm-2 control-label">Email</label>
					    <div class="col-sm-10">
					      <input type="text" class="form-control" id="email" name="email" placeholder="email" value="<?php if(!empty($setEmail)){echo $setEmail; }?>" >
					    </div>
					  </div>

					  <div class="form-group">
					    <div class="col-sm-offset-2 col-sm-10">
					    	<input type="hidden" name="user_id" id="user_id" value="<?php echo $result['user_id'] ?>" /> 
					   </div>
					  </div>
						<legend>Setup Password</legend>
						<!-- New Password Error message -->
						<div class="messages">
							<?php if($errors1) {
								foreach ($errors1 as $key => $value) {
									echo '<div class="alert alert-warning" role="alert" ">
									<i class="glyphicon glyphicon-exclamation-sign"></i>
									'.$value.'</div>';										
									}
								} ?>
						</div>

					  <div class="form-group">
					    <label for="npassword" class="col-sm-2 control-label">New password</label>
					    <div class="col-sm-10">
					      <input type="password" class="form-control" id="npassword" name="npassword" placeholder="New Password" >
					    </div>
					  </div>
						
					  <!-- Confrim Password Error message -->
					  	<div class="messages">
							<?php if($errors2) {
								foreach ($errors2 as $key => $value) {
									echo '<div class="alert alert-warning" role="alert" ">
									<i class="glyphicon glyphicon-exclamation-sign"></i>
									'.$value.'</div>';										
									}
								} ?>
						</div>

					  <div class="form-group">
					    <label for="cpassword" class="col-sm-2 control-label">Confirm Password</label>
					    <div class="col-sm-10">
					      <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Confirm Password" >
					    </div>
					  </div>

					  <div class="form-group">
					    <div class="col-sm-offset-2 col-sm-10">
					    	<input type="hidden" name="user_id" id="user_id" value="<?php echo $result['user_id'] ?>" /> 
					      <button type="submit" class="btn btn-primary" > <i class="glyphicon glyphicon-ok-sign"></i> Save Changes </button>
					      
					    </div>
					  </div>


					</fieldset>
				</form>
				<!-- THIS is for email  END ----------------------->

			</div> <!-- /panel-body -->		

		</div> <!-- /panel -->		
	</div> <!-- /col-md-12 -->	
</div> <!-- /row-->


<script src="custom/js/setting.js"></script>
<?php require_once 'includes/footer.php'; ?>
