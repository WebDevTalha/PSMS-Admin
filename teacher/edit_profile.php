<?php require_once('header.php');?>
<?php


$user_id = $_SESSION['teacher_loggedin'][0]['id'];
$profile_photo = teacherData('profile_photo', $user_id);


$stm = $pdo->prepare("SELECT * FROM teachers WHERE id=?");
$stm->execute(array($user_id));
$result = $stm->fetchAll(PDO::FETCH_ASSOC);

$name = $result[0]['name'];
$email = $result[0]['email'];
$mobile = $result[0]['mobile'];
$gendar = $result[0]['gender'];
$address = $result[0]['address'];
$registration_date = $result[0]['created_at'];
$profile_photo = $result[0]['profile_photo'];



if(isset($_POST['info_update_btn'])){
	$name = $_POST['name'];
	$gender = $_POST['gender'];
	$address = $_POST['address'];
	$photo = $_FILES['photo'];
    $target_dir = "uploads/"; 

	if(empty($name)){
		$error = "Name Is Requird!";
	}
	else if(empty($gendar)){
		$error = "Gender Is Requird!";
	}
	else if(empty($address)){
		$error = "Address Is Requird!";
	}
	else if(empty($photo['name'])){
		$error = "Photo Is Requird!";
	}
	else {
		// take photo extention
        $size = $_FILES['photo']['size'];
        $temp_name = $_FILES["photo"]["tmp_name"];
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


		// Photo Conditions
		if($fileType != 'png' && $fileType != 'jpg'){
            $eror = "photo must be png or jpg";
        }
        elseif($size >= 5000000){
            $eror = "photo less then 5MB";
        }
        else {
            // image same in file
            $name_prefix = rand(99,999999999999);
            $new_photo_name = $target_dir . $name_prefix . '.' . $fileType;


            $upload = move_uploaded_file($temp_name, $new_photo_name);

			$statement = $pdo->prepare("UPDATE teachers SET name=?,gender=?,address=?,profile_photo=? WHERE id=?");
			$update_query = $statement->execute(
				array(
					$name,
					$gendar,
					$address,
					$new_photo_name,
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
}


?>


<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white mr-2">
        <i class="mdi mdi-lock"></i>                 
        </span>
        Edit Profile
    </h3>
</div>

<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="edit-profile m-b30" action="" method="POST" enctype="multipart/form-data">
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
                            <label class="col-sm-3 col-form-label">Full Name</label>
                            <div class="col-sm-7">
                                <input class="form-control" name="name" type="text" value="<?php echo $name; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-7">
                                <input class="form-control" type="text" value="<?php echo $email; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Mobile</label>
                            <div class="col-sm-7">
                                <input class="form-control" type="text" value="<?php echo $mobile; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Gender</label>
                            <div class="col-sm-7">
                                <label><input 
                                <?php if($gendar == "Male"){echo "checked";} ?> type="radio" value="Male" name="gender" id=""> Male</label> <br>

                                <label><input 
                                <?php if($gendar == "Female"){echo "checked";} ?> type="radio" value="Female" name="gender" id=""> Female</label>

                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Address</label>
                            <div class="col-sm-7">
                                <input class="form-control" name="address" type="text" value="<?php echo $address; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Upload Photo</label>
                            <div class="col-sm-7">

                                <div class="photo_wrapper">
                                    <div class="avatar-upload">
                                        <div class="avatar-edit">
                                            <input type='file' name="photo" id="imageUpload"/>
                                            <label for="imageUpload"></label>
                                        </div>
                                        <div class="avatar-preview">
                                            <div id="imagePreview" style="background-image: url(<?php if($profile_photo == null){
                                                echo 'uploads/user.png';
                                            } else {
                                                echo $profile_photo;
                                            } ?>);">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="">
                            <div class="row">
                                <div class="col-sm-2">
                                </div>
                                <div class="col-sm-10">
                                    <button type="submit" name="info_update_btn" class="btn btn-success info_update_btn">Save changes</button>&nbsp;&nbsp;&nbsp;
                                    <button type="reset" class="btn btn-danger">Reset</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php require_once('footer.php');?>

<script>
	function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').css('background-image', 'url('+e.target.result +')');
            $('#imagePreview').hide();
            $('#imagePreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#imageUpload").change(function() {
    readURL(this);
});

</script>