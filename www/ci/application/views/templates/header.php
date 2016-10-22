<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" lang="pt-BR">
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" lang="pt-BR">
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html lang="pt-BR">
<!--<![endif]-->

	<head>

		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">



		<link rel="stylesheet" href="<?php echo base_url('includes/bootstrap/_css/bootstrap.min.css') ?>">
		<link rel="stylesheet" href="<?php echo base_url('includes/bootstrap/_css/default.css') ?>">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script src="<?php echo base_url('includes/bootstrap/_js/jquery.maskedinput.js') ?>"></script>
		<script src="<?php echo base_url('includes/bootstrap/_js/bootstrap.min.js') ?>"></script>


		<title><?php echo $title; ?></title>

	</head>


	<body>

		<?php $data_menu['user_permissions'] = $user_permissions;
		      $this->view('templates/menu', $data_menu); ?>

		<div class="container-fluid pg-w word-s">


