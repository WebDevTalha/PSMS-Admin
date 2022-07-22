<?php require_once('header.php')?>


<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white mr-2">
        <i class="mdi mdi-account-multiple"></i>                 
        </span>
        All Teachers
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
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Gender</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $stm = $pdo->prepare("SELECT * FROM teachers ORDER BY id DESC");
                $stm->execute();
                $teacher_list = $stm->fetchAll(PDO::FETCH_ASSOC);
                $i = 1;

                foreach($teacher_list as $teacher) :                
                ?>
                <tr>
                    <td><?php echo $i; $i++;?></td>
                    <td><?php echo $teacher['name'];?></td>
                    <td><?php echo $teacher['email'];?></td>
                    <td><?php echo $teacher['mobile'];?></td>
                    <td><?php echo $teacher['gender'];?></td>
                    <td>
                        <a href="teacher_edit.php?id=<?php echo $teacher['id'];?>" title="Edit" class="btn btn-sm btn-warning"><i class="mdi mdi-table-edit"></i></a>&nbsp;&nbsp;

                        <a href="teacher_view.php?id=<?php echo $teacher['id'];?>" title="View" class="btn btn-sm btn-success"><i class="mdi mdi-eye"></i></a>&nbsp;&nbsp;

                        <a href="teacher_delete.php?id=<?php echo $teacher['id'];?>" title="Delete" onclick="return confirm('Are You Sure?')" class="btn btn-sm btn-danger delete-btn"><i class="mdi mdi-delete"></i></a>
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