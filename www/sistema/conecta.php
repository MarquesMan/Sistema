<?php

date_default_timezone_set ( 'America/Campo_Grande' );
error_reporting (E_ALL);
ini_set('display_errors', 'On');


$mysqli = new mysqli("localhost", "root", "", "sistema");

mysqli_set_charset($mysqli,"utf8");

?>