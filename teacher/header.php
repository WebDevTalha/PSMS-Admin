<?php require_once("../config.php");?>
<?php 
session_start();

if(!isset($_SESSION['teacher_loggedin'])){
    header('location:login.php');
}

$user_id = $_SESSION['teacher_loggedin'][0]['id'];

$admin_name = teacherData('name',$user_id);

$profile_photo = teacherData('profile_photo', $user_id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Admin Dashboard</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../css/jquery.data_tables.min.css">
  <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css">
  <!-- Fontawsome css -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../images/favicon.png" />
  <style>
    .text-animate{
      color: #1bcfb4;
      font-weight: 600;
      animation: cAnimate 2s linear infinite;
    }
    @keyframes cAnimate {
      0%{
        color: #000;
      }
      40%{
        color: #1bcfb4;
      }
      60%{
        color: #1bcfb4;
      }
      100%{
        color: #000;
      }
    }
  </style>
</head>
<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="index.php"><img style="object-fit: contain;" src="../images/teacher_admin.png" alt="logo"/></a>
        <a class="navbar-brand brand-logo-mini" href="index.php"><img src="../images/logo-mini.svg" alt="logo"/></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <ul class="navbar-nav navbar-nav-right">
          <?php
          $stm6=$pdo->prepare("SELECT * FROM teachers WHERE id=?");
          $stm6->execute(array($user_id));
          $result6 = $stm6->fetchAll(PDO::FETCH_ASSOC);

          ?>
          <li class="nav-item">
            <p class="m-0 text-black fw-bolder fs-2 text-animate">Last Salary <span>৳ <?php if($result6[0]['last_amount'] != null){
              echo number_format($result6[0]['last_amount']);
            } else {
              echo "0";
            } ?></span> BDT.</p>
          </li>
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
              <div class="nav-profile-img">
              <?php if($profile_photo == null){
                echo '<img alt="" src="uploads/user.png">';
              } else {
                echo '<img alt="" src="'.$profile_photo.'">';
              } ?>
                <span class="availability-status online"></span>             
              </div>
              <div class="nav-profile-text">
                <p class="mb-1 text-black"><?php echo $admin_name;?></p>
              </div>
            </a>
            <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
              <a class="dropdown-item" href="profile.php">
                <i class="mdi mdi-account-circle mr-2 text-success"></i>
                Profile
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
          $stm=$pdo->prepare("SELECT * FROM notification WHERE t_status=?");
          $stm->execute(array(0));
          $result = $stm->fetchAll(PDO::FETCH_ASSOC);

          ?>
          <script>
          setInterval(myTimer, 1000);

          function myTimer() {
            document.getElementById("notification_reload");
          }
          </script>
          <li class="nav-item dropdown" id="notification_reload">
            <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
              <i class="mdi mdi-bell-outline"></i>
              <?php if(!empty($result)) :?>
              <span class="count-symbol bg-danger notifyRemo"></span>
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
              <?php $i=1; foreach($result as $row) :?>

                <input type="hidden" name="id" id="id_<?php echo $i; $i++; ?>" value="<?php echo $row['id']; ?>">
              
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
                    echo "Congress ".getTeacherInfo($row['teacher_id'],'name');
                  }
                  
                  ?></h6>
                  <p class="text-gray ellipsis mb-0">
                    <?php 
                    if($row['type'] == "t_pay"){
                      echo "You Have Received ৳".number_format(getTeacherInfo($row['teacher_id'],'last_amount'))." Taka From Admin At ".$row['created_at'];
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
              <?php if($profile_photo == null){
                echo '<img alt="" src="uploads/user.png">';
              } else {
                echo '<img alt="" src="'.$profile_photo.'">';
              } ?>
                <span class="login-status online"></span> <!--change to offline or busy as needed-->              
              </div>
              <div class="nav-profile-text d-flex flex-column">
                <span class="font-weight-bold mb-2"><?php echo $admin_name;?></span>
                <span class="text-secondary text-small">PSMS Teacher</span>
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
            <a class="nav-link" href="class_routine.php">
              <span class="menu-title">Class Routine</span>
              <i class="mdi mdi-crosshairs-gps menu-icon"></i>
            </a>
          </li>


          <li class="nav-item">
            <a class="nav-link" href="assigned_class.php">
              <span class="menu-title">Assigned Class</span>
              <i class="mdi mdi-crosshairs-gps menu-icon"></i>
            </a>
          </li>


          <li class="nav-item">
            <a class="nav-link" href="assigned_subject.php">
              <span class="menu-title">Assigned Subject</span>
              <i class="mdi mdi-crosshairs-gps menu-icon"></i>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-5" aria-expanded="false" aria-controls="ui-5">
              <span class="menu-title">Attendance</span>
              <i class="menu-arrow"></i>
              <i class="mdi mdi-crosshairs-gps menu-icon"></i>
            </a>
            <div class="collapse" id="ui-5">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="attendance_new.php">New Attendance</a></li>
                <li class="nav-item"> <a class="nav-link" href="attendance_history.php">Attendance History</a></li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-6" aria-expanded="false" aria-controls="ui-6">
              <span class="menu-title">Submit Exam Marks</span>
              <i class="menu-arrow"></i>
              <i class="mdi mdi-crosshairs-gps menu-icon"></i>
            </a>
            <div class="collapse" id="ui-6">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="mark_new.php">New Marks</a></li>
                <li class="nav-item"> <a class="nav-link" href="mark_history.php">Marks History</a></li>
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
                <li class="nav-item"> <a class="nav-link" href="students.php">All Students</a></li>
              </ul>
            </div>
          </li>
        </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">