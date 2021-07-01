<?php if ( !defined('ABSPATH') ) die();
	
define( 'FS_THEME_VERSION', '1.0' );
define( 'FS_THEME_DIR', get_template_directory() );
define( 'FS_THEME_URL', get_template_directory_uri() );

$primary = get_theme_mod('primary_color', '#23252b');
$secondary = get_theme_mod('secondary_color', '#606060');
$accent = get_theme_mod('accent_color', '#ceff00');
$text_color = get_theme_mod('text_color', '#23252b');;
$bg = get_theme_mod('bg_color', '#f0f0f0');;		

// ------------------------
// Theme Setup
// ------------------------

if ( ! isset( $content_width ) )
	$content_width = 2048;


if ( ! function_exists( 'fs_setup' ) ) :

function fs_setup() {

	global $primary;
	global $secondary;
	global $accent;
	global $text_color;
	global $bg;	
	
	// I18n
	
	load_theme_textdomain( 'fs-townhall', FS_THEME_DIR . '/languages' );
	
	
	// Theme Support
	
	add_editor_style( array('css/editor-style.css') );
	
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );

	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	));

	add_theme_support( 'customize-selective-refresh-widgets' );
	
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
	
	add_post_type_support( 'page', 'excerpt' );

	
/*
	// https://codex.wordpress.org/Custom_Backgrounds
	
	add_theme_support( 'custom-background', array(
		'default-color'          => 'ffffff',
		'default-image'          => '',
		'default-repeat'         => 'repeat',
		'default-position-x'     => 'left',
	    'default-position-y'     => 'top',
	    'default-size'           => 'auto',
		'default-attachment'     => 'scroll',
		'wp-head-callback'       => '_custom_background_cb',
		'admin-head-callback'    => '',
		'admin-preview-callback' => ''
	));
	
	// https://codex.wordpress.org/Custom_Headers
	
	add_theme_support( 'custom-header', array(
		'default-image'          => get_template_directory_uri() . '/img/header.jpg',
		'width'                  => 0,
		'height'                 => 0,
		'flex-height'            => false,
		'flex-width'             => true,
		'uploads'                => true,
		'random-default'         => false,
		'header-text'            => true,
		'default-text-color'     => '',
		'wp-head-callback'       => '',
		'admin-head-callback'    => '',
		'admin-preview-callback' => '',
	));
	
	// https://codex.wordpress.org/Theme_Logo

	add_theme_support( 'custom-logo', array(
		'height'      => '',
		'width'       => '',
		'flex-height' => true,
		'flex-width'  => true,
		'header-text' => array( 'site-title', 'site-desc' ),
	));	

	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'status',
		'audio',
		'chat',
	));
*/



	// Gutenberg support 
	
	add_theme_support( 'align-wide' );
	
	add_theme_support( 'editor-color-palette', array(
	    
	    // Customizer colors
	    
	    array(
	        'name' => esc_html__( 'Primary color', 'fs-townhall' ),
	        'slug' => 'primary',
	        'color' => $primary,
	    ),
	    array(
	        'name' => esc_html__( 'Secondary color', 'fs-townhall' ),
	        'slug' => 'secondary',
	        'color' => $secondary,
	    ),
	    array(
	        'name' => esc_html__( 'Accent color', 'fs-townhall' ),
	        'slug' => 'accent',
	        'color' => $accent,
	    ),
		array(
			'name' => esc_html__( 'Text color', 'fs-townhall' ),
			'slug' => 'text',
			'color' => $text_color,
		),
	    array(
	        'name' => esc_html__( 'Background color', 'fs-townhall' ),
	        'slug' => 'bg',
	        'color' => $bg,
	    ),
		array(
	        'name' => esc_html__( 'White', 'fs-townhall' ),
	        'slug' => 'white',
	        'color' => '#fff',
	    ),
	    
	));	
	
	add_theme_support( 'disable-custom-colors' );

	add_theme_support( 'editor-font-sizes', array(
	    array(
	        'name' => __( 'Small', 'fs-townhall' ),
	        'shortName' => __( 'S', 'fs-townhall' ),
	        'size' => 14,
	        'slug' => 'small'
	    ),
	    array(
	        'name' => __( 'Large', 'fs-townhall' ),
	        'shortName' => __( 'L', 'fs-townhall' ),
	        'size' => 22,
	        'slug' => 'large'
	    ),
	));
	
	add_theme_support( 'disable-custom-font-sizes' );
	
	add_theme_support( 'responsive-embeds' );

}
endif;
add_action( 'after_setup_theme', 'fs_setup' );


