<?php

    session_start();
    $_SESSION = array();
    session_regenerate_id(true);
    session_destroy();

    header("location: index.php");
    exit;
?>