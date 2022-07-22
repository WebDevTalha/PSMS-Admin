<?php require_once('header.php');?>
<?php


$user_id = $_SESSION['admin_loggedin'][0]['id'];


if(isset($_POST['s_create_btn'])){

	$s_name = $_POST['s_name'];
	$s_code = $_POST['s_code'];
	$s_type = $_POST['s_type'];


  // Subject Code count
  $codeCount = getCount('subjects','code',$s_code);

	if(empty($s_name)){
		$error = "Subject Name is requird!";
	}
	else if(empty($s_code)){
		$error = "Subject code is requird!";
	}
	else if(empty($s_type)){
		$error = "Subject Type is requird!";
	}
	else if($codeCount != 0){
		$error = "Subject Code Is Already Used!";
	}
	else {
		$update = $pdo->prepare("INSERT INTO subjects(
        name,
        code,
        type
    ) VALUES(?,?,?)");
		$result = $update->execute(array(
        $s_name,
        $s_code,
        $s_type
    ));

		if($result == true){
      $success = "Subject Create Successfully!";
    }
    else {
      $error = "Subject Create Failed!";
    }

		
	}
}




?>


<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white mr-2">
        <i class="mdi mdi-book-open-variant"></i>                 
        </span>
        Add New Subject
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
                      <label for="s_name">Subject Name</label>
                      <input type="text" class="form-control" name="s_name" id="s_name" placeholder="Subject Name">
                    </div>
                    <div class="form-group">
                      <label for="s_code">Subject Code</label>
                      <input type="text" class="form-control" name="s_code" id="s_code" placeholder="Subject Code">
                    </div>
                    <div class="form-group">
                      <label for="">Sunject Type</label> <br>
                      <label><input type="radio" name="s_type" value="Theory" checked> Theory</label>&nbsp;&nbsp;&nbsp;
                      <label><input type="radio" name="s_type" value="Practical"> Practical</label>
                    </div>

                    <button type="submit" name="s_create_btn" class="btn btn-gradient-primary mr-2">Create Subject</button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php require_once('footer.php');?>
