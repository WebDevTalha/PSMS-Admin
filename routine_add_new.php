<?php require_once('header.php');?>
<?php


$user_id = $_SESSION['admin_loggedin'][0]['id'];


if(isset($_POST['s_create_btn'])){

    if(isset($_POST['all_class'])){
        $all_class = $_POST['all_class'];
    } else {
        $all_class = '';
    }

    if(isset($_POST['subjects'])){
        $subjects = $_POST['subjects'];
        
        $teacher_id = getSubjectTeacher($subjects);
    } else {
        $subjects = '';
    }

	$time_from = $_POST['time_from'];
	$time_to = $_POST['time_to'];
	$room_no = $_POST['room_no'];
	$day = $_POST['day'];



	if($all_class == 0){
		$error = "Select Class!";
	}
	else if(empty($subjects)){
		$error = "Subject Is Requird!";
	}
	else if(empty($time_from)){
		$error = "Time From Is Requird!";
	}
	else if(empty($time_to)){
		$error = "Time To Is Requird!";
	}
	else if(empty($room_no)){
		$error = "Room no Is Requird!";
	}
	else {
		$update = $pdo->prepare("INSERT INTO class_routine(
        class_name,
        subject_id,
        teacher_id,
        time_from,
        time_to,
        room_no,
        day
    ) VALUES(?,?,?,?,?,?,?)");
		$result = $update->execute(array(
        $all_class,
        $subjects,
        $teacher_id,
        $time_from,
        $time_to,
        $room_no,
        $day
    ));

	if($result == true){
      $success = "Routine Create Successfully!";
    }
    else {
      $error = "Routine Create Failed!";
    }

		
	}
}




?>


<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white mr-2">
        <i class="mdi mdi-book-open-variant"></i>                 
        </span>
        Add New Routine
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
                      <label for="class_s">Select Class</label>
                      <?php
                      $stm = $pdo->prepare("SELECT id,class_name FROM class");
                      $stm->execute();
                      $c_list = $stm->fetchAll(PDO::FETCH_ASSOC);
                      ?>

                      <select name="all_class" id="class_s" class="form-control">
                        <option value="0">Select Class</option>
                        <?php foreach($c_list as $list) :?>

                        <option value="<?php echo $list['id'];?>"><?php echo $list['class_name'];?></option>

                        <?php endforeach;?>
                      </select>
                    </div>
                    
                    <div class="form-group">
                      <label for="s_subject">Select Subject</label>

                      <select name="subjects" id="s_subject" class="form-control">
                        
                      </select>
                    </div>
                    
                    <div class="form-group">
                      <label for="s_day">Select Day</label>

                      <select name="day" id="s_day" class="form-control">
                        <option value="Saturday">Saturday</option>
                        <option value="Sunday">Sunday</option>
                        <option value="Monday">Monday</option>
                        <option value="Tuesday">Tuesday</option>
                        <option value="Wednesday">Wednesday</option>
                        <option value="Thursday">Thursday</option>
                      </select>
                    </div>

                    <div class="form-group">
                      <label for="time_from">Time From</label> <br>
                      <input type="time" value="<?php date_default_timezone_set("Asia/Dhaka");
                        echo date("h:i"); ?>" class="form-control" name="time_from" id="time_from">
                    </div>

                    <div class="form-group">
                      <label for="time_to">Time To</label> <br>
                      <input type="time" value="<?php date_default_timezone_set("Asia/Dhaka");
                        echo date("h:i"); ?>" class="form-control" name="time_to" id="time_to">
                    </div>

                    <div class="form-group">
                      <label for="room_no">Room No.</label> <br>
                      <input type="text" class="form-control" name="room_no" id="room_no" placeholder="Room No">
                    </div>

                    <button type="submit" name="s_create_btn" class="btn btn-gradient-primary mr-2">Create New Routine</button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php require_once('footer.php');?>

<script>

$('#class_s').change(function(){
    let class_id = $(this).val();

    $.ajax({
        type: "POST",
        url: "ajax.php",
        data: {
            class_id:class_id
        },
        success:function(responce){

            let data = responce;
            $('#s_subject').html(responce);
        }
    });

});

</script>
