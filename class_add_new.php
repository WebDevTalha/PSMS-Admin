<?php require_once('header.php');?>
<?php


$user_id = $_SESSION['admin_loggedin'][0]['id'];


if(isset($_POST['c_create_btn'])){

	$c_name = $_POST['c_name'];
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];
  if(isset($_POST['c_subjects'])){
    $c_subjects = $_POST['c_subjects'];
  } else {
    $c_subjects = '';
  }



	if(empty($c_name)){
		$error = "Class Name is requird!";
	}
	if(empty($start_date)){
		$error = "Start Date is requird!";
	}
	if(empty($end_date)){
		$error = "End Date is requird!";
	}
	else if(empty($c_subjects)){
		$error = "Subject Name is requird!";
	}
	else {

    $c_subjects = json_encode($c_subjects);

		$update = $pdo->prepare("INSERT INTO class(
        class_name,
        start_date,
        end_date,
        subjects
    ) VALUES(?,?,?,?)");
		$result = $update->execute(array(
        $c_name,
        $start_date,
        $end_date,
        $c_subjects
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
        Add New Class
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
                      <label for="c_name">Class Name</label>
                      <input type="text" class="form-control" name="c_name" id="c_name" placeholder="Class Name">
                    </div>
                    <div class="form-group">
                      <label for="start_date">Start Date</label>
                      <input type="date" class="form-control" name="start_date" id="start_date">
                    </div>
                    <div class="form-group">
                      <label for="end_date">End Date</label>
                      <input type="date" class="form-control" name="end_date" id="end_date">
                    </div>
                    <div class="form-group">
                      <label for="">Select Subjects:</label> <br>
                      
                      <?php
                      $stm = $pdo->prepare("SELECT * FROM subjects");
                      $stm->execute();
                      $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                      
                      foreach($result as $row) :
                      ?>
                      
                      <label><input type="checkbox" name="c_subjects[]" value="<?php echo $row['id'];?>"> <?php echo $row['name'];?> - <?php echo $row['code'];?></label><br>
                      <?php endforeach;?>
                    </div>

                    <button type="submit" name="c_create_btn" class="btn btn-gradient-primary mr-2">Create Class</button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php require_once('footer.php');?>