// Gutenberg editor styles

function fs_block_editor_styles() {
    wp_enqueue_style( 
    	'fs_block_editor_styles',
    	FS_THEME_URL .'/css/block-editor-style.css', 
    	false, 
    	FS_THEME_VERSION, 
    	'screen'
    );
}
add_action( 'enqueue_block_editor_assets', 'fs_block_editor_styles' );


//	Admin style and script

add_action('admin_enqueue_scripts', 'fs_acf_admin_css', 11 );
function fs_acf_admin_css() {
	wp_enqueue_style( 'admin-css', FS_THEME_URL . '/css/admin.css' );
}

// WordPress no bloody admin mail notice and no bloody fullscreen

add_filter('admin_email_check_interval', '__return_false');

if (is_admin()) {
	function fs_disable_bloody_fullscreen() {
		$script = "jQuery( window ).load(function() { const isFullscreenMode = wp.data.select( 'core/edit-post' ).isFeatureActive( 'fullscreenMode' ); if ( isFullscreenMode ) { wp.data.dispatch( 'core/edit-post' ).toggleFeature( 'fullscreenMode' ); } });";
		wp_add_inline_script( 'wp-blocks', $script );
	}
	add_action( 'enqueue_block_editor_assets', 'fs_disable_bloody_fullscreen' );
}

// ------------------------
// JS & CSS
// ------------------------

