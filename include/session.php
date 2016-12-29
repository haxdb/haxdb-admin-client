<?php
if (!isset($_SESSION["api_key"])){
    $url = $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . "/auth";
    header('Location: ' . $url, true, 303);
    print '<meta http-equiv="Location" content="' . $url . '">';
    print '<script> window.location = "' . $url . '"; </script>';
    die();
}
?>
