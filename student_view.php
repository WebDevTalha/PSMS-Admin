<?php require_once('header.php')?>
<?php 

$student_id = $_GET['id'];

$stm = $pdo->prepare("SELECT * FROM students WHERE id=?");
$stm->execute(array($student_id));
$student = $stm->fetchAll(PDO::FETCH_ASSOC);     




?>

<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white mr-2">
        <i class="mdi mdi-account"></i>                 
        </span>
        <?php echo $student[0]['name']?>'s Data
    </h3>
</div>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
        <div class="card-body">
            <div class="user-profile"><img src="<?php 
                if($student[0]['profile_photo'] != null){

                    echo '../PSMS-Front/dashboard/'.$student[0]['profile_photo'];
                } else {
                    echo "../PSMS-Front/dashboard/assets/uploads/user.png";
                }
                ?>">
            </div>
            <table class="table table-bordered" id="all_teachers_table">
                <tbody>
                    <tr>
                        <td>Name</td>
                        <td><?php echo $student[0]['name'];?></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><?php echo $student[0]['email'];?></td>
                    </tr>
                    <tr>
                        <td>Mobile</td>
                        <td><?php echo $student[0]['mobile'];?></td>
                    </tr>
                    <tr>
                        <td>Father's Name</td>
                        <td><?php echo $student[0]['father_name'];?></td>
                    </tr>
                    <tr>
                        <td>Father's Mobile</td>
                        <td><?php echo $student[0]['father_mobile'];?></td>
                    </tr>
                    <tr>
                        <td>Mother's Name</td>
                        <td><?php echo $student[0]['mother_name'];?></td>
                    </tr>
                    <tr>
                        <td>Gender</td>
                        <td><?php echo $student[0]['gender'];?></td>
                    </tr>
                    <tr>
                        <td>Birthday</td>
                        <td><?php echo $student[0]['birthday'];?></td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td><?php echo $student[0]['address'];?></td>
                    </tr>
                    <tr>
                        <td>Roll</td>
                        <td><?php echo $student[0]['roll'];?></td>
                    </tr>
                    <tr>
                        <td>Class</td>
                        <td><?php echo $student[0]['current_class'];?></td>
                    </tr>
                    <tr>
                        <td>Register Date</td>
                        <td><?php echo $student[0]['register_date'];?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        </div>
    </div>
</div>

<?php require_once('footer.php')?>

