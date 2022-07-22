<?php require_once('header.php')?>


<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white mr-2">
        <i class="mdi mdi-book-open-variant"></i>                 
        </span>
        All Subjects
    </h3>
</div>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
        <div class="card-body">
            <?php if(isset($_GET['delete']) == 'success') :?>
            <div class="alert alert-success">Subject Data Delete Successfuly!</div>
            <?php endif;?>
            <table class="table table-bordered" id="all_teachers_table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Subject Name</th>
                    <th>Subject Code</th>
                    <th>Subject Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $stm = $pdo->prepare("SELECT * FROM subjects ORDER BY id DESC");
                $stm->execute();
                $sub_list = $stm->fetchAll(PDO::FETCH_ASSOC);
                $i = 1;

                foreach($sub_list as $sub) :                
                ?>
                <tr>
                    <td><?php echo $i; $i++;?></td>
                    <td><?php echo $sub['name'];?></td>
                    <td><?php echo $sub['code'];?></td>
                    <td><?php echo $sub['type'];?></td>
                    <td>
                        <a href="subject_edit.php?id=<?php echo $sub['id'];?>" title="Edit" class="btn btn-sm btn-warning"><i class="mdi mdi-table-edit"></i></a>&nbsp;&nbsp;

                        <a href="subject_delete.php?id=<?php echo $sub['id'];?>" title="Delete" onclick="return confirm('Are You Sure?')" class="btn btn-sm btn-danger delete-btn"><i class="mdi mdi-delete"></i></a>
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