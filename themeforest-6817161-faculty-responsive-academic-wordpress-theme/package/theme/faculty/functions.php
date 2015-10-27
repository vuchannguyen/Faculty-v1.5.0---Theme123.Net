<?php
/**
 * @package WordPress
 * @subpackage faculty
 */

/**
 * Optional: set 'ot_show_pages' filter to false.
 * This will hide the settings & documentation pages.
 */
add_filter( 'ot_show_pages', '__return_false' );

/**
 * Optional: set 'ot_show_new_layout' filter to false.
 * This will hide the "New Layout" section on the Theme Options page.
 */
add_filter( 'ot_show_new_layout', '__return_false' );

/*
* Required: set 'ot_theme_mode' filter to true.
*/ 
add_filter( 'ot_theme_mode', '__return_true' );

/**
 * Required: include OptionTree.
 */
load_template( trailingslashit( get_template_directory() ) . 'option-tree/ot-loader.php' );

/**
 * Theme Options
 */
load_template( trailingslashit( get_template_directory() ) . 'includes/theme-options.php' );


/**
 * Make theme available for translation
 * Translations can be filed in the /languages/ directory
 */
load_theme_textdomain( 'faculty', get_template_directory() . '/languages' );

$locale = get_locale();
$locale_file = get_template_directory() . "/languages/$locale.php";
if ( is_readable( $locale_file ) )
	require_once( $locale_file );

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 900;


/**
 * Enqueue the Google fonts.
 */
function fac_google_fonts() {
    $protocol = is_ssl() ? 'https' : 'http';
    wp_enqueue_style( 'faculty-lato', "$protocol://fonts.googleapis.com/css?family=Lato:100,300,400,700,100italic,300italic,400italic" );}
add_action( 'wp_enqueue_scripts', 'fac_google_fonts' );



/**
* Enqueue scripts and styles for the front end.
* @since Faculty 1.0
* @return void
*/
add_action('wp_enqueue_scripts', 'faculty_add_scripts');
function faculty_add_scripts() {
    // wp_deregister_script( 'jquery' );
    // wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js');
    wp_enqueue_script( 'jquery' );

    //add modernizr
	wp_enqueue_script( 'modernizer', get_template_directory_uri() . '/js/modernizr.custom.63321.js');

    //add bootstrap.min.js
	wp_enqueue_script( 'bootstrap-script', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ),'',true );

	//add touchSwip plugin
	wp_enqueue_script( 'touchSwip', get_template_directory_uri() . '/js/jquery.touchSwipe.min.js', array( 'jquery' ),'',true );

	//add mouswheel plugin
	wp_enqueue_script( 'mouswheel', get_template_directory_uri() . '/js/jquery.mousewheel.js', array( 'jquery' ),'',true );

	//add carouFredSel
	wp_enqueue_script( 'carouFredSel', get_template_directory_uri() . '/js/jquery.carouFredSel-6.2.1-packed.js', array( 'jquery' ),'',true );

	//add dropdown plugin
	wp_enqueue_script( 'dropdown', get_template_directory_uri() . '/js/jquery.dropdownit.js', array( 'jquery' ),'',true );

	//add mixitup plugin
	wp_enqueue_script( 'mixitup', get_template_directory_uri() . '/js/jquery.mixitup.min.js', array( 'jquery' ),'',true );

	//add touchSwip plugin
	wp_enqueue_script( 'touchSwip', get_template_directory_uri() . '/js/jquery.touchSwipe.min.js', array( 'jquery' ),'',true );

	//add magnific-popup
	wp_enqueue_script( 'magnific-popup', get_template_directory_uri() . '/js/magnific-popup.js', array( 'jquery' ),'',true );
	
	//add masonry
	wp_enqueue_script( 'masonry', get_template_directory_uri() . '/js/masonry.min.js','','',true);

	//add perfect scroll
	wp_enqueue_script( 'perfect-scroll', get_template_directory_uri() . '/js/perfect-scrollbar-0.4.5.with-mousewheel.min.js', array('jquery'),'',true);

	//add scrollTo
	wp_enqueue_script( 'scrollTo', get_template_directory_uri() . '/js/ScrollToPlugin.min.js', array('jquery'),'',true);

	//add tweenmax
	wp_enqueue_script( 'tweenmax', get_template_directory_uri() . '/js/TweenMax.min.js','','',true);

	//add imagesLoaded
	wp_enqueue_script( 'imagesloaded', get_template_directory_uri() . '/js/imagesloaded.js','','',true);

    //add faculty custom.js
	wp_enqueue_script( 'faculty-script', get_template_directory_uri() . '/js/custom.js', array( 'jquery' ),'',true );

	// comments
	wp_enqueue_script( 'comment-reply' );
}    

