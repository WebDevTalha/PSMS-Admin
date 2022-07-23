<?php require_once('header.php')?>


<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white mr-2">
        <i class="mdi mdi-account-multiple"></i>                 
        </span>
        Assign Subject &nbsp;&nbsp;&nbsp; <a href="teacher_new_assing.php" class="btn btn-sm btn-success">New Assign</a>
    </h3>
</div>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
        <div class="card-body">
            <?php if(isset($_GET['delete']) == 'success') :?>
            <div class="alert alert-success">Teacher Data Delete Successfuly!</div>
            <?php endif;?>
            <table class="table table-bordered" id="all_teachers_table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Teacher Name</th>
                        <th>Subject Name</th>
                        <th>Subject Code</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $stm = $pdo->prepare("SELECT assign_teachers.id,teacher_id,subject_id,teachers.name AS teacher_name,subjects.name AS subject_name,code FROM assign_teachers 
                    INNER JOIN teachers ON assign_teachers.teacher_id = teachers.id
                    INNER JOIN subjects ON assign_teachers.subject_id = subjects.id
                    ");
                    $stm->execute();
                    $assignList = $stm->fetchAll(PDO::FETCH_ASSOC);
                    $i = 1;


                    foreach($assignList as $row) :                
                    ?>
                    <tr>
                        <td><?php echo $i; $i++;?></td>
                        <td><?php echo $row['teacher_name'];?></td>
                        <td><?php echo $row['subject_name'];?></td>
                        <td><?php echo $row['code'];?></td>
                        <td>
                            <a href="teacher_assign_edit.php?id=<?php echo $row['id'];?>" title="Edit" class="btn btn-sm btn-warning"><i class="mdi mdi-table-edit"></i></a>&nbsp;&nbsp;

                            <a href="teacher_assign_delete.php?id=<?php echo $row['id'];?>" title="Delete" onclick="return confirm('Are You Sure?')" class="btn btn-sm btn-danger delete-btn"><i class="mdi mdi-delete"></i></a>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
        </div>
    </div>
</div>

<?php require_once('footer.php')?>

<script>
    $(document).ready( function () {
        $('#all_teachers_table').DataTable();
    } );
</script>