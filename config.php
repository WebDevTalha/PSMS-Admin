<?php
$host = "localhost";
$db_name = "psms";
$user = "root";
$password = "";

date_default_timezone_set("Asia/Dhaka");
try {
  $pdo = new PDO("mysql:host=$host;dbname=$db_name", $user, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}



// Count any Column Value from Profile Table
// function pfRowCount($col, $val) {
//   global $pdo;
//   $stm=$pdo->prepare("SELECT $col FROM students WHERE $col=?");
//   $stm->execute(array($val));
//   $count = $stm->rowCount();
//   return $count;
// }

// Count any Column Value from Profile Table
function teacharCount($col, $val) {
  global $pdo;
  $stm=$pdo->prepare("SELECT $col FROM teachers WHERE $col=?");
  $stm->execute(array($val));
  $count = $stm->rowCount();
  return $count;
}

// GET Student Data
function student($col,$id){
  global $pdo;
  $stm = $pdo->prepare("SELECT $col FROM students WHERE id=?");
  $stm->execute(array($id));
  $result = $stm->fetchAll(PDO::FETCH_ASSOC);
  return $result[0][$col];
}


// GET Admin Data
function admin($col,$id){
  global $pdo;
  $stm = $pdo->prepare("SELECT $col FROM admin WHERE id=?");
  $stm->execute(array($id));
  $result = $stm->fetchAll(PDO::FETCH_ASSOC);
  return $result[0][$col];
}

// GET Teacher Data
function teacherData($col,$id){
  global $pdo;
  $stm = $pdo->prepare("SELECT $col FROM teachers WHERE id=?");
  $stm->execute(array($id));
  $result = $stm->fetchAll(PDO::FETCH_ASSOC);
  return $result[0][$col];
}

// GET Subject Name And Code
function getSubjectName($id){
  global $pdo;
  $stm = $pdo->prepare("SELECT name,code FROM subjects WHERE id=?");
  $stm->execute(array($id));
  $result = $stm->fetchAll(PDO::FETCH_ASSOC);
  return $result[0]['name']." - ".$result[0]['code'];
}


// GET Subject Name And Code
function getSubjectTeacher($id){
  global $pdo;
  $stm = $pdo->prepare("SELECT teacher_id FROM assign_teachers WHERE subject_id=?");
  $stm->execute(array($id));
  $result = $stm->fetchAll(PDO::FETCH_ASSOC);
  return $result[0]['teacher_id'];
}

// Get Teacher Name From Subject ID
function getSubjectTeacherName($id){
  global $pdo;
  $stm=$pdo->prepare("SELECT teacher_id FROM assign_teachers WHERE subject_id=?");
  $stm->execute(array($id));
  $result = $stm->fetchAll(PDO::FETCH_ASSOC);
  $teacher_id =  $result[0]['teacher_id'];

  $stm=$pdo->prepare("SELECT name FROM teachers WHERE id=?");
  $stm->execute(array($teacher_id));
  $result = $stm->fetchAll(PDO::FETCH_ASSOC);
  return  $result[0]['name'];
}


// Get Exam Name form Exam ID
function getExamName($id){
  if($id == 1){
      return "First Term Exam";
  }
  else if($id == 2){
      return "Second Term Exam"; 
  }
  else if($id == 3){
      return "Final Term Exam"; 
  }
}


// Count any Column Value count from any Table
function getCount($tbl,$col, $val) {
  global $pdo;
  $stm=$pdo->prepare("SELECT $col FROM $tbl WHERE $col=?");
  $stm->execute(array($val));
  $count = $stm->rowCount();
  return $count;
}

// GET any Data
function getColData($col,$tbl,$id){
  global $pdo;
  $stm = $pdo->prepare("SELECT $col FROM $tbl WHERE id=?");
  $stm->execute(array($id));
  $result = $stm->fetchAll(PDO::FETCH_ASSOC);
  return $result[0][$col];
}

function getClassName($id,$col){
  global $pdo;
  $stm=$pdo->prepare("SELECT $col FROM class WHERE id=?");
  $stm->execute(array($id));
  $result = $stm->fetchAll(PDO::FETCH_ASSOC);
  return $result[0][$col];
}

// Get Teacher Info
function getTeacherInfo($id,$col){
  global $pdo;
  $stm=$pdo->prepare("SELECT $col FROM teachers WHERE id=?");
  $stm->execute(array($id));
  $result = $stm->fetchAll(PDO::FETCH_ASSOC);
  return $result[0][$col];
}

// Hide Email With Star *
function emailHide($email){
  $string = $email;
  preg_match('/^.\K[a-zA-Z\.0-9]+(?=.@)/',$string,$matches);//here we are gathering this part bced

  $replacement= implode("",array_fill(0,strlen($matches[0]),"*"));//creating no. of *'s
  return preg_replace('/^(.)'.preg_quote($matches[0])."/", '$1'.$replacement, $string);
}

// Hide Mobile With Star *
function hideMobile($phone){
  $phone;
  return substr($phone, 0, 3) . "** ***" . substr($phone, 8, 3);
}