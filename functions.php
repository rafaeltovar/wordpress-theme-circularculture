<?php

/**
 * Functions
 *
 * Core functionality and initial theme setup
 *
 * @package WordPress
 * @subpackage circularculture, for WordPress
 * @since circularculture, for WordPress 4.0
 */

/**
 * Initiate circularculture, for WordPress
 */

if ( ! function_exists( 'circularculture_setup' ) ) :

function circularculture_setup() {

	// Content Width
	if ( ! isset( $content_width ) ) $content_width = 900;

	// Language Translations
	load_theme_textdomain( 'circularculture', get_template_directory() . '/lang' );
	
	$locale = get_locale();
	$locale_file = get_template_directory() . "/lang/$locale.php";
	if ( is_readable( $locale_file ) ) {
    	require_once( $locale_file );
    }

	// Custom Editor Style Support
	add_editor_style();

	// Support for Featured Images
	add_theme_support( 'post-thumbnails' );
	
	if (function_exists( 'add_image_size' ) ) {
		add_image_size('circularculture-home', 384, 384, true);
	}

	// Automatic Feed Links & Post Formats
	add_theme_support( 'automatic-feed-links' );
	//add_theme_support( 'post-formats', array( 'aside', 'image', 'link', 'quote', 'status' ) );
}

add_action( 'after_setup_theme', 'circularculture_setup' );

endif;

/**
 * Enqueue Scripts and Styles for Front-End
 */

if ( ! function_exists( 'circularculture_assets' ) ) :

function circularculture_assets() {

	if (!is_admin()) {

		/** 
		 * Deregister jQuery in favour of ZeptoJS
		 * jQuery will be used as a fallback if ZeptoJS is not compatible
		 * @see circularculture_compatibility & http://circularculture.zurb.com/docs/javascript.html
		 */
		wp_deregister_script('jquery');

		// Load JavaScripts
		wp_enqueue_script( 'foundation', get_template_directory_uri() . '/js/foundation.min.js', null, '4.0', true );
		wp_enqueue_script( 'circularculture', get_template_directory_uri().'/js/circularculture.js', null, '1.0', true);
		wp_enqueue_script( 'modernizr', get_template_directory_uri().'/js/vendor/custom.modernizr.js', null, '2.1.0');
		if ( is_singular() ) wp_enqueue_script( "comment-reply" );
		/*if ( is_singular() ) {
			wp_enqueue_script( "comment-reply" );
			
			// Gallery 
			wp_enqueue_style( 'magnific-popup', get_template_directory_uri().'/js/magnific-popup/magnific-popup.css' );
			// add magnific-popup js in footer
			wp_enqueue_script( 'magnific-popup', get_template_directory_uri() . '/js/magnific-popup/jquery.magnific-popup.min.js', null, '0.8.8', true);
			
		}*/

		// Load Stylesheets
		wp_enqueue_style( 'normalize', get_template_directory_uri().'/css/normalize.css' );
		wp_enqueue_style( 'circularculture', get_template_directory_uri().'/css/circularculture.min.css' );
		wp_enqueue_style( 'font_awesome', get_template_directory_uri().'/css/font-awesome/css/font-awesome.min.css' );
		//wp_enqueue_style( 'app', get_stylesheet_uri(), array('circularculture') );	
	}

}

add_action( 'wp_enqueue_scripts', 'circularculture_assets' );

endif;

/**
 * Initialise circularculture JS
 * @see: http://circularculture.zurb.com/docs/javascript.html
 */

if ( ! function_exists( 'circularculture_js_init' ) ) :

function circularculture_js_init () {
	echo '<script>$(function(){';
    echo '$(document).foundation();';
    echo '$(document).circularculture();';
    echo '})</script>';
}

add_action('wp_footer', 'circularculture_js_init', 50);

endif;

/**
 * ZeptoJS and jQuery Fallback
 * @see: http://circularculture.zurb.com/docs/javascript.html
 */

if ( ! function_exists( 'circularculture_comptability' ) ) :

function circularculture_comptability () {

echo "<script>";
echo "document.write('<script src=' +";
echo "('__proto__' in {} ? '" . get_template_directory_uri() . "/js/vendor/zepto" . "' : '" . get_template_directory_uri() . "/js/vendor/jquery" . "') +";
echo "'.js><\/script>')";
echo "</script>";

}

add_action('wp_footer', 'circularculture_comptability', 10);

endif;

/**
 * Register Navigation Menus
 */

if ( ! function_exists( 'circularculture_menus' ) ) :

// Register wp_nav_menus
function circularculture_menus() {

	register_nav_menus(
		array(
			'header-menu' => __( 'Header Menu', 'circularculture' ),
			'footer-menu' => __( 'Footer Menu', 'circularculture' )
		)
	);
	
}

add_action( 'init', 'circularculture_menus' );

endif;

/**
 * Cambio de lenguaje en el menu
 */
function circularculture_menu_language_item( $items, $args ) {
    if ( class_exists( 'MslsOutput' ) && 'header-menu' == $args->theme_location ) {
    
    	$display = 1;
    	$exists  = true;
    	$obj = new MslsOutput();
    	foreach ( $obj->get( $display, $exists ) as $link ) {
	    	$items.="<li>".$link."</li>";
	    } 
    }
    return $items;
}

