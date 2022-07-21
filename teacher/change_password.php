<?php require_once('header.php');?>
<?php


$user_id = $_SESSION['teacher_loggedin'][0]['id'];




if(isset($_POST['change_btn'])){

	$current_password = $_POST['current_password'];
	$new_password = $_POST['new_password'];
	$confirm_new_password = $_POST['confirm_new_password'];

	$db_password = teacherData('password',$user_id);

	if(empty($current_password)){
		$error = "Current Password is requird!";
	}
	else if(empty($new_password)){
		$error = "New Password is requird!";
	}
	else if(empty($confirm_new_password)){
		$error = "Confirm New Password is requird!";
	}
	else if($db_password != SHA1($current_password)){
		$error = "Current Password Is Wrong!";
	}
	else if($new_password != $confirm_new_password){
		$error = "New Password Doesn't Match!";
	}
	else if(strlen($new_password) < 5){
		$error = "Password Must Be More Then 5 Digit!";
	}
	else if($db_password == SHA1($new_password)){
		$error = "Try New Password! You cannot enter the previous password twice.";
	}
	else {
		$update = $pdo->prepare("UPDATE teachers SET password=? WHERE id=?");
		$update->execute(array(SHA1($new_password),$user_id));

		

		$success = "Password Updated Successfully!";
	}
}




?>


<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white mr-2">
        <i class="mdi mdi-lock"></i>                 
        </span>
        Change Password
    </h3>
</div>

<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="POST" action="">
                    <?php if(isset($error)) :?>
                    <div class="alert alert-danger"><?php echo $error;?></div>
                    <?php endif;?>
                    <?php if(isset($success)) :?>
                    <div class="alert alert-success"><?php echo $success;?></div>
                    <?php endif;?>

                    <div class="form-group">
                      <label for="current">Current Password</label>
                      <input type="password" class="form-control" name="current_password" id="current" placeholder="Current Password">
                    </div>
                    <div class="form-group">
                      <label for="new">New Password</label>
                      <input type="password" class="form-control" name="new_password" id="new" placeholder="New Password">
                    </div>
                    <div class="form-group">
                      <label for="confirm_new_password">Confirm New Password</label>
                      <input type="password" class="form-control" name="confirm_new_password" id="confirm_new_password" placeholder="Confirm New Password">
                    </div>

                    <button type="submit" name="change_btn" class="btn btn-gradient-primary mr-2">Change</button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php require_once('footer.php');?>
