<?php require_once('header.php');?>
<?php


$user_id = $_SESSION['admin_loggedin'][0]['id'];




if(isset($_POST['t_create_btn'])){

	$teacher_name = $_POST['teacher_name'];
	$teacher_email = $_POST['teacher_email'];
	$teacher_mobile = $_POST['teacher_mobile'];
	$address = $_POST['address'];
	$gender = $_POST['gender'];
	$password = $_POST['password'];


    // Teachers email count
    $teacher_email_count = teacharCount('email',$teacher_email);
    // Teachers mobile count
    $teacher_mobile_count = teacharCount('mobile',$teacher_mobile);

	if(empty($teacher_name)){
		$error = "Name is requird!";
	}
	else if(empty($teacher_email)){
		$error = "Email is requird!";
	}
	// else if(filter_var($teacher_email, FILTER_VALIDATE_EMAIL)){
	// 	$error = "Enter Valid Email!";
	// }
	else if($teacher_email_count != 0){
		$error = "This Email Is Already Used!";
	}
	else if(empty($teacher_mobile)){
		$error = "Mobile is requird!";
	}
    else if($teacher_mobile_count != 0){
		$error = "This Mobile Number Is Already Used!";
	}
	else if(empty($address)){
		$error = "Address Is requird!";
	}
	else if(empty($password)){
		$error = "Password Is requird!";
	}
	else if(strlen($password) < 6){
		$error = "Password Must Be More Then 5 Digit!";
	}
	else {
		$update = $pdo->prepare("INSERT INTO teachers(
            name,
            email,
            mobile,
            address,
            gender,
            password
        ) VALUES(?,?,?,?,?,?)");
		$update->execute(array(
            $teacher_name,
            $teacher_email,
            $teacher_mobile,
            $address,
            $gender,
            SHA1($password)
        ));

		

		$success = "Teacher Account Create Successfully!";
	}
}




?>


<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white mr-2">
        <i class="mdi mdi-lock"></i>                 
        </span>
        Add New Teacher
    </h3>
</div>

<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="POST" action="">
                    <h4 class="card-title">Create Account</h4>
                    <p class="card-description">
                    Create New Teacher Account
                    </p>
                    <?php if(isset($error)) :?>
                    <div class="alert alert-danger"><?php echo $error;?></div>
                    <?php endif;?>
                    <?php if(isset($success)) :?>
                    <div class="alert alert-success"><?php echo $success;?></div>
                    <?php endif;?>

                    <div class="form-group">
                      <label for="teacher_name">Teacher Name</label>
                      <input type="text" class="form-control" name="teacher_name" id="teacher_name" placeholder="Teacher Name">
                    </div>
                    <div class="form-group">
                      <label for="teacher_email">Teacher Email</label>
                      <input type="text" class="form-control" name="teacher_email" id="teacher_email" placeholder="Teacher Email">
                    </div>
                    <div class="form-group">
                      <label for="teacher_mobile">Teacher Mobile</label>
                      <input type="text" class="form-control" name="teacher_mobile" id="teacher_mobile" placeholder="Teacher Mobile">
                    </div>
                    <div class="form-group">
                      <label for="address">Address</label>
                      <input type="text" class="form-control" name="address" id="address" placeholder="Address">
                    </div>
                    <div class="form-group">
                      <label for="">Gender</label> <br>
                      <label><input type="radio" name="gender" value="Male" checked> Male</label>&nbsp;&nbsp;&nbsp;
                      <label><input type="radio" name="gender" value="Female"> Female</label>
                    </div>
                    <div class="form-group">
                      <label for="password">Password</label>
                      <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                    </div>

                    <button type="submit" name="t_create_btn" class="btn btn-gradient-primary mr-2">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php require_once('footer.php');?>
