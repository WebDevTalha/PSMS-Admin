<?php require_once('header.php')?>
<?php 


$user_id = $_GET['id'];


$stm = $pdo->prepare("SELECT * FROM class WHERE id=?");
$stm->execute(array($user_id));
$result = $stm->fetchAll(PDO::FETCH_ASSOC);

$c_class_name = $result[0]['class_name'];
$c_start_date = $result[0]['start_date'];
$c_end_date = $result[0]['end_date'];


if(isset($_POST['info_update_btn'])){
	$c_name = $_POST['c_name'];
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];
    if(isset($_POST['c_subjects'])){
        $c_subjects = $_POST['c_subjects'];
    }
    else {
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

        $statement = $pdo->prepare("UPDATE class SET class_name=?,start_date=?,end_date=?,subjects=? WHERE id=?");
        $update_query = $statement->execute(
            array(
                $c_name,
                $start_date,
                $end_date,
                $c_subjects,
                $user_id
            )
        );

        $success = "Subject Info Updated!";
	}
}


?>

<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white mr-2">
        <i class="mdi mdi-book-open-variant"></i>                 
        </span>
        Edit Class Data
    </h3>
</div>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
        <div class="card-body">
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
                        <label class="col-sm-2 col-form-label">Class Name</label>
                        <div class="col-sm-7">
                            <input class="form-control" name="c_name" type="text" value="<?php echo $c_class_name; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Start Date</label>
                        <div class="col-sm-7">
                        <input type="date" class="form-control" name="start_date" id="start_date" value="<?php echo $c_start_date;?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">End Date</label>
                        <div class="col-sm-7">
                        <input type="date" class="form-control" name="end_date" id="end_date" value="<?php echo $c_end_date;?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Subjects:</label>
                        <div class="col-sm-7">
                        <?php
                        $stm = $pdo->prepare("SELECT * FROM subjects");
                        $stm->execute();
                        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                        
                        foreach($result as $row) :
                        ?>
                        
                        <label><input type="checkbox" name="c_subjects[]" value="<?php echo $row['id'];?>"> <?php echo $row['name'];?> - <?php echo $row['code'];?></label><br>
                        <?php endforeach;?>

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

