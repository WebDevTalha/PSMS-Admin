<?php require_once('header.php');?>
<?php


$user_id = $_SESSION['admin_loggedin'][0]['id'];


$profile_photo = admin('profile_photo',$user_id);



if(isset($_POST['info_update_btn'])){
	$photo = $_FILES['photo'];
    $target_dir = "images/uploads/"; 

	if(empty($photo['name'])){
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

			$statement = $pdo->prepare("UPDATE admin SET profile_photo=? WHERE id=?");
			$update_query = $statement->execute(
				array(
					$new_photo_name,
					$user_id
				)
			);

			if($update_query == true){
				$success = "Profile Photo Updated!";

			}
			else {
				$error = "Profile Photo Update Failed!";
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
                                                echo 'images/uploads/user.png';
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