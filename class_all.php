<?php require_once('header.php')?>


<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white mr-2">
        <i class="mdi mdi-book-open-variant"></i>                 
        </span>
        All Class
    </h3>
</div>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
        <div class="card-body">
            <?php if(isset($_GET['delete']) == 'success') :?>
            <div class="alert alert-success">Class Data Delete Successfuly!</div>
            <?php endif;?>
            <table class="table table-bordered" id="all_teachers_table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Class Name</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Subjects</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $stm = $pdo->prepare("SELECT * FROM class");
                $stm->execute();
                $class_list = $stm->fetchAll(PDO::FETCH_ASSOC);
                $i = 1;

                foreach($class_list as $class) :                
                ?>
                <tr>
                    <td><?php echo $i; $i++;?></td>
                    <td><?php echo $class['class_name'];?></td>
                    <td><?php echo date('d-m-y',strtotime($class['start_date']));?></td>
                    <td><?php echo date('d-m-y',strtotime($class['end_date']));?></td>
                    <td><?php 
                    $subject_list = json_decode($class['subjects']);
                    foreach($subject_list as $new_sub){
                        echo getSubjectName($new_sub)."<br>";
                    }
                    
                    ?></td>
                    <td>
                        <a href="class_edit.php?id=<?php echo $class['id'];?>" title="Edit" class="btn btn-sm btn-warning"><i class="mdi mdi-table-edit"></i></a>&nbsp;&nbsp;

                        <a href="class_view.php?id=<?php echo $class['id'];?>" title="View" class="btn btn-sm btn-success"><i class="mdi mdi-eye"></i></a>
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