<?php require_once('header.php');?>
<?php


$user_id = $_SESSION['teacher_loggedin'][0]['id'];


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


?>


<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white mr-2">
        <i class="mdi mdi-lock"></i>                 
        </span>
        Profile
    </h3>
</div>

<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <tr>
                        <div class="user-profile"><img src="<?php 
                        if($profile_photo != null){
                            echo $profile_photo;
                        } else {
                            echo "uploads/user.png";
                        }
                        ?>"></div>
                    </tr>
                    <tr>
                        <td><b>Name:</b></td>
                        <td><?php echo $name; ?></td>
                    </tr>
                    <tr>
                        <td><b>Email:</b></td>
                        <td><?php echo $email;?></td>
                    </tr>
                    <tr>
                        <td><b>Mobile:</b></td>
                        <td><?php echo $mobile;?></td>
                    </tr>
                    <tr>
                        <td><b>Gendar:</b></td>
                        <td><?php echo $gendar; ?></td>
                    </tr>
                    <tr>
                        <td><b>Address:</b></td>
                        <td><?php echo $address; ?></td>
                    </tr>
                    <tr>
                        <td><b>Registration Date:</b></td>
                        <td><?php echo $registration_date; ?></td>
                    </tr>
                    <tr>
                        <td><a href="edit_profile.php" class="btn btn-warning">Edit Profile</a></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>


<?php require_once('footer.php');?>