/**
* Inject custome script
* @since v1.1.0 
*/
function fac_custom_js() {
  
    $script = 
		'var siteUrl = "'.home_url().'";';
	if (is_singular())
	{
		$script .= ' var isSingle = true;';
		$script .= ' var blogUrl = "'.home_url().'/blog/";';
	}

	if ( function_exists( 'ot_get_option' ) ){
		
		$script .= ' var perfectScroll = "'.ot_get_option('no_perfect_scroll').'";';
		
		$script .= ' var blogAjaxState = "'.ot_get_option('blog_ajax').'";';	
		
		if (ot_get_option('pub_filter_preset')=='') 
			$pubfilter = "false"; 
		else 
			$pubfilter = ot_get_option('pub_filter_preset');
		$script .= ' var pubsFilter = "'.$pubfilter.'";';	
		
	}

    echo '<script type="text/javascript">'.$script.'</script>';
}
add_action('wp_head', 'fac_custom_js');


/**
* Inject custome styles
* @since v1.1.0 
*/
function fac_custom_css() {
  
   	if ( function_exists( 'ot_get_option' ) ){
   		$styles='';
   		if (ot_get_option('no_perfect_scroll')=='off'){
   			$styles.='
	   		#blog-content,
	   		#archive-content,
	   		.fac-page,.home{
	   			overflow:auto;
   			}';
   		}
   		if (ot_get_option('circle_around_logo')=='off'){
   			$styles .= '
   			#profile .portrate img{
   				border-radius : inherit;
   				-webkit-border-radius: inherit;
   				-moz-border-radius: inherit;
   			}
   			';
   		}
   		$styles .= '
   		ul#navigation li.external:hover .fa, 
		ul#navigation li.current-menu-item .fa,
		.cd-active.cd-dropdown > span
		{
			color:'. ot_get_option( 'c_main_color' ).' !important;
		}
		ul.ul-dates div.dates span,
		ul.ul-card li .dy .degree,
		ul.timeline li .date,
		#labp-heads-wrap,
		.ul-withdetails li .imageoverlay,
		.cd-active.cd-dropdown ul li span:hover,
		.pubmain .pubassets a.pubcollapse,
		.pitems .pubmain .pubassets a:hover, 
		.pitems .pubmain .pubassets a:focus, 
		.pitems .pubmain .pubassets a.pubcollapse,
		.commentlist .reply{
			background-color: '. ot_get_option( 'c_main_color' ).' !important;
		}
		.ul-boxed li,
		ul.timeline li .data,.widget ul li{
			border-left-color:'. ot_get_option( 'c_main_color' ).' !important;
		}
		#labp-heads-wrap:after{
			border-top-color: '. ot_get_option( 'c_main_color' ).' !important;
		}
		ul.ul-dates div.dates span:last-child,
		ul.ul-card li .dy .year,
		ul.timeline li.open .circle{
			background-color: '. ot_get_option( 'c_darker_color' ).' !important;
		}
		ul.timeline li.open .data {
			border-left-color: '. ot_get_option( 'c_darker_color' ).' !important;
		}
		.pitems .pubmain .pubassets {
			border-top-color: '. ot_get_option( 'c_darker_color' ).' !important;
		}

		ul#navigation li:hover, 
		ul#navigation li:focus {
			background-color: '. ot_get_option('menuhover').' !important;
		}

		ul#navigation li {
			background-color: '. ot_get_option('c_menu_item_bg').' !important;
			border-top: 1px solid '. ot_get_option('c_menu_item_bt').' !important;
			border-bottom: 1px solid '. ot_get_option('c_menu_item_bb').' !important;
		}

		

		.fac-page #inside >.wpb_row:first-child:before {
			border-top-color: '. ot_get_option('c_head_row').' !important;
		}
		.fac-page #inside >.wpb_row:nth-child(odd),
		.fac-page .section:nth-child(odd){
			background-color: '. ot_get_option('c_odd').' !important;
		}
		.fac-page #inside >.wpb_row:nth-child(even),
		.fac-page .section:nth-child(even){
			background-color: '. ot_get_option('c_even').' !important;
		}
		.fac-page #inside >.wpb_row:first-child,
		.pageheader {
			background-color: '. ot_get_option('c_head_row').' !important;
		}
		.fac-page #inside >.wpb_row:first-child:before,
		.pageheader:after {
			border-top-color: '. ot_get_option('c_head_row').' !important;
		}

		#main-nav {
			background-color: '. ot_get_option('c_side_back').' !important;
		}
		
		#gallery-header{
			background-color: '. ot_get_option('c_gal_head').' !important;
		}
		#gallery-large{
			background-color: '. ot_get_option('c_gal_body').' !important;
		}
		ul.ul-card li,
		ul.timeline li .data,
		.ul-boxed li,
		.ul-withdetails li,
		.pitems .pubmain,
		.commentlist li{
			background-color: '. ot_get_option('c_box_bg').' !important;
		}

		ul.timeline li.open .data,
		.ul-withdetails li .details,
		#lab-details,
		.pitems .pubdetails,
		.commentlist .comment-author-admin{
			background-color: '. ot_get_option('c_box_bg_alt').' !important;
		}
		a#hideshow,#hideshow i{
			color: '. ot_get_option('c_blog_hs').' !important;
		}
		.archive-header{
			background-color: '. ot_get_option('c_blog_list_head').' !important;
			color: '. ot_get_option('c_blog_list_head_text').' !important;
		}

		#profile .title h2{
			font-size: '. ot_get_option('t_sidebar_title').'px !important;
		}
		#profile .title h3{';
		$h3 = ot_get_option('t_sidebar_title')-10;

		$styles .= '
			font-size: '. $h3.'px !important;	
		}
		ul#navigation li a{
			font-size: '. ot_get_option('t_menu').'px !important;		
		}
		body{
			font-size: '. ot_get_option('t_global').'px !important;		
		}
		.fac-big-title{
			font-size: '. ot_get_option('t_big_title') .'px !important;			
		}';
   	} 

    echo '<style>'.$styles.'</style>';
}
add_action('wp_head', 'fac_custom_css');




