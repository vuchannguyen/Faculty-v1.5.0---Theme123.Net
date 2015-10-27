<?php 
// Add the Meta Box
function add_pub_meta_box() {
    add_meta_box(
		'pub_meta_box', // $id
		'Publication Meta Box', // $title 
		'show_pub_meta_box', // $callback
		'publications', // $page
		'normal', // $context
		'high'); // $priority
}
add_action('add_meta_boxes', 'add_pub_meta_box');

// Field Array
$prefix = 'fac_pub_';
$pub_meta_fields = array(
	array(
		'label'	=> __('Publication Title','faculty'),
		'desc'	=> __('Title of the Publication','faculty'),
		'id'	=> $prefix.'title',
		'type'	=> 'text'
	),
	array(
		'label'	=> __('Publication Year','faculty'),
		'desc'	=> __('Year of the Publication, eg:2014','faculty'),
		'id'	=> $prefix.'year',
		'type'	=> 'text'
	),
	array(
		'label'	=> __('Authors','faculty'),
		'desc'	=> __('List of authors , eg:Jennifer Doe, Emily N. Garbinsky, Kathleen D. Vohs','faculty'),
		'id'	=> $prefix.'authors',
		'type'	=> 'text'
	),
	array(
		'label'	=> __('Citation','faculty'),
		'desc'	=> __('for example: Journal of Consumer Psychology, Volume 22, Issue 2, April 2012, Pages 191-194','faculty'),
		'id'	=> $prefix.'cit',
		'type'	=> 'text'
	),
	array(
		'label'	=> __('External Link','faculty'),
		'desc'	=> __('Link to publishe website ex: http://www.sciencedirect.com/science/article/pii/S1057740812000290','faculty'),
		'id'	=> $prefix.'ext_link',
		'type'	=> 'text'
	),
	array(
		'label'	=> __('File','faculty'),
		'desc'	=> __('Document file (pdf,doc)','faculty'),
		'id'	=> $prefix.'docfile',
		'type'	=> 'file'
	)

);

// enqueue scripts and styles, but only if is_admin

function fac_add_admin_meta_box(){
	wp_enqueue_script('pub-meta-box', get_template_directory_uri().'/includes/js/pub-meta-box.js','jquery');
}
if( is_admin() ) {
	add_action('admin_init', 'fac_add_admin_meta_box');	
}