function fs_scripts_load() {
    if (!is_admin()) {


		// Register JS
		// ------------------------
			
			// Fancybox
			
		    wp_register_script( 
		    	'fancybox', 
		    	FS_THEME_URL . '/js/jquery.fancybox.min.js',
		    	array('jquery'), 
		    	'3.1.20', 
		    	true
		    );
		    wp_register_script( 
		    	'fancybox-fs-init', 
		    	FS_THEME_URL . '/js/fancybox-init.js',
		    	array('fancybox'), 
		    	null, 
		    	true
		    );
			
			// Scroll-Out
			
			wp_register_script(
				'scrollout', 
				FS_THEME_URL . '/js/scroll-out.min.js', 
				array(), 
				FS_THEME_VERSION, 
				true
			);
			
			// IAS
			
			wp_register_script(
				'ias', 
				FS_THEME_URL . '/js/infinite-ajax-scroll.min.js', 
				array(), 
				FS_THEME_VERSION, 
				true
			);
			wp_register_script(
				'ias-fs-init', 
				FS_THEME_URL . '/js/infinite-ajax-scroll-init.js', 
				array('ias'), 
				FS_THEME_VERSION, 
				true
			);
			
			// Back 2 top
			
			wp_register_script(
				'back2top', 
				FS_THEME_URL . '/js/back2top.js', 
				array(), 
				FS_THEME_VERSION, 
				true
			);
			
			// Sticky Nav
			
			wp_register_script(
				'stickynav', 
				FS_THEME_URL . '/js/sticky-header.js', 
				array(), 
				FS_THEME_VERSION, 
				true
			);
			
			// Other stuff
			
			wp_register_script(
				'high-contrast', 
				FS_THEME_URL . '/js/high-contrast.js', 
				array('jquery'), 
				FS_THEME_VERSION, 
				true
			);
			wp_register_script(
				'cookie', 
				FS_THEME_URL . '/js/jquery.cookie.js', 
				array('jquery'), 
				FS_THEME_VERSION, 
				true
			);
			
			wp_register_script(
				'focus-visible', 
				FS_THEME_URL . '/js/focus-visible.min.js', 
				array(), 
				FS_THEME_VERSION, 
				true
			);
			
			wp_register_script(
				'skiplink-focus-fix', 
				FS_THEME_URL . '/js/skip-link-focus-fix.js', 
				array(), 
				FS_THEME_VERSION, 
				true
			);
			
			// Main
			
		    wp_register_script( 
			    	'main', 
			    	FS_THEME_URL . '/js/main.js',
			    	array('jquery'), 
			    	FS_THEME_VERSION, 
			    	true
		    );


		// Register CSS
		// ------------------------

			wp_register_style( 'back2top', 
				FS_THEME_URL . '/css/back2top.css',
				array(), 
				FS_THEME_VERSION, 
				'screen' 
			);
			
			// Fancybox
			
			wp_register_style( 
				'fancybox-css', 
				FS_THEME_URL . '/css/jquery.fancybox.min.css',
				array(), 
				null, 
				'screen' 
			);
			
			// Main stylesheet
			
			wp_register_style( 
				'fs-townhall-style', 
				get_stylesheet_uri(), 
				array(), 
				FS_THEME_VERSION, 
				'screen'
			);

		
		// Enqueue JS
		// ------------------------
			
			wp_enqueue_script( 'jquery' );
			
			if ( get_theme_mod('use_fancybox') == true ) {
				wp_enqueue_script( 'fancybox' );
				wp_enqueue_script( 'fancybox-fs-init' );
			}
			if ( get_theme_mod('use_ias') == true ) {
				$has_pages = get_the_posts_pagination();
				if (! empty( $has_pages) ) {
					if ( is_home() || is_archive() || is_search() || is_tax() ) {
						wp_enqueue_script( 'ias' );
						wp_enqueue_script( 'ias-fs-init' );
					}
				}
			}
			
			if ( get_theme_mod('use_scrollout') == true ) {
				wp_enqueue_script( 'scrollout' );
				function fs_scrollout_js() {
					print '
					<script>
						ScrollOut({
							targets: "section, .post-block, hr, .wpcf7-form",
							once: true,
						});
					</script>
					';
				}
				add_action('wp_footer', 'fs_scrollout_js', 100);
			}
			
			if ( get_theme_mod('contrast') == true ) {
				wp_enqueue_script( 'high-contrast' );
				wp_enqueue_script( 'cookie' );
			}
			if ( get_theme_mod('back2top') == true ) {
				wp_enqueue_script( 'back2top' );
			}
			if ( get_theme_mod('stickynav') == true ) {
				wp_enqueue_script( 'stickynav' );
			}
		    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}
			
			//wp_enqueue_script( 'focus-visible' );
			wp_enqueue_script( 'skiplink-focus-fix' );
			wp_enqueue_script( 'main' );			


		// Enqueue CSS
		// ------------------------

			
			
			// Fancybox
			if ( get_theme_mod('use_fancybox') == true ) {
				wp_enqueue_style( 'fancybox-css' );
			}
	
			// Back to top
			if ( get_theme_mod('back2top') == true ) {
				wp_enqueue_style( 'back2top' );
			}
			
			// Main stylesheet
			wp_enqueue_style( 'fs-townhall-style' );
	}
}    
add_action( 'wp_enqueue_scripts', 'fs_scripts_load' );


// ------------------------
// Theme Stuff
// ------------------------


// Customizer

require FS_THEME_DIR . '/inc/customizer.php';


// Register Navigation Menus

function fs_custom_nav_menus() {

	$locations = array(
		'toolbar_menu' =>  esc_html__( 'Toolbar Menu', 'fs-townhall' ),
		'main_menu' =>  esc_html__( 'Main Menu', 'fs-townhall' ),
		'footer_menu' => esc_html__( 'Footer Menu', 'fs-townhall' ),
		'social_menu' => esc_html__( 'Social Menu', 'fs-townhall' )
	);
	register_nav_menus( $locations );

}
add_action( 'init', 'fs_custom_nav_menus' );


