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
