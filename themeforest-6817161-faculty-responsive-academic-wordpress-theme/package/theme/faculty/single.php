

	<?php get_header(); ?>

	    <div class="" data-pos="home" data-url="<?php the_permalink(); ?>">
	    	<a id="hideshow" href="#"><i class="fa fa-chevron-circle-right"></i><span><?php _e( 'List', 'faculty' ); ?></span></a>
			<div id="blog-content">



		    <div class="inner-wrapper" id="ajax-single-post">
				<!-- here will be populated with the single post content -->
		    
				<?php the_post(); ?>
				<div class="pageheader">
				    <div class="headercontent">
				        <div class="section-container">
				            
				            <?php $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
							<?php if($url): ?>
								<img src="<?php echo $url; ?>" alt="" class="img-responsive"/>
							<?php endif; ?>
				            <h2 class="title"><?php the_title(); ?></h2>
				            
				            <div class="post-meta">
				            	
				            	<span><i class="fa fa-calendar"></i>&nbsp;<?php the_date(); ?></span>
					            
					            <?php if (ot_get_option( 'blog_author' ) == 'on') : ?>
					            | <span><i class="fa fa-edit"></i>&nbsp;<?php the_author(); ?></span>
					            <?php endif; ?>

					            | <span><i class="fa fa-folder-o"></i>&nbsp;<?php the_category(', ','single'); ?></span>
					            
					            <?php if (ot_get_option( 'blog_tags' ) == 'on') : ?>
					            | <span><i class="fa fa-tag"></i>&nbsp;<?php the_tags(''); ?></span>
					            <?php endif; ?>
					            
					           
					            
					            <?php if (ot_get_option('blog_fb') == "on"): ?>
								    <div id="fb-root"></div>
								    <?php if (function_exists('fac_add_facebook')) : ?>
								    	<?php fac_add_facebook(); ?>
								    	| <div class="fb-share-button" data-href="<?php the_permalink();?>" data-width="30px" data-type="button_count"></div>
								    <?php endif; ?>
								<?php endif; ?>

								<!-- twitter -->
								<?php if(ot_get_option( 'blog_twitter' ) == 'on'): ?>
									| 
									<div class="twittershare">
										<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink();?>">Tweet</a>
										<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
									</div>
								<?php endif; ?>
								<!-- /twitter	 -->

								<?php if(ot_get_option( 'blog_gp' ) == 'on'): ?>
									| 
									<div class="googleplusone">
										<!-- Place this tag where you want the +1 button to render. -->
										<div class="g-plusone" data-size="medium" data-annotation="inline" data-width="120"></div>

										<!-- Place this tag after the last +1 button tag. -->
										<script type="text/javascript">
										  (function() {
										    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
										    po.src = 'https://apis.google.com/js/platform.js';
										    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
										  })();
										</script>
									</div>
									
					            <?php endif; ?>


				            </div>
				            
				        </div>
				    </div>
				</div>

				<div class="page-contents color-1">
					<div class="section">
						<div class="section-container">
							<?php the_content(); ?>
							<?php wp_link_pages(); ?>
						</div>
					</div>
				</div>

				<?php 
				// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) : ?>	
				<div class="page-contents color-2">
					<div class="section">
						<div class="section-container">
						<?php comments_template(); ?>
						</div>
					</div>
				</div>
				<?php endif; ?>

			</div>


			</div>

			<div id="blog-side">
	        	
	        	<div class="archive-header" id="archive-header">
					
					<h3 class="archive-title"><i class="fa-quote-right fa"></i>&nbsp;&nbsp;<?php _e( 'Posts', 'faculty' ); ?></h3>
					
				</div>

				<div id="postlist">
				<?php wp_reset_query(); ?>
				<?php query_posts("posts_per_page=10"); ?>

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
							<?php echo $term_obj->count." "._e( 'posts', 'faculty' ); ?>
						<?php endif; ?>
					</div>
				<?php endif; ?>
				
				<div class="archive-contnet" id="archive-content">
					<div class="inner-wrapper">
	        		
	        		<?php $counter = 0 ?>
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>


						<div class="post post-ajax" id="<?php echo get_page_uri($post->id); ?>">
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
						<?php $counter++; ?>
					<?php endwhile; ?>
					
					<?php else : ?>
						<h2><?php _e( 'No Posts', 'faculty' ); ?></h2>
					<?php endif; ?>
	        	</div>	
				</div>
	        	</div>
	        </div>
		</div>
	    <div id="overlay"></div>
	</div>

	<?php get_footer(); ?>



