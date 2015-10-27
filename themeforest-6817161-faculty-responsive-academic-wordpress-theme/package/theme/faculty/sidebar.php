<a href="#sidebar" class="mobilemenu"><i class="fa fa-bars"></i></a>

<div id="sidebar">
    <div id="main-nav">
        <div id="nav-container">
            <div id="profile" class="clearfix">
                <div class="portrate hidden-xs">
                  <a href="<?php echo get_site_url();?>"><img src="<?php echo ot_get_option('personal_photo') ?>" alt="<?php echo ot_get_option( 'person_name' ); ?>"></a>
                </div>
                <div class="title">
                    <h2><?php echo ot_get_option( 'person_name' ); ?></h2>
                    <h3><?php echo ot_get_option( 'sub_title' ); ?></h3>
                </div>
                
            </div>

            	<?php    /**
                * Displays a navigation menu
                * @param array $args Arguments
                */
                
              
                wp_nav_menu( array(
                  'theme_location' => 'sidemenu',
                  'menu' => '',
                  'container' => false,
                  'menu_class' => false,
                  'items_wrap' => '<ul id = "navigation" class = "%2$s">%3$s</ul>',
                  'depth' => 0,
                  'walker' => ''//new fac_walker_nav_menu
                ) ); ?>

        </div>        
    </div>
    
    

    <div class="social-icons">
        <ul>
            <?php if (ot_get_option( 'si_email' )=="on"): ?>
            <li><a href="<?php echo ot_get_option( 'si_email_address' ); ?>"><i class="fa fa-envelope-o"></i></a></li>
            <?php endif; ?>

            <?php if (ot_get_option( 'si_facebook' )=="on"): ?>
            <li><a href="<?php echo ot_get_option( 'si_facebook_url' ); ?>"><i class="fa fa-facebook"></i></a></li>
            <?php endif; ?>
            <?php if (ot_get_option( 'si_twitter' )=="on"): ?>
            <li><a href="<?php echo ot_get_option( 'si_twitter_url' ); ?>"><i class="fa fa-twitter"></i></a></li>
            <?php endif; ?>
            
            <?php if (ot_get_option( 'si_gplus' )=="on"): ?>
            <li><a href="<?php echo ot_get_option( 'si_gplus_url' ); ?>"><i class="fa fa-google-plus"></i></a></li>
            <?php endif; ?>

            <?php if (ot_get_option( 'si_linkedin' )=="on"): ?>
            <li><a href="<?php echo ot_get_option( 'si_linkedin_url' ); ?>"><i class="fa fa-linkedin"></i></a></li>
            <?php endif; ?>
            <?php if (ot_get_option( 'si_academia' )=="on"): ?>
            <li><a href="<?php echo ot_get_option( 'si_academia_url' ); ?>"><i class="academia"></i></a></li>
            <?php endif; ?>
            <?php if (ot_get_option( 'si_rg' )=="on"): ?>
            <li><a href="<?php echo ot_get_option( 'si_rg_url' ); ?>"><i class="researchgate"></i></a></li>
            <?php endif; ?>

            

            <?php if (ot_get_option( 'si_youtube' )=="on"): ?>
            <li><a href="<?php echo ot_get_option( 'si_youtube_url' ); ?>"><i class="fa fa-youtube"></i></a></li>
            <?php endif; ?>
            
            <?php if (ot_get_option( 'si_instagram' )=="on"): ?>
            <li><a href="<?php echo ot_get_option( 'si_instagram_url' ); ?>"><i class="fa fa-instagram"></i></a></li>
            <?php endif; ?>
            <?php if (ot_get_option( 'si_flickr' )=="on"): ?>
            <li><a href="<?php echo ot_get_option( 'si_flickr_url' ); ?>"><i class="fa fa-flickr"></i></a></li>
            <?php endif; ?>
            <?php if (ot_get_option( 'si_pinterest' )=="on"): ?>
            <li><a href="<?php echo ot_get_option( 'si_pinterest_url' ); ?>"><i class="fa fa-pinterest"></i></a></li>
            <?php endif; ?>
            <?php if (ot_get_option( 'si_rss' )=="on"): ?>
            <li><a href="<?php echo ot_get_option( 'si_rss_url' ); ?>"><i class="fa fa-rss"></i></a></li>
            <?php endif; ?>
        </ul>
        <?php if (ot_get_option( 'copyright' )!=''): ?>
        <div id="copyright"><?php echo ot_get_option( 'copyright' ) ?></div>
        <?php endif; ?>
        
    </div>  

</div>