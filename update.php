<?php
    include('connect.php');
    $idEmi = $_POST['id'];
    $date = $_POST['date'];

    // requête de modifiaction de la date de réduffusion de l'emission
    $req = $pdo->query("UPDATE emissions SET datRdEmi = '$date' WHERE idEmi = $idEmi");
?>