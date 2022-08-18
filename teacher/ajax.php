<?php
require_once('../config.php');

if(isset($_POST['class_id'])){
    $class_id = $_POST['class_id'];
    $teacher_id = $_POST['teacher_id'];

    $stm=$pdo->prepare("SELECT subjects.name as subject_name,subjects.code as subject_code,subjects.id as subject_id  FROM class_routine  
    INNER JOIN subjects ON class_routine.subject_id=subjects.id 
    WHERE class_routine.class_name=? AND class_routine.teacher_id=?
    ");
    $stm->execute(array($class_id,$teacher_id));
    $subject_list = $stm->fetchAll(PDO::FETCH_ASSOC);

    $get_subject_options = '';
    foreach($subject_list as $new_subject){
        $get_subject_options .= '<option value="'.$new_subject['subject_id'].'">'.$new_subject['subject_name'].'-'.$new_subject['subject_code'].'</option>';
         
    }  
    echo $get_subject_options ;
 
}



$i = 1;
$stm5=$pdo->prepare("SELECT * FROM notification WHERE t_status=?");
$stm5->execute(array(0));
$result = $stm5->fetchAll(PDO::FETCH_ASSOC);

// notification
foreach($result as $row3){
   if(isset($_POST['notify_'.$i])){
      $stm = $pdo->prepare("UPDATE notification SET t_status = ? WHERE id = ?");
      $stm->execute(array(1,$row3['id']));
   }
   $i++;
}


