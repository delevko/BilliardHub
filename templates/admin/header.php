<!DOCTYPE html>
<html>
<head>
    <title>Billiard Hub - <?=htmlspecialchars($title)?></title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="<?=PATH_H?>css/normalize.css">
    <link rel="stylesheet" type="text/css" href="<?=PATH_H?>css/navigation.css">
    <link rel="stylesheet" type="text/css" href="<?=PATH_H?>css/styles.css"> 
    <link rel="stylesheet" type="text/css" href="<?=PATH_H?>css/containers.css"> 
    

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<link rel="icon" type="image/x-icon" href="<?=PATH_H?>img/sl_logo.png">
	
	<link href="https://fonts.googleapis.com/css?family=Exo+2&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Merriweather:400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

	<link rel="stylesheet" type="text/css" href="<?=PATH_H?>css/admin_panel.css">
	<script type="text/javascript" src="<?=PATH_H?>js/admin_functions.js">
	</script>
	<script type="text/javascript" src="<?=PATH_H?>js/header_highlight.js">
	</script>
	<script type="text/javascript" src="<?=PATH_H?>js/mobile_navigation.js">
	</script>

	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

</head>


<body>
     <header>
        <!-- LOGO -->
        <a class="logo_box" href="<?=PATH_H?>">
        <img class="logo_img" src="<?=PATH_H?>img/sl_logo.png" alt="SnookerLviv">
        <span class="logo_text">billiard hub</span>
        </a>


        <!-- NAV MENU -->
         <nav class="navigation" id="header_navigation">
		<a class="icon"
                        onclick="mobileHeaderNav()">
                        <i class="fa fa-bars"></i>Меню
                </a>

                <a href="<?=PATH_H?>tournaments"
				id="tournaments">
					<i class="fas fa-trophy"></i>
					Турніри
				</a>
                <a href="<?=PATH_H?>players"
				id="players">
					<i class="fas fa-users"></i>
					Гравці
				</a>
                <a href="<?=PATH_H?>rankings"
				id="rankings">
					<i class="fas fa-medal"></i>
					Рейтинги
				</a>
                <a href="<?=PATH_H?>clubs"
				id="clubs">
					<i class="fas fa-shield-alt"></i>
					Клуби
				</a>
        </nav>

		<?php navButtonsRender(); ?>

	</header>

	<div class="container">
        <a class="admin_header" href="<?=PATH_H?>admin/">
            <span>Панель адміністратора</span>
        </a>