// Nav highlights fix

function fs_nav_classes( $classes, $item ) {
    
	// Remove active state on page for posts
    if( ( is_post_type_archive() || is_tax() || is_404() || is_search() || is_singular('event') ) && $item->title == 'Actualités' ) {
        $classes = array_diff( $classes, array( 'current_page_parent' ) );
    }
    return $classes;
}
add_filter( 'nav_menu_css_class', 'fs_nav_classes', 10, 2 );


// CPT highlights

function fs_custom_active_item_classes($classes = array(), $menu_item = false) {            
        global $post;
		if ( is_singular() ) {
        	$classes[] = ($menu_item->url == get_post_type_archive_link($post->post_type)) ? 'current-menu-item' : '';
		}
        return $classes;
    }
add_filter( 'nav_menu_css_class', 'fs_custom_active_item_classes', 10, 2 );


// Nav tag for widget menus

function fs_modify_nav_menu_args( $args ) {

	if( empty ( $args['theme_location'] ) ) {
		$args['container'] = 'nav';
	}
	return $args;
}
add_filter( 'wp_nav_menu_args', 'fs_modify_nav_menu_args' );


// Sub-menus Walker

include_once( FS_THEME_DIR . '/inc/subnav-walker.php' );


// Extended Search

include_once( FS_THEME_DIR . '/inc/fs-extended-search.php' );


// Archives titles

add_filter( 'get_the_archive_title', function ($title) {

    if ( is_category() ) {

        $title = single_cat_title( '', false );

    } elseif ( is_tag() ) {

        $title = single_tag_title( '', false );

    } elseif ( is_post_type_archive() ) {

        $title = post_type_archive_title( '', false );
    
    } elseif ( is_tax() ) {

        $title = single_term_title( '', false );
    } 

    return $title;

});


// Excerpts lenght

function fs_custom_excerpt_length( $length ) {
	$words = get_theme_mod('ex_lenght', 24);
	return $words;
}
add_filter( 'excerpt_length', 'fs_custom_excerpt_length', 999 );


// Excerpt link

function fs_excerpt_more( $more ) {
    return sprintf( '&hellip; <a class="read-more" href="%1$s" rel="nofollow">%2$s</a>',
        get_permalink( get_the_ID() ),
        __( 'Read More', 'fs-townhall' )
    );
}
add_filter( 'excerpt_more', 'fs_excerpt_more' );


// Custom excerpt
// https://gist.github.com/samjbmason/4050714

function fs_share_excerpt($count, $post_id){
  $permalink = get_permalink($post_id);
  $excerpt = get_post($post_id);
  $excerpt = $excerpt->post_content;
  $excerpt = strip_tags($excerpt);
  $excerpt = substr($excerpt, 0, $count);
  $excerpt = substr($excerpt, 0, strripos($excerpt, " "));

  $excerpt = $excerpt.'...';
  return $excerpt;
}

// Page excerpt

function fs_page_excerpt() {
	global $post;   
    if( $post->post_excerpt ) {
        $content = get_the_excerpt();
    } else {
		$content = null;
	}
    return $content;
}


// Image Sizes

add_image_size( 'thumbnail-hd', 320, 320, true );
add_image_size( 'medium-hd', 640, 640, false );
add_image_size( 'large-hd', 2048, 2048, false );
add_image_size( 'screen-md', 720, 450, true );
add_image_size( 'screen-hd', 1440, 900, true );
add_image_size( 'video-md', 960, 540, true );
add_image_size( 'video-hd', 1920, 1080, true );

function fs_custom_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'thumbnail-hd'	=> __( 'Thumbnail x2', 'fs-townhall' ),
        'medium-hd'		=> __( 'Medium x2', 'fs-townhall' ),
        'large-hd'		=> __( 'Large x2', 'fs-townhall' ),
        'screen-md'		=> __( 'Screen Medium', 'fs-townhall' ),
        'screen-hd'		=> __( 'Screen Full', 'fs-townhall' ),
        'video-md'		=> __( 'Video Medium', 'fs-townhall' ),
        'video-hd'		=> __( 'Video Full', 'fs-townhall' ),
    ) );
}
add_filter( 'image_size_names_choose', 'fs_custom_sizes' );


