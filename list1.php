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
    // requête d'affichage des enregistrements de la base de données
    $req = $pdo->query("SELECT * FROM emissions ORDER BY datEmi DESC");
    $nommbreEnr = $req->rowCount();

    if ($nommbreEnr == 0) {
        echo '<center>Aucun enregistrement pour l\'instant</center>';
    }
    else {
        echo '
            <p class="my-3">Nombre d\'enregistrement : <b class="text-danger">'.$nommbreEnr.'</b></p>
            <table class="table table-striped" style="border-radius: 50px;">
            <thead class="table-light">
                <tr>
                    <td>Libélé</td>
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