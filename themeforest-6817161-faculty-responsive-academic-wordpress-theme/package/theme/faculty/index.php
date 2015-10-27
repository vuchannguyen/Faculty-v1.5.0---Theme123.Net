<?php
/**
 * @package WordPress
 * @subpackage faculty
 */
?>


<?php 
if( ! empty( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ] ) &&
      strtolower( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ]) == 'xmlhttprequest' ) {
    //this is an ajax request
    $is_ajax = true;
}else{
	$is_ajax = false;
}
?>

<?php if (!$is_ajax) : ?>
<?php get_header(); ?>

    <div class="" data-pos="home" data-url="<?php the_permalink(); ?>">

        <a id="hideshow" href="#"><i class="fa fa-chevron-circle-right"></i><span><?php _e( 'List', 'faculty' ); ?></span></a>
        <div id="blog-content">
		    <div class="inner-wrapper" id="ajax-single-post">
				<!-- here will be populated with the single post content -->
		    </div>
        </div>

        <div id="blog-side">
        	
        	<div class="archive-header" id="archive-header">
				
                <?php if (is_category()) :?>
				    <h3 class="archive-title"><i class="fa fa-folder-o"></i>&nbsp;&nbsp;<?php single_cat_title(); ?></h3>
				<?php elseif (is_archive()): ?>

                <?php elseif (is_author()): ?>
                    <h3 class="archive-title"><i class="fa fa-pencil-square-o"></i>&nbsp;&nbsp;<?php esc_attr( get_the_author() ); ?></h3>
                <?php elseif( is_tag()): ?>
                    <h3 class="archive-title"><i class="fa fa-tag"></i>&nbsp;&nbsp;<?php single_tag_title(); ?></h3>
                <?php else: ?>
                    <h3 class="archive-title"><i class="fa-quote-right fa"></i>&nbsp;&nbsp;<?php _e( 'Posts', 'faculty' ); ?></h3>
                <?php endif; ?>
			</div>

			<div id="postlist">

<?php endif; ?>				
				

			<?php get_template_part( 'loop' ); ?>


<?php if (!$is_ajax) : ?>
        	
        	</div>
        </div>
    </div>

    <div id="overlay"></div>
</div>


<?php get_footer(); ?>
<script>
    jQuery(window).trigger('blogdecide');
</script>    
<?php endif; ?>