// Background image

function fs_bg_img() {
	
	$default = get_theme_mod('bg_default');
	$blog = get_theme_mod('bg_blog');
	$error = get_theme_mod('bg_404');
	
	if ( is_404() && $error ) {
		$bg = ' data-bg="has-bg" style="background-image: url('.$error.')"';
	
	} else if ( ( is_home() || is_category() ) && $blog ) {
		$bg = ' data-bg="has-bg" style="background-image: url('.$blog.')"';
		
	} else if ( '' != get_the_post_thumbnail() ) {
		$img_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large-hd' );
		$bg = ' data-bg="has-bg" style="background-image: url('.$img_url[0].')"';
	
	} else if ( $default ) {
		$bg = ' data-bg="has-bg" style="background-image: url('.$default.')"';
	
	} else {
		$bg = null;
	}
	
	echo $bg;
}

// Widgets

function fs_widgets_init() {
	register_sidebar(array(
		'name'			=>	esc_html__( 'Blog Widgets', 'fs-townhall' ),
		'id'			=>	'widgets_area1',
		'description' 	=> 	'',
		'before_widget' => 	'<div id="%1$s" class="widget-container %2$s">',
		'after_widget' 	=> 	'</div>',
		'before_title' 	=> 	'<p class="widget-title">',
		'after_title' 	=> 	'</p>',
	));
	register_sidebar(array(
		'name'			=>	esc_html__( 'Footer Widgets #1', 'fs-townhall' ),
		'id'			=>	'widgets_footer1',
		'description' 	=> 	'',
		'before_widget' => 	'<div id="%1$s" class="widget-container %2$s">',
		'after_widget' 	=> 	'</div>',
		'before_title' 	=> 	'<p class="widget-title">',
		'after_title' 	=> 	'</p>',
	));
	register_sidebar(array(
		'name'			=>	esc_html__( 'Footer Widgets #2', 'fs-townhall' ),
		'id'			=>	'widgets_footer2',
		'description' 	=> 	'',
		'before_widget' => 	'<div id="%1$s" class="widget-container %2$s">',
		'after_widget' 	=> 	'</div>',
		'before_title' 	=> 	'<p class="widget-title">',
		'after_title' 	=> 	'</p>',
	));
	register_sidebar(array(
		'name'			=>	esc_html__( 'Footer Widgets #3', 'fs-townhall' ),
		'id'			=>	'widgets_footer3',
		'description' 	=> 	'',
		'before_widget' => 	'<div id="%1$s" class="widget-container %2$s">',
		'after_widget' 	=> 	'</div>',
		'before_title' 	=> 	'<p class="widget-title">',
		'after_title' 	=> 	'</p>',
	));
}
add_action( 'widgets_init', 'fs_widgets_init' );


// Tinymce class

function fs_mce_buttons_2($buttons) {
    array_unshift($buttons, 'styleselect');
    return $buttons;
}
add_filter('mce_buttons_2', 'fs_mce_buttons_2');

function fs_tiny_formats($init_array) {

    $style_formats = array(

        array(
            'title' => __( 'Text intro', 'fs-townhall' ),
            'selector' => 'p',
            'classes' => 'text-intro',
            'wrapper' => true,
        ),
        array(
            'title' => __( 'Text mentions', 'fs-townhall' ),
            'selector' => 'p',
            'classes' => 'text-mentions',
            'wrapper' => true,
        ),
        array(
            'title' => __( 'Action button', 'fs-townhall' ),
            'selector' => 'a',
            'classes' => 'action-btn',
        )
    );
    
    // Filter
    $style_formats = apply_filters( 'fs_tiny_formats', $style_formats ); 
    
    $init_array['style_formats'] = json_encode($style_formats);
    return $init_array;

}
add_filter('tiny_mce_before_init', 'fs_tiny_formats');


