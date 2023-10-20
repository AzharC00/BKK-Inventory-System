<?php
require 'php_action/db_connect.php';
require 'includes/setup2.php';

$valid = array('success' => false, 'messages' => array());

if ($_POST) {
    $email = $_POST['email'];
    $npassword = $_POST['npassword'];
    $cpassword = $_POST['cpassword'];

    // Check if the fields are empty
    if (empty($email) || empty($npassword) || empty($cpassword)) {
        if (empty($email)) {
            $valid['messages'][] = "Email is required";
        }
        if (empty($npassword)) {
            $valid['messages'][] = "New Password is required";
        }
        if (empty($cpassword)) {
            $valid['messages'][] = "Confirm Password is required";
        }
    } else {
        // Check if the new password and confirm password match
        if ($npassword != $cpassword) {
            $valid['messages'][] = "New Password and Confirm Password do not match";
        } else {
            // Retrieve user details based on the email
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = $connect->query($sql);

            if ($result->num_rows == 1) {
                $user = $result->fetch_assoc();
                $userId = $user['user_id'];

                // Update the user's password
                $npassword = $npassword;
                $updateSql = "UPDATE users SET password = '$npassword' WHERE user_id = $userId";

                if ($connect->query($updateSql) === true) {
                    $valid['success'] = true;
                    $valid['messages'][] = "Password successfully updated";
                    header('Location: dashboard.php');
                    exit();
                } else {
                    $valid['messages'][] = "Error while updating the password";
                }
            } else {
                $valid['messages'][] = "Invalid email. Please try again";
            }
        }
    }

    echo json_encode($valid);
}
?>

<!-- HTML Form -->
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="form-horizontal" id="resetPasswordForm">
    <div class="form-group">
        <label for="email" class="col-sm-2 control-label">Email</label>
        <div class="col-sm-10">
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required>
        </div>
    </div>
    <div class="form-group">
        <label for="npassword" class="col-sm-2 control-label">New Password</label>
        <div class="col-sm-10">
            <input type="password" class="form-control" id="npassword" name="npassword" placeholder="Enter New Password" required>
        </div>
    </div>
    <div class="form-group">
        <label for="cpassword" class="col-sm-2 control-label">Confirm Password</label>
        <div class="col-sm-10">
            <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Confirm New Password" required>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-ok-sign"></i> Reset Password</button>
        </div>
    </div>
</form>

<script src="custom/js/setting.js"></script>
<?php require_once 'includes/footer.php'; ?>
</html>
