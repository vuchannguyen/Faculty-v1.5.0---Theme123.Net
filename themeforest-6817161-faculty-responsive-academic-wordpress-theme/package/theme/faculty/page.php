<?php
/**
 * @package WordPress
 * @subpackage faculty
 */
?>

<?php get_header(); ?>

    
	<div class="fac-page home">
		<div id="inside">
				
			<?php the_post(); ?>

			<div class="pageheader">
                <div class="headercontent">
                    <div class="section-container">
                        
                        <h2 class="title"><?php the_title(); ?></h2>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <p><?php the_excerpt(); ?></p>                                                   
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pagecontents">
                <div class="section color-1">
                    <div class="section-container">
                		<?php the_content(); ?>
			
						<?php wp_link_pages(); ?>
                    </div>
                </div>
            </div>
			
		</div>	
	</div>
	<div id="overlay"></div>
<?php get_footer(); ?>


