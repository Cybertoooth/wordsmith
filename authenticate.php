<?php
session_start();
if (empty($_SESSION["username"])) {
    header("location: /signin/");
    exit();
}
?>