// Custom search form

function fs_search_form( $form ) {
    $form = '<form role="search" method="get" id="searchform" class="searchform" action="' . home_url( '/' ) . '" >
    <label class="screen-reader-text" for="s">' . __( 'Search for:', 'fs-townhall' ) . '</label>
    <input type="search" value="' . get_search_query() . '" name="s" id="s">
    <input type="submit" class="action-btn" id="searchsubmit" value="'. esc_attr__( 'Search', 'fs-townhall' ) .'">
    </form>';
 
    return $form;
}
add_filter( 'get_search_form', 'fs_search_form' );


// Custom comment HTML

function fs_custom_comments($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<div class="comment-author avatar">
				<?php
					echo get_avatar( $comment, 192 );
				?>
			</div>

			<div class="comment-content">
				<div class="comment-author-name">
					<?php 
						printf( '<span class="fn">%s</span>', get_comment_author_link() );
					?>
				</div>
				<div class="comment-date">
					<?php 
						printf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
							esc_url( get_comment_link( $comment->comment_ID ) ),
							get_comment_time( 'c' ),
							sprintf( __( '%1$s at %2$s', 'fs-townhall' ), get_comment_date(), get_comment_time() )
						);
					?>
				</div>
				<div class="comment-author-text">
					<?php if ($comment->comment_approved == '0') : ?>
						<em class="pending"><?php esc_html_e('Your comment is awaiting moderation.', 'fs-townhall') ?></em>
					<?php endif; ?>
					
					<?php comment_text(); ?>
				</div>
			</div>

			<div class="reply">
				<?php comment_reply_link( array_merge($args, array(
				    'reply_text' => __('Reply', 'fs-townhall'),
				    'depth'      => $depth,
				    'max_depth'  => $args['max_depth']
				    )
				)); ?>
			</div>
			<?php edit_comment_link( __( 'Edit', 'fs-townhall' ), '<span class="edit-link">', '</span>' ); ?>

		</article>
		
<?php }


// Custom loops 

function fs_showall_loop( $query ) {
	if ( is_admin() || ! $query->is_main_query() )
		return;

	if ( is_post_type_archive( 'project' ) ) {
		$query->set( 'posts_per_page', -1 );
		$query->set( 'orderby', 'title' );
		$query->set( 'order', 'ASC' );
		return;
	}
}
add_action( 'pre_get_posts', 'fs_showall_loop', 1 );



// ------------------------
// ACF
// ------------------------


