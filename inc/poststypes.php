<?php
/**
 * New post_type: work
 */

add_action( 'init', 'circularculture_create_work_post_type' );

function circularculture_create_work_post_type() {
	register_post_type( 'work',
    	array(
    		'labels' => array(
    			'name' => __( 'Works', 'circularculture'),
    			'singular_name' => __( 'Work', 'circularculture')
    		),  
    		'public' => true,
    		'menu_position' => 5,
    		'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt'),
    		'capability_type' => 'post',
    		'has_archive' => true,
    		'rewrite' => array( 'slug' => 'works',
      					 	'with_front' => false),	
      		'register_meta_box_cb' => 'circularculture_add_work_details_metabox'
      	)
   );
}
 
add_action('admin_init', 'circularculture_add_work_details_metabox');

function circularculture_add_work_details_metabox() {
        add_meta_box('circularculture_work_details', __('Work details', 'circularculture'), 'circularculture_render_work_details_metabox', 'work');
}

$circularculture_work_details_metabox_items = array('wdescription' => __('Description', 'circularculture'),
        										 	'wtdetails' => __('Technical details', 'circularculture')
        										 	); 

function circularculture_render_work_details_metabox() {
        global $post, $circularculture_work_details_metabox_items;
        
        foreach($circularculture_work_details_metabox_items as $item_id => $item_name) {
        	// Label
        	echo "<h2>".$item_name."</h2>";
        	
        	//Create The Editor	
        	$editor_setting = array('wpautop' => true, 'media_buttons' => false);
        	$content = get_post_meta($post->ID, $item_id, true);
        	wp_editor($content, $item_id, $editor_setting);

        	//Clear The Room!
        	echo "<div style='clear:both; display:block;'></div>";
        }
}
 
add_action('save_post', 'circularculture_save_work_details_metabox');

function circularculture_save_work_details_metabox() {
	global $circularculture_work_details_metabox_items;
	
	foreach($circularculture_work_details_metabox_items as $item_id => $item_name) {
     	if(isset($_REQUEST[$item_id])) {
        	update_post_meta($_REQUEST['post_ID'], $item_id, wpautop($_REQUEST[$item_id]));
        }
     }          
}

function works_sections_init() {
  // create a new taxonomy
  register_taxonomy(
    'section',
    'work',
    array(
      'hierarchical' => true,
      'label' => __('Section', 'circularculture'),
      'sort' => true,
      'args' => array('orderby' => 'term_order'),
      'rewrite' => array('slug' => 'section'),
    )
  );
}

add_action( 'init', 'works_sections_init' );
?>