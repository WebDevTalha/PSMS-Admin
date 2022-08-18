<?php require_once("header.php");?>

<?php

$stm=$pdo->prepare("SELECT current_class FROM students");
$stm->execute(array());
$count = $stm->rowCount();

$stm2=$pdo->prepare("SELECT id FROM teachers");
$stm2->execute(array());
$count2 = $stm2->rowCount();

$stm3=$pdo->prepare("SELECT id FROM class");
$stm3->execute(array());
$count3 = $stm3->rowCount();

?>


<div class="page-header">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-home"></i>                 
              </span>
              Teacher Dashboard
            </h3>
          </div>
          <div class="row">
            <div class="col-md-4 stretch-card grid-margin">
              <div class="card bg-gradient-danger card-img-holder text-white">
                <div class="card-body">
                  <img src="../images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image"/>
                  <h4 class="font-weight-normal mb-3">Total Students
                    <i class="mdi mdi-chart-line mdi-24px float-right"></i>
                  </h4>
                  <h2 class="mb-5"><?php echo $count; ?></h2>
                  <h6 class="card-text">Students</h6>
                </div>
              </div>
            </div>
            <div class="col-md-4 stretch-card grid-margin">
              <div class="card bg-gradient-info card-img-holder text-white">
                <div class="card-body">
                  <img src="../images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image"/>                  
                  <h4 class="font-weight-normal mb-3">Total Teachers
                    <i class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                  </h4>
                  <h2 class="mb-5"><?php echo $count2; ?></h2>
                  <h6 class="card-text">Teachers</h6>
                </div>
              </div>
            </div>
            <div class="col-md-4 stretch-card grid-margin">
              <div class="card bg-gradient-success card-img-holder text-white">
                <div class="card-body">
                  <img src="../images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image"/>                                    
                  <h4 class="font-weight-normal mb-3">Total Class
                    <i class="mdi mdi-diamond mdi-24px float-right"></i>
                  </h4>
                  <h2 class="mb-5"><?php echo $count3; ?></h2>
                  <h6 class="card-text">Class</h6>
                </div>
              </div>
            </div>
          </div>


<?php require_once("footer.php");?>