if( class_exists('acf') ) {

	// Remove the WP Custom Fields meta box
	
	add_filter('acf/settings/remove_wp_meta_box', '__return_true');		
	
	// Custom blocks

	$my_blocks = array_diff( scandir(FS_THEME_DIR . '/blocks'), array('..', '.', '.DS_Store') );
	
	foreach( $my_blocks as $block ) {
		include_once 'blocks/'. $block .'/'. $block .'.php';
		include_once 'blocks/'. $block .'/'. $block .'-fields.php';
	}	
	
	// Front-End ACF Functions
	
	add_filter('acf/settings/save_json', 'fs_acf_json_save_point');
	function fs_acf_json_save_point( $path ) {
	    
	    $path = FS_THEME_DIR . '/inc/acf';
	    
	    return $path;
	}
	add_filter('acf/settings/load_json', 'fs_acf_json_load_point');
	function fs_acf_json_load_point( $paths ) {
	    
	    unset($paths[0]);
	
	    $paths[] = FS_THEME_DIR . '/inc/acf';
	    
	    return $paths;
	}

	// ACF colors

	add_action('acf/input/admin_footer', 'fs_acf_colors_script');	

	function fs_acf_colors_script() {

		global $primary;
		global $secondary;
		global $accent;
		global $text_color;
		global $bg;
				
		$colors = ' "'.$primary.'", "'.$secondary.'", "'.$accent.'", "'.$text_color.'", "'.$bg.'" ';
	 ?>
	    <script type="text/javascript">
	    (function($){
	        
			acf.add_filter('color_picker_args', function( args, field ){
			
			    args.palettes = [ <?php echo $colors; ?> ]
			
			    return args;
			
			});	
	        
	    })(jQuery);
	    </script>
	    <?php
	}
	
	// Social Menu icons
	
	require_once( FS_THEME_DIR . '/inc/acf/social-icons-fields.php' );
	
	add_filter('wp_nav_menu_objects', 'fs_nav_menu_icons', 10, 2);
	
	function fs_nav_menu_icons( $items, $args ) {
		
		foreach( $items as $item ) {
			
			$icon = get_field('icon', $item);
			
			if( $icon ) {
				$item->classes[] = 'social-item';
				$item->title = '<img src="'.$icon['url'].'" alt=""><span>'.$item->title.'</span>';
			}		
		}

		return $items;
	}
	
	
	// Widgets
	/*
	add_filter('dynamic_sidebar_params', 'fs_dynamic_sidebar_footer');
	
	function fs_dynamic_sidebar_footer( $params ) {
		
		$widget_id = $params[0]['widget_id'];
		
		$icon = get_field('icon', 'widget_' . $widget_id);
		
		if( $icon ) {
			
			$params[0]['before_title'] = '<img class="icon" src="' . $icon['url'] . '" alt="">' . $params[0]['before_title'];
			$params[0]['before_widget'] = preg_replace( '/class="widget-/', '/class="has-icon widget-', $params[0]['before_widget'], 1 );		
		}
		
		// return
		return $params;
	}
	*/

	//	ACF Options page
	/*
	if (function_exists('acf_add_options_page')) {
	    
		add_action( 'init', 'fs_acf_add_options_page' );
		function fs_acf_add_options_page() {
			
			$parent = acf_add_options_page(array(
				'page_title'	=> esc_html__( 'Site Options', 'fs-townhall' ),
				'menu_title'	=> esc_html__( 'Site Options', 'fs-townhall' ),
				'menu_slug'		=> 'options-site',
				'capability'	=> 'edit_posts',
				'icon_url'		=> 'dashicons-admin-network',
				'redirect'		=> false,
				'position'		=> 30
			));
			acf_add_options_sub_page(array(
				'page_title' 	=> esc_html__( 'Archives Customizer', 'fs-townhall'),
				'menu_title' 	=> esc_html__( 'Archives Customizer', 'fs-townhall'),
				'parent_slug' 	=> $parent['menu_slug'],
				'menu_slug'		=> 'options-site-archives'
			));	
			acf_add_options_sub_page(array(
				'page_title' 	=> esc_html__( 'Social Networks', 'fs-townhall'),
				'menu_title' 	=> esc_html__( 'Social Networks', 'fs-townhall'),
				'parent_slug' 	=> $parent['menu_slug'],
				'menu_slug'		=> 'options-site-social'
			));
			
		}
	}
	*/
	
	// Translate ACF fields
		
	function fs_custom_acf_settings_localization($localization){
	  return true;
	}
	add_filter('acf/settings/l10n', 'fs_custom_acf_settings_localization');
	
	function fs_custom_acf_settings_textdomain($domain){
	  return 'fs-townhall';
	}
	add_filter('acf/settings/l10n_textdomain', 'fs_custom_acf_settings_textdomain');
	
}


// WP-Rocket

function fs_wp_rocket_add_purge_posts_to_author() {
	// gets the author role object
	$role = get_role('editor');
 
	// add a new capability
	$role->add_cap('rocket_purge_cache', true);
}
add_action('init', 'fs_wp_rocket_add_purge_posts_to_author', 12);


// ------------------------
// Auto-Updater
// ------------------------

// Remove these lines and dependencies for your theme

require 'inc/plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/anybodesign/fs-townhall',
	__FILE__,
	'fs-townhall'
);
$myUpdateChecker->setBranch('master');