<?php require_once('header.php');?>
<?php

$user_id = $_GET['id'];

$teacher_data = getColData('teacher_id','assign_teachers',$user_id);
$subject_data = getColData('subject_id','assign_teachers',$user_id);


if(isset($_POST['t_create_btn'])){

	$t_name = $_POST['t_name'];

	if($t_name == 0){
		$error = "Select Teacher!";
	}
	else {
		$update = $pdo->prepare("UPDATE assign_teachers SET teacher_id=? WHERE id=?");
		$update->execute(array(
            $t_name,
            $user_id
        ));

		

		$success = "Subject Assign Changed Successfully!";
	}
}

?>

<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white mr-2">
        <i class="mdi mdi-account"></i>                 
        </span>
        Assign New Subject
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
                      <label for="teacher_name">Teacher Name</label>
                      <?php
                      $stm = $pdo->prepare("SELECT * FROM teachers");
                      $stm->execute();
                      $teacher_list = $stm->fetchAll(PDO::FETCH_ASSOC);

                      ?>

                      <select name="t_name" id="teacher_name" class="form-control">
                        <option value="0">Select Teacher</option>
                        <?php foreach($teacher_list as $teacher) :?>
                        <option <?php if($teacher_data == $teacher['id']){echo "selected";} ?> value="<?php echo $teacher['id'];?>"><?php echo $teacher['name'];?></option>
                        <?php endforeach;?>
                      </select>
                    </div>

                    <div class="form-group">
                      <label for="subject">Subject</label>
                      <?php
                      $stm = $pdo->prepare("SELECT * FROM subjects");
                      $stm->execute();
                      $subject_list = $stm->fetchAll(PDO::FETCH_ASSOC);
                      ?>

                      <select disabled name="subjects" id="subject" class="form-control">
                        <option value="0">Select Subject</option>
                        <?php foreach($subject_list as $sub_list) :?>
                        <option <?php if($subject_data == $sub_list['id']){echo "selected";} ?> value="<?php echo $sub_list['id'];?>"><?php echo $sub_list['name']." - ".$sub_list['code'];?></option>
                        <?php endforeach;?>
                      </select>
                    </div>

                    <button type="submit" name="t_create_btn" class="btn btn-gradient-primary mr-2">Assign Subject</button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php require_once('footer.php');?>
