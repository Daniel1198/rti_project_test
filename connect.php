<?php
    try {
        $pdo = new PDO('mysql:host=localhost; dbname=bd_rti_emissions;', 'root', '');
    }catch (Exception $e) {
        die('Erreur : '.$e->getMessage());
    } 
?>