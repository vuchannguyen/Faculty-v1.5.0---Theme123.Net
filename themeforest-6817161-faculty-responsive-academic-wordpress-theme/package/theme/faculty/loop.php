<?php
/**
 * @package WordPress
 * @subpackage faculty
 */
?>

<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if ( $wp_query->max_num_pages > 1 ) : ?>
	<div id="blog-navigation">
		<?php posts_nav_link('&nbsp;&nbsp;-&nbsp;&nbsp;','<i class="fa fa-angle-left"></i>&nbsp;&nbsp;Newer','Older&nbsp;&nbsp;<i class="fa fa-angle-right"></i>'); ?>	
	</div><!-- #nav-above -->
<?php else: ?>
	<div id="blog-navigation">
		<?php if (is_category() OR is_tag() ): ?>
			<?php 
				$term =  get_queried_object();
				$term_obj = get_term( $term->term_taxonomy_id, $term->taxonomy ); 
			?>
			<span><?php echo $term_obj->count?></span> <span><?php _e( 'posts', 'faculty' ); ?></span>
		<?php endif; ?>
	</div>
<?php endif; ?>

<?php /* Start the Loop */ ?>

<div class="archive-contnet" id="archive-content">
	<div class="inner-wrapper">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							
		<div class="post post-ajax" <?php post_class(); ?> id="<?php echo get_page_uri($post->id); ?>">
			<a href="<?php the_permalink() ?>" data-url="<?php the_permalink() ?>" class="ajax-single">
				
				<?php if( ot_get_option('blog_thumbs') == "on" AND has_post_thumbnail() ) : ?>
					<div class="blog-thumb">
						<?php the_post_thumbnail('thumbnail'); ?>
					</div>
					<div class="blog-info">
						<div class="blog-date"><?php the_time('F jS, Y') ?></div>
						<h4><?php the_title(); ?></h4>
					</div>
					<div class="clearfix"></div>
				<?php else: ?>
					<div class="blog-date"><?php the_time('F jS, Y') ?></div>

					<h4><?php the_title(); ?></h4>

					<!-- <div class="meta"><em>by</em> <?php the_author() ?></div> -->

					<div class="blog-excerpt">
						<?php the_excerpt(); ?>
					</div>
				<?php endif; ?>

			</a>
		</div>
		
	<?php endwhile; ?>

	<?php else : ?>
		<h3><?php _e( 'No posts', 'faculty' ); ?></h3>
	<?php endif; ?>

	</div>	
</div>
					