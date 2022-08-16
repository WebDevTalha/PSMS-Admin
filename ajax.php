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



// Get Bkash Number Amount
$teacher_id = $_POST['teacher_id'];

$stm5 = $pdo->prepare("SELECT * FROM teachers WHERE id=?");
$stm5->execute(array($teacher_id));
$teacher_list = $stm5->fetchAll(PDO::FETCH_ASSOC);
if(isset($_POST['amount'])) : ?>
<div class="row">
       <div class="col-lg-8 grid-margin stretch-card offset-md-2">
           <!-- preloader -->
            <div class="preloader-bg" id="preloader-bg">
               <div class="center">
               <div class="bouncywrap">
                     
                     <div class="dotcon dc1">
                     <div class="dot"></div>
                     </div>
                  
                     <div class="dotcon dc2">
                     <div class="dot"></div>
                     </div>
                  
                     <div class="dotcon dc3">
                     <div class="dot"></div>
                     </div>
               
               </div>
               </div>
            </div>
           <div class="card">
               <div class="card-body">
                  <div class="wrapper">
                     <div class="bkash-logo text-center">
                        <img src="images/bkash_payment.png" alt="Bkash" class="w-50">
                     </div>
                     <!-- price -->
                     <div class="invoice-n-price">
                        <div class="row align-items-center mb-3">
                           <div class="col-md-6">
                              <div class="invoice">
                                 <div class="web-logo">
                                    <img src="images/psms.png" alt="PSMS" class="rounded">
                                 </div>
                                 <div class="invoice-content">
                                    <p>PSMS</p>
                                    <p>Teacher Name: <?php echo $teacher_list[0]['name']; ?></p>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="price">
                              <p>৳ <?php echo $_POST['amount']; ?>.00</p>
                              </div>
                           </div>
                        </div>
                        <form class="payment-form" action="" method="POST">
                           <p>Teacher Bkash Account Number (<?php echo hideMobile($teacher_list[0]['mobile']); ?>)</p>
                           <input type="password" name="pin" placeholder="Enter Your Password">
                           <input type="hidden" name="salary_amount" value="<?php echo $_POST['amount']; ?>">
                           <div class="b-buttons">
                              <a href="teacher_payment.php">Close</a>
                              <button name="submit_btn" type="submit">Confirm</button>
                           </div>
                        </form>
                        <div class="call-btn">
                           <a href="tel:16247"><i class="fa-solid fa-phone"></i> 16247</a>
                        </div>
                     </div>
                  </div>
               </div>
           </div>
       </div>
   </div>
<?php endif; ?>