add_filter( 'wp_nav_menu_items', 'circularculture_menu_language_item', 10, 2 );


if ( ! function_exists( 'circularculture_page_menu' ) ) :

function circularculture_page_menu() {

	$args = array(
	'sort_column' => 'menu_order, post_title',
	'menu_class'  => 'large-12 columns',
	'include'     => '',
	'exclude'     => '',
	'echo'        => true,
	'show_home'   => false,
	'link_before' => '',
	'link_after'  => ''
	);

	wp_page_menu($args);

}

endif;

/**
 * Navigation Menu Adjustments
 */

// Add class to navigation sub-menu
class circularculture_navigation extends Walker_Nav_Menu {

function start_lvl(&$output, $depth) {
	$indent = str_repeat("\t", $depth);
	$output .= "\n$indent<ul class=\"dropdown\">\n";
}

function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
	$id_field = $this->db_fields['id'];
	if ( !empty( $children_elements[ $element->$id_field ] ) ) {
		$element->classes[] = 'has-dropdown';
	}
		Walker_Nav_Menu::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}
}

/**
 * Create pagination
 * TODO fix with template
 */
if ( ! function_exists( 'circularculture_pagination' ) ) :

function circularculture_pagination( $p = 2 ) {
	if ( is_singular() ) return;
	
	global $wp_query, $paged;
	$pagination = '';
	
	$max_page = $wp_query->max_num_pages;
	if ( $max_page == 1 ) return;
	if ( empty( $paged ) ) $paged = 1;
	if ( $paged > $p + 1 ) $pagination.= p_link( 1, 'First' );
	if ( $paged > $p + 2 ) $pagination .= '<li class="unavailable"><a href="#">&hellip;</a></li>';
	for( $i = $paged - $p; $i <= $paged + $p; $i++ ) { // Middle pages
		if ( $i > 0 && $i <= $max_page ) 
			$pagination .= ($i == $paged ? "<li class='current'><a href='#'>{$i}</a></li> " : p_link( $i ));
	}
	if ( $paged < $max_page - $p - 1 ) $pagination.= '<li class="unavailable"><a href="#">&hellip;</a></li>';
	if ( $paged < $max_page - $p ) $pagination.= p_link( $max_page, 'Last' );
	
	$pagination = '<ul class="pagination">'. $pagination .'</ul>';
	echo $pagination; 
}

function p_link( $i, $title = '' ) {
	if ( $title == '' ) $title = "Page {$i}";
	return "<li><a href='". esc_html( get_pagenum_link( $i ) ) ."' title='{$title}'>{$i}</a></li> ";
}

endif;

/**
 * Register Sidebars
 */

if ( ! function_exists( 'circularculture_widgets' ) ) :

