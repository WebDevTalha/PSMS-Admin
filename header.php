<?php require_once("config.php");?>
<?php 
session_start();

if(!isset($_SESSION['admin_loggedin'])){
    header('location:login.php');
}

$user_id = $_SESSION['admin_loggedin'][0]['id'];

$admin_name = admin('name',$user_id);

$profile_photo = admin('profile_photo',$user_id);


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Admin Dashboard</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="css/jquery.data_tables.min.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <!-- Fontawsome css -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/style.css">
  
<style>
    .delete_popup {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
    text-align: center;
    background: #fff;
    padding: 45px 55px;
    z-index: 99999;
    display: none;
}

.delete_popup p {
    font-size: 30px;
    font-weight: 600;
}

.delete_popup span {
    font-size: 13px;
    margin-bottom: 20px;
    display: inline-block;
}
.overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    z-index: 9999;
    display: none;
}
</style>
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
</head>
<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="index.php"><img src="images/logo.png" alt="logo"/></a>
        <a class="navbar-brand brand-logo-mini" href="index.php"><img src="images/logo-mini.svg" alt="logo"/></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
              <div class="nav-profile-img">
                <img src="<?php if($profile_photo == null){
                                    echo 'images/uploads/user.png';
                                } else {
                                    echo $profile_photo;
                                } ?>" alt="image">
                <span class="availability-status online"></span>             
              </div>
              <div class="nav-profile-text">
                <p class="mb-1 text-black"><?php echo $admin_name;?></p>
              </div>
            </a>
            <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
              <a class="dropdown-item" href="change_profile_photo.php">
                <i class="mdi mdi-account-circle mr-2 text-success"></i>
                Set profile Picture
              </a>
              <a class="dropdown-item" href="#">
                <i class="mdi mdi-settings mr-2 text-success"></i>
                Settings
              </a>
              <a class="dropdown-item" href="change_password.php">
                <i class="mdi mdi-lock mr-2 text-success"></i>
                Change Password
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="logout.php">
                <i class="mdi mdi-logout mr-2 text-primary"></i>
                Logout
              </a>
            </div>
          </li>
          <li class="nav-item d-none d-lg-block full-screen-link">
            <a class="nav-link">
              <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
            </a>
          </li>
          <?php
          $stm=$pdo->prepare("SELECT * FROM notification WHERE status=?");
          $stm->execute(array(0));
          $result = $stm->fetchAll(PDO::FETCH_ASSOC);

          ?>
          <li class="nav-item dropdown">
            <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
              <i class="mdi mdi-bell-outline"></i>
              <?php if(!empty($result)) :?>
              <span class="count-symbol bg-danger"></span>
              <?php endif; ?>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
              <h6 class="p-3 mb-0">Notifications</h6>
              <div class="dropdown-divider"></div>
              
              <?php if(empty($result)) :?>
                <a class="dropdown-item preview-item btn">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-success">
                    <i class="mdi mdi-sync-alert"></i>
                  </div>
                </div>
                <div class="preview-item-content">
                  <p class="text-gray ellipsis mb-0">
                    No Notifications Here
                  </p>
                </div>
              </a>
              <?php endif;?>
              <?php foreach($result as $row) :?>
              
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-success">
                    <?php if($row['type'] == "t_pay") :?>
                    <i class="mdi mdi-cash-usd"></i>
                    <?php elseif($row['type'] == "st_pay") :?>
                    <i class="mdi mdi-cash-usd"></i>
                    <?php elseif($row['type'] == "reg") :?>
                    <i class="mdi mdi-account"></i>
                    <?php endif; ?>
                  </div>
                </div>
                <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                  <h6 class="preview-subject font-weight-normal mb-1"><?php 
                  if($row['type'] == "t_pay"){
                    echo getTeacherInfo($row['teacher_id'],'name');
                  }
                  else if($row['type'] == "st_pay"){
                    echo student('name',$row['st_id']);
                  }
                  else if($row['type'] == "reg"){
                    echo $row['reg_name'];
                  }
                  
                  ?></h6>
                  <p class="text-gray ellipsis mb-0">
                    <?php 
                    if($row['type'] == "t_pay"){
                      echo "Received ৳".number_format(getTeacherInfo($row['teacher_id'],'last_amount'))." Taka At ".$row['created_at'];
                    }
                    else if($row['type'] == "st_pay"){
                      echo "Send ৳".number_format(student('last_amount',$row['st_id']))." Taka At ".$row['created_at'];
                    }
                    else if($row['type'] == "reg"){
                      echo "Has Created His Account!";
                    }
                    ?>
                  </p>
                </div>
              </a>
              <?php endforeach; ?>
              <div class="dropdown-divider"></div>
            </div>
          </li>
          <li class="nav-item nav-logout d-none d-lg-block" title="Logout">
            <a class="nav-link" href="logout.php">
              <i class="mdi mdi-power"></i>
            </a>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
              <div class="nav-profile-image">
                <img src="<?php if($profile_photo == null){
                                    echo 'images/uploads/user.png';
                                } else {
                                    echo $profile_photo;
                                } ?>" alt="profile">
                <span class="login-status online"></span> <!--change to offline or busy as needed-->              
              </div>
              <div class="nav-profile-text d-flex flex-column">
                <span class="font-weight-bold mb-2"><?php echo $admin_name;?></span>
                <span class="text-secondary text-small">PSMS Admin</span>
              </div>
              <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php">
              <span class="menu-title">Dashboard</span>
              <i class="mdi mdi-home menu-icon"></i>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-6" aria-expanded="false" aria-controls="ui-6">
              <span class="menu-title">Class Routine</span>
              <i class="menu-arrow"></i>
              <i class="mdi mdi-crosshairs-gps menu-icon"></i>
            </a>
            <div class="collapse" id="ui-6">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="routine_all.php">All Routine</a></li>
                <li class="nav-item"> <a class="nav-link" href="routine_add_new.php">Add New</a></li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-5" aria-expanded="false" aria-controls="ui-5">
              <span class="menu-title">Classes</span>
              <i class="menu-arrow"></i>
              <i class="mdi mdi-crosshairs-gps menu-icon"></i>
            </a>
            <div class="collapse" id="ui-5">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="class_all.php">All Classes</a></li>
                <li class="nav-item"> <a class="nav-link" href="class_add_new.php">Create New Class</a></li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-4" aria-expanded="false" aria-controls="ui-4">
              <span class="menu-title">Subjects</span>
              <i class="menu-arrow"></i>
              <i class="mdi mdi-crosshairs-gps menu-icon"></i>
            </a>
            <div class="collapse" id="ui-4">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="subject_all.php">All Subjects</a></li>
                <li class="nav-item"> <a class="nav-link" href="subject_add_new.php">Add New</a></li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <span class="menu-title">Students</span>
              <i class="menu-arrow"></i>
              <i class="mdi mdi-crosshairs-gps menu-icon"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="student_all.php">All Students</a></li>
                <li class="nav-item"> <a class="nav-link" href="">Search</a></li>
                <li class="nav-item"> <a class="nav-link" href="">Results</a></li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
                <a class="nav-link" href="attendance.php">
                <span class="menu-title">Attendance</span>
                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
                </a>
            </li>

          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-2" aria-expanded="false" aria-controls="ui-2">
              <span class="menu-title">Teachers</span>
              <i class="menu-arrow"></i>
              <i class="mdi mdi-crosshairs-gps menu-icon"></i>
            </a>
            <div class="collapse" id="ui-2">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="teacher_all.php">All Teachers</a></li>
                <li class="nav-item"> <a class="nav-link" href="teacher_add_new.php">Add New</a></li>
                <li class="nav-item"> <a class="nav-link" href="teacher_assign_subject.php">Assign Subject</a></li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#ui-66" aria-expanded="false" aria-controls="ui-66">
                <span class="menu-title">Students Marks</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
                </a>
                <div class="collapse" id="ui-66">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="student_marks.php">Students Marks</a></li>

                </ul>
                </div>
            </li>

          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-3" aria-expanded="false" aria-controls="ui-3">
              <span class="menu-title">Payments</span>
              <i class="menu-arrow"></i>
              <i class="mdi mdi-crosshairs-gps menu-icon"></i>
            </a>
            <div class="collapse" id="ui-3">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="teacher_payment.php">Teacher Payment</a></li>
                <li class="nav-item"> <a class="nav-link" href="">Teacher Payment History</a></li>
                <li class="nav-item"> <a class="nav-link" href="">Student Payments</a></li>
              </ul>
            </div>
          </li>

          <!-- <li class="nav-item">
            <a class="nav-link" href="error-404.php">
              <span class="menu-title">Icons</span>
              <i class="mdi mdi-contacts menu-icon"></i>
            </a>
          </li> -->

        </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">