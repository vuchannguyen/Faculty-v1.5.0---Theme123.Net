<?php 
add_action('init', 'publications_register');

function publications_register(){
	$publications_labels = array(
	    'name' 					=> __('Publications','faculty'),
	    'singular_name' 		=> __('Publication','faculty'),
	    'add_new' 				=> __('Add New','faculty'),
	    'add_new_item' 			=> __("Add New Publication",'faculty'),
	    'edit_item' 			=> __("Edit Publication",'faculty'),
	    'new_item' 				=> __("New Publication",'faculty'),
	    'view_item' 			=> __("View Publication",'faculty'),
	    'search_items' 			=> __("Search Publications",'faculty'),
	    'not_found' 			=> __( 'No Publications found','faculty'),
	    'not_found_in_trash' 	=> __('No Publications found in Trash','faculty'), 
	    'parent_item_colon' 	=> ''
	);
	$publications_args = array(
	    'labels' 				=> $publications_labels ,
	    'public' 				=> true,
	    'publicly_queryable' 	=> true,
	    'show_ui' 				=> true, 
	    'query_var' 			=> true,
	    'rewrite' 				=> true,
	    'hierarchical' 			=> false,
	    'menu_position' 		=> null,
	    'capability_type' 		=> 'post',
	    'supports' 				=> array('title', 'editor'),
	    //'menu_icon' 			=> get_bloginfo('template_directory') . '/images/photo-album.png' //16x16 png if you want an icon
	); 
	register_post_type('publications', $publications_args);
	flush_rewrite_rules( false );
};

add_action( 'init', 'fac_create_publications_taxonomies', 0);
 
function fac_create_publications_taxonomies(){
    register_taxonomy(
        'pubtype', 'publications', 
        array(
            'hierarchical'=> true, 
            'label' => 'Publication Types',
            'singular_label' => 'Publication Type',
            'rewrite' => true
        )
    );    
}

add_action('manage_posts_custom_column', 'fac_custom_columns');
add_filter('manage_edit-publications_columns', 'fac_add_new_publications_columns');
function fac_add_new_publications_columns( $columns ){
    $columns = array(
        'cb'		=> '<input type="checkbox">',
		'title'		=> 'Publication Title',
		'pubtype'	=> 'Publication Type',
		'date'		=> 'Date'
    );
    return $columns;
}

function fac_custom_columns( $column ){
    global $post;
    
    switch ($column) {
        case 'pubtype' : echo get_the_term_list( $post->ID, 'pubtype', '', ', ',''); break;
    }
}


function fac_get_pubtypes(){
	$taxonomy = 'pubtype';
	return get_terms($taxonomy);
}

function fac_taxonomy_name($type){
     global $post;
 
    $terms = get_the_terms( $post->ID , 'pubtype' ); 
    if ($type =="slug"){
	    foreach ( $terms as $termphoto ) { 
	        echo ' '.$termphoto->slug; 
	    }
	}else{
		foreach ( $terms as $termphoto ) { 
	        echo '<span class="label label-warning">'.$termphoto->name.'</span>'; 
	    }
	} 
}

