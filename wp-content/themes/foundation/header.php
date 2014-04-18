<?php
$uploadDirPath = wp_upload_dir();
$getUploadDirPath = $uploadDirPath['url'];
?>
<!DOCTYPE html>
<!--[if IE 8]><html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
    <meta name="viewport" content="width=device-width">
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <link href="<?php echo get_template_directory_uri(); ?>/stylesheets/normalize.css" rel="stylesheet" media="screen">
    <link href="<?php echo get_template_directory_uri(); ?>/stylesheets/style.css" rel="stylesheet" media="screen">
    <script src="<?php echo get_template_directory_uri(); ?>/javascripts/vendor/custom.modernizr.js" type="text/javascript"></script>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <div id="banner">
        <!--<img src="<?php echo get_template_directory_uri(); ?>/images/site-banner-2.jpg">-->
        <h1><?php bloginfo('name'); ?></h1><br>
        <h2><?php bloginfo('description'); ?></h2>
    </div>
    <div class="container">
        <nav class="top-bar">
            <ul class="title-area">
                <li class="name"><h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo('name'); ?></a></h1></li>
                <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
            </ul>
            <section class="top-bar-section">
                <?php wp_nav_menu(array('theme_location' => 'primary-menu', 'menu_class' => 'left', 'container' => '', 'fallback_cb' => 'foundation_page_menu', 'walker' => new foundation_navigation())); ?>
            </section>
        </nav>
    </div>