// The Callback
function show_pub_meta_box() {
	global $pub_meta_fields, $post;
	// Use nonce for verification
	echo '<input type="hidden" name="pub_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
	
	// Begin the field table and loop
	echo '<table class="form-table">';
	foreach ($pub_meta_fields as $field) {
		// get value of this field if it exists for this post
		$meta = get_post_meta($post->ID, $field['id'], true);
		
		// begin a table row with
		echo '<tr>
				<th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
				<td>';
				switch($field['type']) {
					// text
					case 'text':
						echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
								<br /><span class="description">'.$field['desc'].'</span>';
					break;
					// textarea
					case 'textarea':
						echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="4">'.$meta.'</textarea>
								<br /><span class="description">'.$field['desc'].'</span>';
					break;
					// checkbox
					case 'checkbox':
						echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ',$meta ? ' checked="checked"' : '','/>
								<label for="'.$field['id'].'">'.$field['desc'].'</label>';
					break;
					// select
					case 'select':
						echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';
						foreach ($field['options'] as $option) {
							echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
						}
						echo '</select><br /><span class="description">'.$field['desc'].'</span>';
					break;
					// radio
					case 'radio':
						foreach ( $field['options'] as $option ) {
							echo '<input type="radio" name="'.$field['id'].'" id="'.$option['value'].'" value="'.$option['value'].'" ',$meta == $option['value'] ? ' checked="checked"' : '',' />
									<label for="'.$option['value'].'">'.$option['label'].'</label><br />';
						}
						echo '<span class="description">'.$field['desc'].'</span>';
					break;
					// checkbox_group
					case 'checkbox_group':
						foreach ($field['options'] as $option) {
							echo '<input type="checkbox" value="'.$option['value'].'" name="'.$field['id'].'[]" id="'.$option['value'].'"',$meta && in_array($option['value'], $meta) ? ' checked="checked"' : '',' /> 
									<label for="'.$option['value'].'">'.$option['label'].'</label><br />';
						}
						echo '<span class="description">'.$field['desc'].'</span>';
					break;
					// tax_select
					case 'tax_select':
						echo '<select name="'.$field['id'].'" id="'.$field['id'].'">
								<option value="">Select One</option>'; // Select One
						$terms = get_terms($field['id'], 'get=all');
						$selected = wp_get_object_terms($post->ID, $field['id']);
						foreach ($terms as $term) {
							if (!empty($selected) && !strcmp($term->slug, $selected[0]->slug)) 
								echo '<option value="'.$term->slug.'" selected="selected">'.$term->name.'</option>'; 
							else
								echo '<option value="'.$term->slug.'">'.$term->name.'</option>'; 
						}
						$taxonomy = get_taxonomy($field['id']);
						echo '</select><br /><span class="description"><a href="'.get_bloginfo('home').'/wp-admin/edit-tags.php?taxonomy='.$field['id'].'">Manage '.$taxonomy->label.'</a></span>';
					break;
					// post_list
					case 'post_list':
					$items = get_posts( array (
						'post_type'	=> $field['post_type'],
						'posts_per_page' => -1
					));
						echo '<select name="'.$field['id'].'" id="'.$field['id'].'">
								<option value="">Select One</option>'; // Select One
							foreach($items as $item) {
								echo '<option value="'.$item->ID.'"',$meta == $item->ID ? ' selected="selected"' : '','>'.$item->post_type.': '.$item->post_title.'</option>';
							} // end foreach
						echo '</select><br /><span class="description">'.$field['desc'].'</span>';
					break;
					// date
					case 'date':
						echo '<input type="text" class="datepicker" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
								<br /><span class="description">'.$field['desc'].'</span>';
					break;
					// slider
					case 'slider':
					$value = $meta != '' ? $meta : '0';
						echo '<div id="'.$field['id'].'-slider"></div>
								<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$value.'" size="5" />
								<br /><span class="description">'.$field['desc'].'</span>';
					break;

					// file
					case 'file':
						$image = get_template_directory_uri().'/includes/img/pdf.png';	
						echo '<img src="'.$image.'" class="custom_preview_image" alt="" />
								<input name="'.$field['id'].'" type="hidden" class="custom_upload_file" value="'.$meta.'" />
								<p>URL: <a target="_blank" href="'.$meta.'">'.$meta.'</a></p><br />
								<input class="custom_upload_file_button button" type="button" value="Choose file" />
								<small>&nbsp;<a href="#" class="custom_clear_file_button">'.__('Remove file','faculty').'</a></small>
								<br clear="all" /><span class="description">'.$field['desc'].'</span>';
					break;
					// image
					case 'image':
						$image = get_template_directory_uri().'/includes/img/image.png';	
						echo '<span class="custom_default_image" style="display:none">'.$image.'</span>';
						if ($meta) { $image = wp_get_attachment_image_src($meta, 'medium');	$image = $image[0]; }				
						echo	'<input name="'.$field['id'].'" type="hidden" class="custom_upload_image" value="'.$meta.'" />
									<img src="'.$image.'" class="custom_preview_image" alt="" /><br />
										<input class="custom_upload_image_button button" type="button" value="Choose Image" />
										<small>&nbsp;<a href="#" class="custom_clear_image_button">'.__('Remove image','faculty').'</a></small>
										<br clear="all" /><span class="description">'.$field['desc'].'</span>';
					break;
					// repeatable
					case 'repeatable':
						echo '<a class="repeatable-add button" href="#">+</a>
								<ul id="'.$field['id'].'-repeatable" class="custom_repeatable">';
						$i = 0;
						if ($meta) {
							foreach($meta as $row) {
								echo '<li><span class="sort hndle">|||</span>
											<input type="text" name="'.$field['id'].'['.$i.']" id="'.$field['id'].'" value="'.$row.'" size="30" />
											<a class="repeatable-remove button" href="#">-</a></li>';
								$i++;
							}
						} else {
							echo '<li><span class="sort hndle">|||</span>
										<input type="text" name="'.$field['id'].'['.$i.']" id="'.$field['id'].'" value="" size="30" />
										<a class="repeatable-remove button" href="#">-</a></li>';
						}
						echo '</ul>
							<span class="description">'.$field['desc'].'</span>';
					break;
				} //end switch
		echo '</td></tr>';
	} // end foreach
	echo '</table>'; // end table
}

// function remove_taxonomy_boxes() {
// 	//remove_meta_box('categorydiv', 'post', 'side');
// }
// add_action( 'admin_menu' , 'remove_taxonomy_boxes' );

// Save the Data
function save_pub_meta($post_id) {
    global $pub_meta_fields;
	
	
	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return $post_id;
	// check permissions
	if (array_key_exists('post_type', $_POST)){
		if ('page' == $_POST['post_type']) {
			if (!current_user_can('edit_page', $post_id))
				return $post_id;
			} elseif (!current_user_can('edit_post', $post_id)) {
				return $post_id;
		}
	}
		
	// echo "<pre>"; var_dump($_POST);echo"</pre>";
	// die();
	// loop through fields and save the data
	foreach ($pub_meta_fields as $field) {
		if($field['type'] == 'tax_select') continue;
		$old = get_post_meta($post_id, $field['id'], true);
		$new = '';
		if ( array_key_exists($field['id'], $_POST)){

			$new = $_POST[$field['id']];

			if ($new && $new != $old) {
				update_post_meta($post_id, $field['id'], $new);
			} elseif ('' == $new && $old) {
				delete_post_meta($post_id, $field['id'], $old);
			}
		}

			
	} // enf foreach

	// save taxonomies
	$post = get_post($post_id);
	if ( array_key_exists('category', $_POST)){
		$category = $_POST['category'];
		wp_set_object_terms( $post_id, $category, 'category' );
	}
	
}
add_action('save_post', 'save_pub_meta');