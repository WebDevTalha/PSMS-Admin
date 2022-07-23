<?php require_once('header.php')?>
<?php 

$teacher_id = $_GET['id'];

$stm = $pdo->prepare("SELECT * FROM class WHERE id=?");
$stm->execute(array($teacher_id));
$class_data = $stm->fetchAll(PDO::FETCH_ASSOC);     




?>

<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white mr-2">
        <i class="mdi mdi-account"></i>                 
        </span>
        <?php echo $class_data[0]['class_name']?>'s Data
    </h3>
</div>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
        <div class="card-body">
            <table class="table table-bordered" id="all_teachers_table">
                <tbody>
                    <tr>
                        <td>Class Name</td>
                        <td><?php echo $class_data[0]['class_name'];?></td>
                    </tr>
                    <tr>
                        <td>Start Date</td>
                        <td><?php echo $class_data[0]['start_date'];?></td>
                    </tr>
                    <tr>
                        <td>End DAte</td>
                        <td><?php echo $class_data[0]['end_date'];?></td>
                    </tr>
                    <tr>
                        <td>Subjects</td>
                        <td><?php 
                        $subject_list = json_decode($class_data[0]['subjects']);
                        foreach($subject_list as $new_sub){
                            echo getSubjectName($new_sub)."<br>";
                        }
                        ?></td>
                    </tr>
                    <tr>
                        <td>Register Date</td>
                        <td><?php echo $class_data[0]['created_at'];?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        </div>
    </div>
</div>

<?php require_once('footer.php')?>

