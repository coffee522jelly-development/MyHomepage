<?php
    session_start();
    header('Content-type: text/plain; charset= UTF-8');

    require_once('valid.php');

    $response = validation::check($_POST);

    foreach ($response as $mesg) {
        if ($mesg) {
            echo "<p>" . $mesg . "</p>";
        }
    }
    ?>