function circularculture_widgets() {

	// Sidebar Right
	register_sidebar( array(
			'id' => 'circularculture_sidebar_right',
			'name' => __( 'Sidebar Right', 'circularculture' ),
			'description' => __( 'This sidebar is located on the right-hand side of each page.', 'circularculture' ),
			'before_widget' => '<div class="widget">',
			'after_widget' => '</div>',
			'before_title' => '<h4>',
			'after_title' => '</h4>',
		) );
	
	// Sidebar Right works
	register_sidebar( array(
			'id' => 'circularculture_sidebar_right_works',
			'name' => __( 'Works Sidebar Right', 'circularculture' ),
			'description' => __( 'This sidebar is located on the right-hand side of each page of works.', 'circularculture' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4>',
			'after_title' => '</h4>',
		) );
		
	// Sidebar Top Small
	register_sidebar( array(
			'id' => 'circularculture_sidebar_top_small',
			'name' => __( 'Sidebar Top Small', 'circularculture' ),
			'description' => __( 'This sidebar is located at right to header menu.', 'circularculture' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s large-3 columns">',
			'after_widget' => '</div>',
			'before_title' => '<h5>',
			'after_title' => '</h5>',
		) );
		
	// Sidebar Top
	register_sidebar( array(
			'id' => 'circularculture_sidebar_top',
			'name' => __( 'Sidebar Top', 'circularculture' ),
			'description' => __( 'This sidebar is located on the middle between menu and content.', 'circularculture' ),
			'before_widget' => '<div id="%1$s" class="large-12 columns widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h5>',
			'after_title' => '</h5>',
		) );

	// Sidebar Footer Column
	register_sidebar( array(
			'id' => 'circularculture_sidebar_footer',
			'name' => __( 'Sidebar Footer', 'circularculture' ),
			'description' => __( 'This sidebar is located in column one of your theme footer.', 'circularculture' ),
			'before_widget' => '<div id="%1$s" class="widget large-3 columns %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h5>',
			'after_title' => '</h5>',
		) );

	}

add_action( 'widgets_init', 'circularculture_widgets' );

endif;

/**
 * Custom Avatar Classes
 */
/** TODO delete
if ( ! function_exists( 'circularculture_avatar_css' ) ) :

function circularculture_avatar_css($class) {
	$class = str_replace("class='avatar", "class='author_gravatar left ", $class) ;
	return $class;
}

add_filter('get_avatar','circularculture_avatar_css');

endif;
*/

/**
 * Custom Post Excerpt
 */


/* TODO delete 
if ( ! function_exists( 'circularculture_excerpt' ) ) :

function circularculture_excerpt($text) {
        global $post;
        if ( '' == $text ) {
                $text = get_the_content('');
                $text = apply_filters('the_content', $text);
                $text = str_replace('\]\]\>', ']]&gt;', $text);
                $text = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);
                $text = strip_tags($text, '<p>');
                $excerpt_length = 80;
                $words = explode(' ', $text, $excerpt_length + 1);
                if (count($words)> $excerpt_length) {
                        array_pop($words);
                        array_push($words, '<br><br><a href="'.get_permalink($post->ID) .'" class="button secondary small">' . __('Continue Reading', 'circularculture') . '</a>');
                        $text = implode(' ', $words);
                }
        }
        return $text;
}

remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'circularculture_excerpt');

endif; */

if ( ! function_exists( 'circularculture_get_the_excerpt' ) ) :

function circularculture_get_the_excerpt($excerpt_length = 55, $ending = ' [...]', $superending = null) {
	$text = get_the_content('');
	$text = strip_shortcodes( $text );

	$text = apply_filters('the_content', $text);
	$text = str_replace(']]>', ']]&gt;', $text);
	$text = strip_tags($text);
	
	$words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
	if ( count($words) > $excerpt_length ) {
		array_pop($words);
		$text = implode(' ', $words);
		$text = $text . $ending;
		return '<p>'.$text.'</p>'.$superending;
	} else {
		$text = implode(' ', $words);
		return '<p>'.$text.'</p>';
	}
}

endif;

/** 
 * Comments Template
 */

if ( ! function_exists( 'circularculture_comment' ) ) :

function circularculture_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
			include(get_template_directory().'/inc/comment_pingback_template.php');
		break;
		default :
		global $post;
			include(get_template_directory().'/inc/comment_default_template.php');
		break;
	endswitch;
}
endif;

/**
 * Remove Class from Sticky Post
 */

if ( ! function_exists( 'circularculture_remove_sticky' ) ) :

function circularculture_remove_sticky($classes) {
  $classes = array_diff($classes, array("sticky"));
  return $classes;
}

add_filter('post_class','circularculture_remove_sticky');

endif;

/**
 * Custom circularculture Title Tag
 * @see http://codex.wordpress.org/Plugin_API/Filter_Reference/wp_title
 */

function circularculture_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'circularculture' ), max( $paged, $page ) );

	return $title;
}

//add_filter( 'wp_title', 'circularculture_title', 10, 2 );

/**
 * Retrieve Shortcodes
 * @see: http://fwp.drewsymo.com/shortcodes/
 */

$circularculture_shortcodes = trailingslashit( get_template_directory() ) . 'inc/shortcodes.php';

if (file_exists($circularculture_shortcodes)) {
	require( $circularculture_shortcodes );
}

/**
 * Last entry widget
 *
 * Widget to show work's list
 */
 
add_action('widgets_init', 'register_works_widget');

function register_works_widget() {  
    register_widget( 'Circularculture_Works_Widget' );  
}  
 
class Circularculture_Works_Widget extends WP_Widget {

	var $Template_directory;

    function Circularculture_Works_Widget() {  
        $widget_ops = array( 
        	'classname' => 'workswidget', 
        	'description' => __('Widget to show works list', 'circularculture') 
        );  
        
        $control_ops = array('id_base' => 'works-widget' );
        
        $this->Template_directory = get_template_directory().'/inc/works-widget-templates';
        
        $this->WP_Widget( 'works-widget', __('CircularCulture works', 'circularculture'), $widget_ops, $control_ops );  
    }
    
    // display
    function widget( $args, $instance ) {
    	global $post;
    	
    	$current = 0;
    	if(is_single() &&sizeof($post)>0) $current = $post->ID;
    	
	    extract($args); 
	    
	    $title = apply_filters('widget_title', $instance['title'] );  
		$num_posts = $instance['num-posts'];
		    
		$qargs = array(
    		'post_type' => 'work',
    		'caller_get_posts' => 0
    	);
    	
    	if($num_post>0) $qargs['posts_per_page'] = $num_posts;
	
    	query_posts($qargs);
		
		include(get_template_directory().'/inc/cc_works_widget_display_template.php');
    }
    
    function update( $new_instance, $old_instance ) {  
    	$instance = $old_instance;  
  
    	//Strip tags from title and name to remove HTML  
    	$instance['title'] = strip_tags( $new_instance['title'] );  
       	$instance['num-posts'] = $new_instance['num-posts'];
       	    
    	return $instance;  
    }
    
    // Control widget
    function form($instance) {
    
    	$defaults = array( 
    		'title' => '', 
    		'num-posts' => 0
    	);  

    	$instance = wp_parse_args((array) $instance, $defaults);
    	
	    include(get_template_directory().'/inc/cc_works_widget_control_template.php');
    }
	
} 

?>