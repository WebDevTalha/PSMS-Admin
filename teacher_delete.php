<?php
require_once('config.php');

$id = $_GET['id'];

$stm = $pdo->prepare("DELETE FROM teachers WHERE id=?");
$stm->execute(array($id));

header('location:teacher_all.php?delete=seccess');


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirecting</title>
    <style>
        body{
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            width: 100%;
        }
    </style>
</head>
<body>
    <h1>Redirecting</h1>
</body>
</html>