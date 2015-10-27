<?php
/*
Template Name: Publications Template
*/
?>

<?php get_header(); ?>
<div class="fac-page home">
    <?php the_post(); ?>
    <div id="inside">
        <div id="publications" class="page">
            <div class="page-container">
                <div class="pageheader">
                    <div class="headercontent">
                        <div class="section-container">
                            <h2 class="title"><?php the_title(); ?></h2>
                            <div class="row">
                                <div class="col-md-12">
                                    <?php the_content(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pagecontents">
                    <?php $types = fac_get_pubtypes(); ?>

                    <?php if (count($types)>0): ?>
                    <div class="section color-1" id="filters">
                        <div class="section-container">
                            <div class="row">
                                
                                <div class="col-md-3">
                                    <h3><?php _e( 'Filter by type:', 'faculty' ); ?></h3>
                                </div>
                                
                                <?php if (function_exists('ot_get_option')): ?>
                                    
                                    <?php if (ot_get_option('pub_filter') == 'inline'): ?>

                                        <div class="col-md-6" id="miu-filter">
                                            <span class="btn btn-default btn-sm active" value="all"><?php _e( 'All types', 'faculty' ); ?></span>
                                            <?php foreach ($types as $type): ?>
                                                <span class="btn btn-default btn-sm" value="<?php echo $type->slug ?>"><?php echo $type->name; ?></span>
                                            <?php endforeach; ?>
                                        </div>

                                    <?php else: ?>
                                        <div class="col-md-6">
                                            <select id="cd-dropdown" name="cd-dropdown" class="cd-select">
                                                <option class="filter" value="all" selected><?php _e( 'All types', 'faculty' ); ?></option>
                                                <?php foreach ($types as $type): ?>
                                                    <option class="filter" value="<?php echo $type->slug ?>"><?php echo $type->name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>    
                                    <?php endif; ?>

                                <?php else: ?>
                                <div class="col-md-6">
                                    <select id="cd-dropdown" name="cd-dropdown" class="cd-select">
                                        <option class="filter" value="all" selected><?php _e( 'All types', 'faculty' ); ?></option>
                                        <?php foreach ($types as $type): ?>
                                            <option class="filter" value="<?php echo $type->slug ?>"><?php echo $type->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <?php endif; ?>
                                
                                <div class="col-md-3" id="sort">
                                    <span>Sort by year:</span>
                                    <div class="btn-group pull-right"> 

                                        <button type="button" data-sort="data-year" data-order="desc" class="sort btn btn-default btn-sm"><i class="fa fa-sort-numeric-asc"></i></button>
                                        <button type="button" data-sort="data-year" data-order="asc" class="sort btn btn-default btn-sm"><i class="fa fa-sort-numeric-desc"></i></button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="section color-2" id="pub-grid">
                        <div class="section-container">
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pitems">
                                        <?php
                                        //setup new WP_Query
                                        $wp_query = new WP_Query( 
                                            array(
                                                'posts_per_page'    =>    -1,
                                                'post_type'         =>    'publications'
                                            )
                                        );
                                        $counter = 0;
                                        //begine loop
                                        while ($wp_query->have_posts()) : $wp_query->the_post();

                                        $meta= get_post_custom($post->ID);

                                        ?>

                                            <?php if (ot_get_option('pub_layout') == 'compact'): ?>

                                                <div class="item mix <?php fac_taxonomy_name('slug'); ?>" 

                                                <?php if (array_key_exists('fac_pub_year', $meta)):  ?>
                                                    data-year="<?php echo $meta['fac_pub_year'][0] ?>"
                                                <?php endif; ?>
                                                >
                                                    <div class="pubmain compact">
                                                        <div class="pubassets">
                                                            
                                                            
                                                            <a href="#" class="pubcollapse">
                                                                <i class="fa fa-plus-square-o"></i>
                                                            </a>
                                                            

                                                            <?php if (array_key_exists('fac_pub_ext_link', $meta)):  ?>
                                                            <a href="<?php echo $meta['fac_pub_ext_link'][0] ?>" class="tooltips" title="External link" target="_blank">
                                                                <i class="fa fa-external-link"></i>
                                                            </a>
                                                            <?php endif; ?>

                                                            <?php if(array_key_exists('fac_pub_docfile', $meta)): ?>
                                                            <a href="<?php echo $meta['fac_pub_docfile'][0] ?>" class="tooltips" title="<?php _e( 'Download', 'faculty' ); ?>" target="_blank">
                                                                <i class="fa fa-cloud-download"></i>
                                                            </a>
                                                            <?php endif; ?>
                                                            
                                                        </div>

                                                        <h4 class="pubtitle"><?php $counter++;echo $counter.'- '.$meta['fac_pub_title'][0] ?></h4>

                                                    </div>
                                                    
                                                    <div class="pubdetails">
                                                        <?php fac_taxonomy_name('name'); ?>
                                                        <div class="pubauthor"><?php echo $meta['fac_pub_authors'][0] ?></div>
                                                        <div class="pubcite"><?php echo $meta['fac_pub_cit'][0] ?></div>
                                                        <?php the_content(); ?>

                                                    </div>
                                                    
                                                </div>

                                            <?php else: ?>

                                                <div class="item mix <?php fac_taxonomy_name('slug'); ?>" 

                                                <?php if (array_key_exists('fac_pub_year', $meta)):  ?>
                                                    data-year="<?php echo $meta['fac_pub_year'][0] ?>"
                                                <?php endif; ?>
                                                >
                                                    <div class="pubmain">
                                                        <div class="pubassets">
                                                            
                                                            <?php if ($post->post_content!="") : ?>
                                                            <a href="#" class="pubcollapse">
                                                                <i class="fa fa-plus-square-o"></i>
                                                            </a>
                                                            <?php endif; ?>

                                                            <?php if (array_key_exists('fac_pub_ext_link', $meta)):  ?>
                                                            <a href="<?php echo $meta['fac_pub_ext_link'][0] ?>" class="tooltips" title="External link" target="_blank">
                                                                <i class="fa fa-external-link"></i>
                                                            </a>
                                                            <?php endif; ?>

                                                            <?php if(array_key_exists('fac_pub_docfile', $meta)): ?>
                                                            <a href="<?php echo $meta['fac_pub_docfile'][0] ?>" class="tooltips" title="<?php _e( 'Download', 'faculty' ); ?>" target="_blank">
                                                                <i class="fa fa-cloud-download"></i>
                                                            </a>
                                                            <?php endif; ?>
                                                            
                                                        </div>

                                                        <h4 class="pubtitle"><?php echo $meta['fac_pub_title'][0] ?></h4>

                                                        <?php fac_taxonomy_name('name'); ?>

                                                        <div class="pubauthor"><?php echo $meta['fac_pub_authors'][0] ?></div>
                                                        <div class="pubcite"><?php echo $meta['fac_pub_cit'][0] ?></div>
                                                        
                                                    </div>
                                                    <?php if ($post->post_content!="") : ?>
                                                    <div class="pubdetails">
                                                        <?php the_content(); ?>
                                                    </div>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; //end if for layout mode?>

                                        <?php endwhile; // end of the loop. ?>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
<div id="overlay"></div>
<?php get_footer(); ?>


