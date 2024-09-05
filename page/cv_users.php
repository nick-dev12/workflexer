<?php
// Démarre la session
session_start();
// Récupérez l'ID du commerçant à partir de la session
// Récupérez l'ID de l'utilisateur depuis la variable de session
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/navbare.css">
    <link rel="stylesheet" href="../css/cv_users.css">
</head>
<body>

<?php include('../navbare.php') ?>

<section class="section1">
    <div class="box1" >
        <h1>choisissez le model qui vous plait et personnalisez le !!</h1>
    </div>

    <div class="box2" >
        <a href="../model_cv/model1.php"><img src="../image/cv2.jpg" alt=""></a>
        <img src="../image/cv1.jpg" alt="">
        <img src="../image/cv3.jpg" alt="">
        <img src="../image/cv6.jpg" alt="">
        <img src="../image/cv4.jpg" alt="">
        <img src="../image/cv5.jpg" alt="">
    </div>
</section>
    
</body>
</html>