/**
* Inject analytics
* @since v1.1.0 
*/
function fac_analytics() {
	if ( function_exists( 'ot_get_option' ) ){
		echo ot_get_option( 'etc_analytics_code' );
	} 
}
add_action('wp_head', 'fac_analytics');




/**
* Inject facicon
* @since v1.1.0 
*/
function fac_favicon() {
	if ( function_exists( 'ot_get_option' ) ){
		$favicon = '<link rel="icon" type="image/png" href="'. ot_get_option('etc_fav_icon').'">';
		echo $favicon;
	} 
}
add_action('wp_head', 'fac_favicon');


/**
*	Facebook script
* @since v 1.1.0
*/
function fac_add_facebook(){
	if ( function_exists('ot_get_option')){
		if (ot_get_option('blog_fb') == "on") {
			$script = '
				<script>(function(d, s, id) {
			  	var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, "script", "facebook-jssdk"));
			</script>
			';
			echo $script;	
		}
	}
}
//add_action('wp_head','fac_add_facebook' );


/** 
* IE fixes
* @since v 1.1.0
*/
function fac_inject_ie(){

	echo '
	<!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	';
}
add_action( 'wp_head','fac_inject_ie' );




/**
* Enqueue styles for the front end.
* @since Faculty 1.0
* @return void
*/
add_action( 'wp_enqueue_scripts', 'faculty_add_styles' );

