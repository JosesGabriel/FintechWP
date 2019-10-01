<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <title><?php bloginfo('name'); ?></title>
    

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="/wp-content/plugins/um-friends/assets/css/um-friends.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/parts_style.css?<?php echo time(); ?>">
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/page_style.css?<?php echo time(); ?>">
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/responsive.css?<?php echo time(); ?>">
    <?php wp_head(); ?>
    <?php include "journal/header-files.php";?>
    
</head>
<body>
    <?php get_template_part('parts/global', 'header'); ?>