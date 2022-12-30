<script src="js/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        $updFields = $('.update');
        $updFields.each(function(i, item){
            $(item).dblclick(function(){
                $(this).removeAttr('readonly')
            })
            $(item).blur(function(){
                $.ajax ({
                    url: 'update.php',
                    type: 'POST',
                    data: {
                        date:$(this).val(),
                        id:$(this).data('id')
                    },
                    dataType: 'html',
                })
                $(this).attr('readonly', 'true')
            })
        })
    })
</script>
<?php
    include('connect.php');

    $search = $_POST['search'];
    $libelle = $_POST['libelle'];
    $date1 = $_POST['date1'];
    $date2 = $_POST['date2'];

    if (!empty($search)) {
        if (substr_count('"', $search) > 0) {
            $search = str_replace('"', '\"', $search);
        }
    }

    if (($libelle == '') && ($date1 == '') && ($date2 == '')) {
        // requête de filtrage des enregistrements de la base de données avec le mot clé de recherche saisi
        
        $req = $pdo->query("SELECT * FROM emissions WHERE (thEmi LIKE \"%$search%\" OR prEm LIKE \"%$search%\") ORDER BY datEmi DESC");
        $nbrEnr = $req->rowCount();
    }

    if (($libelle == '') && ($date1 == '') && ($date2 == '') && (empty($search))) {
        // requête de filtrage des enregistrements de la base de données avec le mot clé de recherche saisi
        
        $req = $pdo->query("SELECT * FROM emissions ORDER BY datEmi DESC");
        $nbrEnr = $req->rowCount();
    }

    elseif (($libelle != '') && ($date1 != '') && ($date2 != '')) {
        // requête de filtrage des enregistrements de la base de données avec le mot clé de recherche saisi, le libelle et les deux dates
        
        $req = $pdo->query("SELECT * FROM emissions WHERE (thEmi LIKE \"%$search%\" OR prEm LIKE \"%$search%\") AND (datEmi BETWEEN '$date1' AND '$date2') AND libEmi = '$libelle'  ORDER BY datEmi DESC");
        $nbrEnr = $req->rowCount();
    }

    elseif (($libelle != '') && ($date1 != '')) {
        // requête de filtrage des enregistrements de la base de données avec le libelle et la première date
        
        $req = $pdo->query("SELECT * FROM emissions WHERE libEmi = '$libelle' AND (thEmi LIKE \"%$search%\" OR prEm LIKE \"%$search%\") AND datEmi = '$date1' ORDER BY datEmi DESC");
        $nbrEnr = $req->rowCount();
    }

    elseif (($libelle != '') && ($date2 != '')) {
        // requête de filtrage des enregistrements de la base de données avec le libelle et la seconde date
        
        $req = $pdo->query("SELECT * FROM emissions WHERE libEmi = '$libelle' AND (thEmi LIKE \"%$search%\" OR prEm LIKE \"%$search%\") AND datEmi = '$date2' ORDER BY datEmi DESC");
        $nbrEnr = $req->rowCount();
    }

    elseif (($date1 != '') && ($date2 != '')) {
        // requête de filtrage des enregistrements de la base de données avec les dates
        
        $req = $pdo->query("SELECT * FROM emissions WHERE (thEmi LIKE \"%$search%\" OR prEm LIKE \"%$search%\") AND datEmi BETWEEN '$date1' AND '$date2' ORDER BY datEmi DESC");
        $nbrEnr = $req->rowCount();
    }

    elseif ($date1 != '') {
        // requête de filtrage des enregistrements de la base de données avec la première date
        
        $req = $pdo->query("SELECT * FROM emissions WHERE (thEmi LIKE \"%$search%\" OR prEm LIKE \"%$search%\") AND datEmi = '$date1' ORDER BY datEmi DESC");
        $nbrEnr = $req->rowCount();
    }

    elseif ($date2 != '') {
        // requête de filtrage des enregistrements de la base de données avec la seconde date
        
        $req = $pdo->query("SELECT * FROM emissions WHERE (thEmi LIKE \"%$search%\" OR prEm LIKE \"%$search%\") AND datEmi = '$date2' ORDER BY datEmi DESC");
        $nbrEnr = $req->rowCount();
    }

    elseif ($libelle != '') {
        // requête de filtrage des enregistrements de la base de données avec le libelle
        
        $req = $pdo->query("SELECT * FROM emissions WHERE libEmi = '$libelle' AND (thEmi LIKE \"%$search%\" OR prEm LIKE \"%$search%\") ORDER BY datEmi DESC");
        $nbrEnr = $req->rowCount();
    }



    if ($nbrEnr == 0) {
        // en cas de requête nulle, retourner le message ci-dessous
        echo '<center>Aucun enregistrement';
    }
    else {

        // affichage des informations retournées par la requête
        echo '
            <p class="my-3">Nombre d\'enregistrement : <b class="text-danger">'.$nbrEnr.'</b></p>
            <table class="table table-striped" style="border-radius: 50px;">
            <thead class="table-light">
                <tr>
                    <td>Libéllé</td>
                    <td>Thème</td>
                    <td><i class="fas fa-calendar-alt text-success"></i> Date</td>
                    <td><i class="fas fa-clock text-success"></i> Durée</td>
                    <td><i class="fa fa-user-tie text-success"></i> Présentateur</td>
                    <td><i class="fas fa-users text-success"></i> Invités</td>
                    <td><i class="fas fa-calendar-alt text-success"></i> Date de rédiffusion</td>
                </tr>
            </thead>
            <tbody style="vertical-align:middle">
        ';

        while ($data = $req->fetch()){
            echo '
                <tr>
                    <td>'.$data['libEmi'].'</td>
                    <td class="text-success">'.$data['thEmi'].'</td>
                    <td>'.$data['datEmi'].'</td>
                    <td>'.$data['durEmi'].'</td>
                    <td>'.$data['prEm'].'</td>
                    <td>
            ';

            // requête d'affichage des invités pour chaque emission de la base de données
            $req2 = $pdo->query("SELECT * FROM invites, inviter WHERE inviter.idInv = invites.idInv AND inviter.idEmi = '".$data['idEmi']."'");
            
            while ($data2 = $req2->fetch()) {
                echo $data2['nomInv'].'<br>';  
            }

            echo '
                    </td>
                    <td><input type="date" value="'.$data['datRdEmi'].'" data-id="'.$data['idEmi'].'" class="update form-control form-control-sm" readonly></td>
                </tr>
            ';
        }

        echo '
            </tbody>
            </table>
        ';
    }
?>