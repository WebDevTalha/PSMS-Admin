<?php require_once('header.php')?>
<?php 


$user_id = $_GET['id'];
$profile_photo = student('profile_photo', $user_id);
$st_name = student('name', $user_id);


$stm = $pdo->prepare("SELECT * FROM students WHERE id=?");
$stm->execute(array($user_id));
$result = $stm->fetchAll(PDO::FETCH_ASSOC);

$name = $result[0]['name'];
$email = $result[0]['email'];
$email_status = $result[0]['is_email_verified'];
$mobile = $result[0]['mobile'];
$mobile_status = $result[0]['is_mobile_verified'];
$father_name = $result[0]['father_name'];
$father_mobile = $result[0]['father_mobile'];
$mother_name = $result[0]['mother_name'];
$gendar = $result[0]['gender'];
$birthday = $result[0]['birthday'];
$address = $result[0]['address'];
$roll = $result[0]['roll'];
$current_class = $result[0]['current_class'];
$registration_date = $result[0]['register_date'];


if(isset($_POST['info_update_btn'])){
	$name = $_POST['name'];
	$father_name = $_POST['father_name'];
	$mother_name = $_POST['mother_name'];
	$gender = $_POST['gender'];
	$birthday = $_POST['birthday'];
	$address = $_POST['address'];

	if(empty($name)){
		$error = "Name Is Requird!";
	}
	else if(empty($father_name)){
		$error = "Father Name Is Requird!";
	}
	else if(empty($mother_name)){
		$error = "Mother Name Is Requird!";
	}
	else if(empty($gendar)){
		$error = "Gender Is Requird!";
	}
	else if(empty($birthday)){
		$error = "Birth Date Is Requird!";
	}
	else if(empty($address)){
		$error = "Address Is Requird!";
	}
	else {

        $statement = $pdo->prepare("UPDATE students SET name=?,father_name=?,mother_name=?,gender=?,birthday=?,address=? WHERE id=?");
        $update_query = $statement->execute(
            array(
                $name,
                $father_name,
                $mother_name,
                $gendar,
                $birthday,
                $address,
                $user_id
            )
        );

        if($update_query == true){
            $success = "Profile Info Updated!";

        }
        else {
            $error = "Profile Info Update Failed!";
        }
	}
}


?>

<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white mr-2">
        <i class="mdi mdi-account"></i>                 
        </span>
        Edit &nbsp;<b><?php echo $st_name;?>'s</b> &nbsp;Data
    </h3>
</div>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
        <div class="card-body">
            <div class="user-profile"><img src="<?php 
                if($profile_photo != null){

                    echo '../PSMS-Front/dashboard/'.$profile_photo;
                } else {
                    echo "../PSMS-Front/dashboard/assets/uploads/user.png";
                }
                ?>">
            </div>
            <form class="edit-profile m-b30" action="" method="POST">
                <div class="">
                    <?php if(isset($error)) :?>
                    <div class="alert alert-danger">
                        <?php echo $error; ?>
                    </div>	
                    <?php endif;?>
                    <?php if(isset($success)) :?>
                    <div class="alert alert-success">
                        <?php echo $success; ?>
                    </div>	
                    <?php endif;?>
                    <div class="form-group row">
                        <div class="col-sm-10  ml-auto">
                            <h3>Edit Personal Details</h3>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Full Name</label>
                        <div class="col-sm-7">
                            <input class="form-control" name="name" type="text" value="<?php echo $name; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-7">
                            <input class="form-control" type="text" value="<?php echo $email; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Mobile</label>
                        <div class="col-sm-7">
                            <input class="form-control" type="text" value="<?php echo $mobile; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Father's Name</label>
                        <div class="col-sm-7">
                            <input class="form-control" name="father_name" type="text" value="<?php echo $father_name; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Father's Mobile</label>
                        <div class="col-sm-7">
                            <input class="form-control" name="father_mobile" type="text" value="<?php echo $father_mobile; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Mother's Name</label>
                        <div class="col-sm-7">
                            <input class="form-control" name="mother_name" type="text" value="<?php echo $mother_name; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Gender</label>
                        <div class="col-sm-7">
                            <label><input 
                            <?php if($gendar == "Male"){echo "checked";} ?> type="radio" value="Male" name="gender" id=""> Male</label> <br>

                            <label><input 
                            <?php if($gendar == "Female"){echo "checked";} ?> type="radio" value="Female" name="gender" id=""> Female</label>

                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Birthday</label>
                        <div class="col-sm-7">
                            <input class="form-control" name="birthday" type="date" value="<?php echo $birthday; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Address</label>
                        <div class="col-sm-7">
                            <input class="form-control" name="address" type="text" value="<?php echo $address; ?>">
                        </div>
                    </div>
                </div>
                <div class="">
                    <div class="">
                        <div class="row">
                            <div class="col-sm-2">
                            </div>
                            <div class="col-sm-7">
                                <button type="submit" name="info_update_btn" class="btn info_update_btn btn-gradient-primary">Save changes</button>
                                <button type="reset" class=" btn btn-danger">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        </div>
    </div>
</div>

<?php require_once('footer.php')?>

