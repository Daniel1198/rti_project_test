<?php
    $inv = $_POST;
    echo '<p class="mb-2"><b>Liste des invités</b></p>';
    echo '<table class="table table-success table-striped">';
    foreach($inv as $invite) {
        echo "<tr><td>$invite</td></tr>";
    }
    echo '</table>';
?>