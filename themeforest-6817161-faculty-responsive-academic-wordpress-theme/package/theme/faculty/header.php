<?php
/**
 * @package WordPress
 * @subpackage faculty
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta http-equiv="X-UA-Compatible" content="chrome=1">
	<title>
		<?php
		global $page, $paged;
		wp_title( '|', true, 'right' );
		bloginfo( 'name' );
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) )
			echo " | $site_description";
		if ( $paged >= 2 || $page >= 2 )
			echo ' | ' . sprintf( __( 'Page %s', 'themename' ), max( $paged, $page ) );
		?>
	</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	
    <?php wp_head(); ?>
	</head>
	
	<body  <?php body_class( ); ?>>
	
        <div id="wrapper">
            <?php get_sidebar(); ?>

            <div id="main">