function faculty_add_styles() {

	// Add Bootstrap styles
	wp_enqueue_style( 'bootstrap-style', get_template_directory_uri() . '/css/bootstrap.css', array() );

	// Add Font-awesome
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', array() );

	// Add magnific-pupup
	wp_enqueue_style( 'magnific-pupup', get_template_directory_uri() . '/css/magnific-popup.css', array() );
	
	// Add scroll bar
	wp_enqueue_style( 'perfect-scroll-style', get_template_directory_uri() . '/css/perfect-scrollbar-0.4.5.min.css', array() );

	// Add faculty specific 
	wp_enqueue_style( 'faculty-styles', get_template_directory_uri() . '/css/style.css', array('bootstrap-style') );

	// Add faculty specific 
	wp_enqueue_style( 'faculty-custom-style', get_template_directory_uri() . '/css/styles/default.css', array('bootstrap-style') );
}



/**
 * Remove code from the <head>
 */
//remove_action('wp_head', 'rsd_link'); // Might be necessary if you or other people on this site use remote editors.
//remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
//remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
//remove_action('wp_head', 'index_rel_link'); // Displays relations link for site index
//remove_action('wp_head', 'wlwmanifest_link'); // Might be necessary if you or other people on this site use Windows Live Writer.
//remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
//remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
//remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0); // Display relational links for the posts adjacent to the current post.



// Hide the version of WordPress you're running from source and RSS feed 
// Want to JUST remove it from the source? Try: remove_action('wp_head', 'wp_generator');
function hcwp_remove_version() {return '';}
add_filter('the_generator', 'hcwp_remove_version');



/**
 * This theme uses wp_nav_menus() for the sidebar
 */
if (function_exists('register_nav_menu')) {
	register_nav_menu( 'sidemenu', 'Main Menu' );
}



/** 
 * Add default posts and comments RSS feed links to head
 */
if ( function_exists( 'add_theme_support')){
	add_theme_support( 'automatic-feed-links' );
}


/** 
 * This theme uses post thumbnails
 */
if ( function_exists( 'add_image_size' ) ) { 
	add_image_size( 'admin-gallery-thumb', 80, 80, true); //admin thumbnail
}


/** 
 * Add default posts and comments RSS feed links to head
 */
if ( function_exists( 'add_theme_support')){
    add_theme_support( 'post-thumbnails' );
}


/*
* Include custom page types (CPTs) 
*/
require_once( get_template_directory().'/includes/type-gallery.php');
require_once( get_template_directory().'/includes/type-publications.php');
require_once( get_template_directory().'/includes/type-publications-meta-box.php');



/*
* This theme uses custom excerpt lenght
*/
function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );





/*
* Utility functions 
*/
function fac_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment; ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
    <div id="comment-<?php comment_ID(); ?>">
      
		<div class="comment-avatar">
			<img src="<?php echo fac_get_avatar_url(get_avatar( $comment, 60 )); ?>" class="authorimage" />
		</div>

		<div class="commenttext">
			
			<?php printf(__('<cite class="fn">%s</cite>'), get_comment_author_link()) ?>
			
			<?php if ($comment->comment_approved == '0') : ?>
			     <br />
			     <em><?php _e('Your comment is awaiting moderation.','faculty') ?></em>
			     <br />
			<?php endif; ?>

			<div class="comment-meta commentmetadata pull-right">
				<?php printf(__('%1$s at %2$s','faculty'), get_comment_date(),  get_comment_time()) ?>
			</div>

			<?php comment_text() ?>

			<div class="reply">
				<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
			</div>
		</div>
    </div>
    </li>
	<?php
}

function fac_get_avatar_url($get_avatar){
    preg_match("/src='(.*?)'/i", $get_avatar, $matches);
    return $matches[1];
}



add_action('comment_post', 'fac_ajaxify_comments',20, 2);
function fac_ajaxify_comments($comment_ID, $comment_status){
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
    	//If AJAX Request Then
        switch($comment_status){
                case '0':
                        //notify moderator of unapproved comment
                        wp_notify_moderator($comment_ID);
                case '1': //Approved comment
                        echo "success";
                        $commentdata=&get_comment($comment_ID, ARRAY_A);
                        $post=&get_post($commentdata['comment_post_ID']);
                        wp_notify_postauthor($comment_ID);
                break;
                default:
                        echo "error";
        }
        exit;
    }
}

