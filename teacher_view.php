<?php require_once('header.php')?>
<?php 

$teacher_id = $_GET['id'];

$stm = $pdo->prepare("SELECT * FROM teachers WHERE id=?");
$stm->execute(array($teacher_id));
$teacher = $stm->fetchAll(PDO::FETCH_ASSOC);     




?>

<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white mr-2">
        <i class="mdi mdi-account"></i>                 
        </span>
        <?php echo $teacher[0]['name']?>'s Data
    </h3>
</div>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
        <div class="card-body">
            <div class="user-profile"><img src="<?php 
                if($teacher[0]['profile_photo'] != null){

                    echo 'teacher/'.$teacher[0]['profile_photo'];
                } else {
                    echo "teacher/uploads/user.png";
                }
                ?>">
            </div>
            <table class="table table-bordered" id="all_teachers_table">
                <tbody>
                    <tr>
                        <td>Name</td>
                        <td><?php echo $teacher[0]['name'];?></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><?php echo $teacher[0]['email'];?></td>
                    </tr>
                    <tr>
                        <td>Mobile</td>
                        <td><?php echo $teacher[0]['mobile'];?></td>
                    </tr>
                    <tr>
                        <td>Gender</td>
                        <td><?php echo $teacher[0]['gender'];?></td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td><?php echo $teacher[0]['address'];?></td>
                    </tr>
                    <tr>
                        <td>Register Date</td>
                        <td><?php echo $teacher[0]['created_at'];?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        </div>
    </div>
</div>

<?php require_once('footer.php')?>

