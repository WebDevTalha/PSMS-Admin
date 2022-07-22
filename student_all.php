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
            <div class="alert alert-success">Student Data Delete Successfuly!</div>
            <?php endif;?>
            <table class="table table-bordered" id="all_teachers_table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Roll</th>
                    <th>Class</th>
                    <th>Mobile</th>
                    <th>Gender</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $stm = $pdo->prepare("SELECT * FROM students ORDER BY id DESC");
                $stm->execute();
                $student_list = $stm->fetchAll(PDO::FETCH_ASSOC);
                $i = 1;

                foreach($student_list as $student) :                
                ?>
                <tr>
                    <td><?php echo $i; $i++;?></td>
                    <td><?php echo $student['name'];?></td>
                    <td><?php echo $student['roll'];?></td>
                    <td><?php echo $student['current_class'];?></td>
                    <td><?php echo $student['mobile'];?></td>
                    <td><?php echo $student['gender'];?></td>
                    <td>
                        <a href="student_edit.php?id=<?php echo $student['id'];?>" title="Edit" class="btn btn-sm btn-warning"><i class="mdi mdi-table-edit"></i></a>&nbsp;&nbsp;
                        <a href="student_view.php?id=<?php echo $student['id'];?>" title="View" class="btn btn-sm btn-success"><i class="mdi mdi-eye"></i></a>&nbsp;&nbsp;
                        <a href="student_delete.php?id=<?php echo $student['id'];?>" title="Delete" onclick="return confirm('Are You Sure?')" class="btn btn-sm btn-danger delete-btn"><i class="mdi mdi-delete"></i></a>
                        <!-- <div class="delete_popup">
                            <p>Are You Sure?</p>
                            <span class="text-sm">NOTE: If Delete, This Student Data Will Remove Permanently!</span>
                            <div class="row">
                                <div class="col-sm-6"><a href="student_delete.php?id=" class="btn btn-danger">Delete</a></div>
                                <div class="col-sm-6"><a href="#" class="btn btn-success cancle-btn">Cancle</a></div>
                            </div>
                        </div> -->
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>
            </table>
        </div>
        </div>
    </div>
</div>

<!-- <div class="overlay"></div> -->



<?php require_once('footer.php')?>

<script>
    $(document).ready( function () {
        $('#all_teachers_table').DataTable();
    } );

    // function popupOpen(){
    //     $('.delete_popup, .overlay').show(500);
    // };
    // $('.cancle-btn, .overlay').on('click',function(){
    //     $('.delete_popup, .overlay').hide(0);
    // });
</script>