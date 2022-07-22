<?php require_once('header.php')?>
<?php 


$user_id = $_GET['id'];


$stm = $pdo->prepare("SELECT * FROM subjects WHERE id=?");
$stm->execute(array($user_id));
$result = $stm->fetchAll(PDO::FETCH_ASSOC);

$name = $result[0]['name'];
$code = $result[0]['code'];
$type = $result[0]['type'];
$registration_date = $result[0]['created_at'];


if(isset($_POST['info_update_btn'])){
	$s_name = $_POST['s_name'];
	$s_code = $_POST['s_code'];
	$s_type = $_POST['s_type'];
    
    
    // Subject Code count
    $codeCount = getCount('subjects','code',$s_code);

	if(empty($s_name)){
		$error = "Subject Name Is Requird!";
	}
	else if(empty($s_code)){
		$error = "Subject Code Is Requird!";
	}
	else if(empty($s_type)){
		$error = "Subject Type Is Requird!";
	}
	else if($codeCount != 0){
		$error = "Subject Code Is Already Used!";
	}
	else {

        $statement = $pdo->prepare("UPDATE subjects SET name=?,code=?,type=? WHERE id=?");
        $update_query = $statement->execute(
            array(
                $s_name,
                $s_code,
                $s_type,
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
        Edit Subject Data
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
                        <label class="col-sm-2 col-form-label">Subject Name</label>
                        <div class="col-sm-7">
                            <input class="form-control" name="s_name" type="text" value="<?php echo $name; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Subject Code</label>
                        <div class="col-sm-7">
                            <input class="form-control" type="text" name="s_code" value="<?php echo $code; ?>" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Subject Type</label>
                        <div class="col-sm-7">
                            <label><input 
                            <?php if($type == "Theory"){echo "checked";} ?> type="radio" value="Theory" name="s_type" id=""> Theory</label> <br>

                            <label><input 
                            <?php if($type == "Practical"){echo "checked";} ?> type="radio" value="Practical" name="s_type" id=""> Practical</label>

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

