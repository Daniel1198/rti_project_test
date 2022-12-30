<?php
    include('connect.php');
    $libelle = htmlspecialchars($_POST['libelle']);
    $presentateur = htmlspecialchars($_POST['presentateur']);
    $realisateur = htmlspecialchars($_POST['realisateur']);
    $theme = htmlspecialchars($_POST['theme']);
    $heure = htmlspecialchars($_POST['heures']);
    $minutes = htmlspecialchars($_POST['minutes']);

    $date = htmlspecialchars($_POST['date']);
    $chaine = htmlspecialchars($_POST['chaine']);

    $query = $pdo->query("select * from emissions");
    $nbrEmi = $query->rowCount() + 1;

    ($minutes < 10) && ($minutes > 0) ? $minutes='0'.$minutes:null;
    ($heure < 10) && ($heure > 0) ? $heure='0'.$heure:null;
    if ($heure == 0) {
        $duree = $minutes.' min';
    }
    elseif ($minutes == 0) {
        $duree = $heure.' h';
    }
    elseif (($heure != 0) && ($minutes != 0)){
        $duree = $heure.' h '.$minutes.' min';
    }

    // requête d'insertion des informations de l'emission dans la base de données
    $req = $pdo->prepare("INSERT INTO emissions VALUES (:id, :libelle, :presentateur, :realisateur, :theme, :duree, :redif, :chaine, :datem)");
    $exec = $req->execute(array(":id"=>$nbrEmi, ":libelle"=>"$libelle", ":presentateur"=>"$presentateur", ":realisateur"=>"$realisateur", ":theme"=>"$theme", ":duree"=> "$duree", ":redif"=>"", ":chaine"=>"$chaine", ":datem"=>"$date"));

    $x = 1;
    for ($i = 8; $i < count($_POST); $i++) {
        $query = $pdo->query("select * from invites");
        $nbr = $query->rowCount() + 1;

        // requête d'insertion des informations des invités dans la base de données
        $req2 = $pdo->prepare("INSERT INTO invites VALUES (:id, :nom)");
        $exec2 = $req2->execute(array(":id"=>$nbr, ":nom"=>$_POST['invite'.$x.'']));

        $req3 = $pdo->prepare("INSERT INTO inviter VALUES (:emission, :invite)");
        $exec3 = $req3->execute(array(":emission"=>$nbrEmi, ":invite"=>$nbr));
        $x++;
    }

    // en cas d'echec de la requête 
    if (!$exec || !$exec2 || !$exec3) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fa fa-exclamation-triangle"></i> Echec de l\'enregistrement.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }

    // en cas de succès de la requête
    else {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa fa-check-circle"></i> Succès de l\'enregistrement.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
?>