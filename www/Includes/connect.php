<?php
include_once 'config.php';   // Já que functions.php não está incluso
header('Content-type: text/html; charset=utf-8');
$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
?>