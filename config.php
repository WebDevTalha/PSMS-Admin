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

// Count any Column Value count from any Table
function getCount($tbl,$col, $val) {
  global $pdo;
  $stm=$pdo->prepare("SELECT $col FROM $tbl WHERE $col=?");
  $stm->execute(array($val));
  $count = $stm->rowCount();
  return $count;
}