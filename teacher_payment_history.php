<?php require_once('header.php')?>

<?php


?>
<style>
   svg {
	overflow: hidden;
	vertical-align: middle;
	width: 60px;
	height: 40px;
}
</style>


<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white mr-2">
        <i class="mdi mdi-clock"></i>                 
        </span>
        Teachers Payment History
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
                  <th>Amount</th>
                  <th>Method</th>
                  <th>Payment Date & Time</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $stm = $pdo->prepare("SELECT * FROM teacher_payment_history ORDER BY id DESC");
                $stm->execute();
                $list = $stm->fetchAll(PDO::FETCH_ASSOC);
                $i = 1;

                foreach($list as $row) :                
                ?>
                <tr>
                  <td><?php echo $i;$i++;?></td>
                  <td><?php echo teacherData('name',$row['teacher_id']);?></td>
                  <td><?php echo number_format($row['amount']);?></td>
                  <td><?php echo $row['payment_method'];?></td>
                  <td><?php echo $row['created_at'];?></td>
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