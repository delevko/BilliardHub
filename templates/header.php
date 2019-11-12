<!DOCTYPE html>
<html>
<head>
    <title>Billiar Hub - <?=htmlspecialchars($title)?></title>
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

	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

	<script type="text/javascript" src="<?=PATH_H?>js/functions.js">
	</script>
</head>


<body>
     <header>
        <!-- LOGO -->
        <div class="logo_box">
        <img class="logo_img" src="<?=PATH_H?>img/sl_logo.png" alt="SnookerLviv">
        <span class="logo_text">billiard hub</span>
        </div>


        <!-- NAV MENU -->
         <nav class="navigation" id="myTopnav">
                <a href="<?=PATH_H?>tournaments"
				id="tournaments">
					Турніри
				</a>
                <a href="<?=PATH_H?>players"
				id="players">
					Гравці
				</a>
                <a href="<?=PATH_H?>rankings"
				id="rankings">
					Рейтинги
				</a>
                <a href="<?=PATH_H?>clubs"
				id="clubs">
					Клуби
		</a>
        </nav>

		<script type="text/javascript" src="<?=PATH_H?>js/header_highlight.js">
		</script>

		<?php navButtonsRender(); ?>

	</header>

	<div class="container">


