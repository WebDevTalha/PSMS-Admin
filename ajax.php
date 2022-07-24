<?php
require_once('config.php');

if(isset($_POST['class_id'])){

    $class_id = $_POST['class_id'];

    $stm = $pdo->prepare("SELECT subjects FROM class WHERE id=?");
    $stm->execute(array($class_id));
    $subjects_id = $stm->fetchAll(PDO::FETCH_ASSOC);
    $subjects_id = $subjects_id[0]['subjects'];


    $subject_list = json_decode($subjects_id);

    $get_subject_option = '';
    foreach($subject_list as $new_sub){

        $get_subject_option .= '<option value="'.$new_sub.'">'.getSubjectName($new_sub).'</option>';

        echo getSubjectName($new_sub)."<br>";
    }

    echo $get_subject_option;
}



// Get Class Subject List for attendance

if(isset($_POST['att_class_id'])){
    $class_id = $_POST['att_class_id']; 

    $stm=$pdo->prepare("SELECT subjects.name as subject_name,subjects.code as subject_code,subjects.id as subject_id  FROM class_routine  
    INNER JOIN subjects ON class_routine.subject_id=subjects.id 
    WHERE class_routine.class_name=?
    ");
    $stm->execute(array($class_id));
    $subject_list = $stm->fetchAll(PDO::FETCH_ASSOC);

    $get_subject_options = '';
    foreach($subject_list as $new_subject){
        $get_subject_options .= '<option value="'.$new_subject['subject_id'].'">'.$new_subject['subject_name'].'-'.$new_subject['subject_code'].'</option>';

    }  
    echo $get_subject_options ;

}