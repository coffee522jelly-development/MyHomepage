<?php
    session_start();
    header('Content-type: text/plain; charset= UTF-8');

    require_once('validBM.php');

    $response = validationBM::check($_POST);

    foreach ($response as $mesg) {
        if ($mesg) {
            echo "<p>" . $mesg . "</p>";
        }
    }
    ?>
