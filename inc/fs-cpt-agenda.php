<?php defined('ABSPATH') or die();

// i18n & Flush Rewrites

load_plugin_textdomain( 
	'fs-townhall', 
	false, 
	basename( dirname( __FILE__ ) ) . '/languages' 
);

function activate_ad_cpt_agenda() {
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'activate_ad_cpt_agenda' );
add_action( 'init', 'activate_ad_cpt_agenda' );


// CPT 

class FS_CPT_AGENDA {
	
	function __construct() {	}
	
	function init() {
		add_action( 'init', array( $this, 'fs_cpt_agenda'), 1 );
		add_action( 'init', array( $this, 'fs_agenda_type'), 1 );
		add_action( 'init', array( $this, 'fs_agenda_period'), 1 );
		//add_action( 'pre_get_posts', array( $this, 'pre_get_posts' ), 1 );
		
		add_filter( 'enter_title_here', array( $this, 'ad_change_title_text' ) );
		add_filter( 'manage_edit-event_columns', array( $this, 'add_new_columns_event' ) );
		add_filter( 'manage_event_posts_custom_column', array( $this, 'manage_columns_event' ) );
		
	}

	/**
	*
	*	Register Custom Post Type
	*
	**/
	
	
	function fs_cpt_agenda() {

		$labels = array(
			'name'                  => _x( 'Events', 'Post Type General Name', 'fs-townhall' ),
			'singular_name'         => _x( 'Event', 'Post Type Singular Name', 'fs-townhall' ),
			'menu_name'             => __( 'Events', 'fs-townhall' ),
			'name_admin_bar'        => __( 'Event', 'fs-townhall' ),
			'archives'              => __( 'Item Archives', 'fs-townhall' ),
			'attributes'            => __( 'Item Attributes', 'fs-townhall' ),
			'parent_item_colon'     => __( 'Parent Item:', 'fs-townhall' ),
			'all_items'             => __( 'All Items', 'fs-townhall' ),
			'add_new_item'          => __( 'Add New Item', 'fs-townhall' ),
			'add_new'               => __( 'Add New', 'fs-townhall' ),
			'new_item'              => __( 'New Item', 'fs-townhall' ),
			'edit_item'             => __( 'Edit Item', 'fs-townhall' ),
			'update_item'           => __( 'Update Item', 'fs-townhall' ),
			'view_item'             => __( 'View Item', 'fs-townhall' ),
			'view_items'            => __( 'View Items', 'fs-townhall' ),
			'search_items'          => __( 'Search Item', 'fs-townhall' ),
			'not_found'             => __( 'Not found', 'fs-townhall' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'fs-townhall' ),
			'featured_image'        => __( 'Featured Image', 'fs-townhall' ),
			'set_featured_image'    => __( 'Set featured image', 'fs-townhall' ),
			'remove_featured_image' => __( 'Remove featured image', 'fs-townhall' ),
			'use_featured_image'    => __( 'Use as featured image', 'fs-townhall' ),
			'insert_into_item'      => __( 'Insert into item', 'fs-townhall' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'fs-townhall' ),
			'items_list'            => __( 'Items list', 'fs-townhall' ),
			'items_list_navigation' => __( 'Items list navigation', 'fs-townhall' ),
			'filter_items_list'     => __( 'Filter items list', 'fs-townhall' ),
		);
		$rewrite = array(
			'slug'                  => __( 'event', 'fs-townhall'),
			'with_front'            => true,
			'pages'                 => true,
			'feeds'                 => false,
		);
		$args = array(
			'label'                 => __( 'Events', 'fs-townhall' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'taxonomies'            => array( 'event_type' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'menu_icon'             => 'dashicons-calendar-alt',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => __( 'events', 'fs-townhall'),
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'rewrite'               => $rewrite,
			'capability_type'       => 'post',
			'show_in_rest'          => true,
		);
		register_post_type( 'event', $args );
	}
	

	/**
	*
	*	Custom Enter title here
	*
	**/

	
	function ad_change_title_text( $title ) {
		$screen = get_current_screen();

		if( 'event' == $screen->post_type ) {
			$title = __('Choose a title for this event', 'fs-townhall');
		}

		return $title;
	}


	/**
	*
	*	Custom Columns
	*
	**/


	function add_new_columns_event( $wp_columns ) {
		
		$column_before = array();
		$column_after['event_date'] = __('Event date','fs-townhall');
		//$column_after['visuel'] = __('Picture','fs-townhall');
		
		//unset( $wp_columns['date'] );
		
		$wp_columns = array_merge( $column_before, $wp_columns, $column_after );
		
		return $wp_columns;
	}

	function manage_columns_event( $column_name ) {
		global $wpdb, $post;

		switch( $column_name ) {
			
			case 'event_date':
				$date_string = get_field( 'event_starting_date', $post->ID );
				$date_string2 = get_field( 'event_ending_date', $post->ID );
				$date = DateTime::createFromFormat('Y-m-d', $date_string);
				$date2 = DateTime::createFromFormat('Y-m-d', $date_string2);
				if ($date_string) {
					echo $date->format('d/m/Y');
					//echo $date_string;
				}
				if ($date_string2) {
					echo ' - '.$date2->format('d/m/Y');
				}
			break;
			
			// case 'visuel':
			// 	if( has_post_thumbnail( $post->ID ) ){
			// 		echo get_the_post_thumbnail( $post->ID, array(90,60) );
			// 	}
			// 	break;
				
			default:
				break;
		} // end switch
	}

	

	/**
	*
	*	Register Custom Taxonomy
	*
	**/
	
	function fs_agenda_type() {
		
		$labels = array(
			'name'                       => _x( 'Events types', 'Taxonomy General Name', 'fs-townhall' ),
			'singular_name'              => _x( 'Event type', 'Taxonomy Singular Name', 'fs-townhall' ),
			'menu_name'                  => __( 'Event type', 'fs-townhall' ),
			'all_items'                  => __( 'All Items', 'fs-townhall' ),
			'parent_item'                => __( 'Parent Item', 'fs-townhall' ),
			'parent_item_colon'          => __( 'Parent Item:', 'fs-townhall' ),
			'new_item_name'              => __( 'New Item Name', 'fs-townhall' ),
			'add_new_item'               => __( 'Add New Item', 'fs-townhall' ),
			'edit_item'                  => __( 'Edit Item', 'fs-townhall' ),
			'update_item'                => __( 'Update Item', 'fs-townhall' ),
			'view_item'                  => __( 'View Item', 'fs-townhall' ),
			'separate_items_with_commas' => __( 'Separate items with commas', 'fs-townhall' ),
			'add_or_remove_items'        => __( 'Add or remove items', 'fs-townhall' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'fs-townhall' ),
			'popular_items'              => __( 'Popular Items', 'fs-townhall' ),
			'search_items'               => __( 'Search Items', 'fs-townhall' ),
			'not_found'                  => __( 'Not Found', 'fs-townhall' ),
			'no_terms'                   => __( 'No items', 'fs-townhall' ),
			'items_list'                 => __( 'Items list', 'fs-townhall' ),
			'items_list_navigation'      => __( 'Items list navigation', 'fs-townhall' ),
		);
		$rewrite = array(
			'slug'						=> __( 'event-type', 'fs-townhall'),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => false,
			'rewrite'					 => $rewrite,
			'query_var'                  => true,
			'show_in_rest'               => true,
		);
		register_taxonomy( 'event_type', array( 'event' ), $args );
		
	}
	
	function fs_agenda_period() {
		
		$labels = array(
			'name'                       => _x( 'Periods', 'Taxonomy General Name', 'fs-townhall' ),
			'singular_name'              => _x( 'Period', 'Taxonomy Singular Name', 'fs-townhall' ),
			'menu_name'                  => __( 'Period', 'fs-townhall' ),
			'all_items'                  => __( 'All Items', 'fs-townhall' ),
			'parent_item'                => __( 'Parent Item', 'fs-townhall' ),
			'parent_item_colon'          => __( 'Parent Item:', 'fs-townhall' ),
			'new_item_name'              => __( 'New Item Name', 'fs-townhall' ),
			'add_new_item'               => __( 'Add New Item', 'fs-townhall' ),
			'edit_item'                  => __( 'Edit Item', 'fs-townhall' ),
			'update_item'                => __( 'Update Item', 'fs-townhall' ),
			'view_item'                  => __( 'View Item', 'fs-townhall' ),
			'separate_items_with_commas' => __( 'Separate items with commas', 'fs-townhall' ),
			'add_or_remove_items'        => __( 'Add or remove items', 'fs-townhall' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'fs-townhall' ),
			'popular_items'              => __( 'Popular Items', 'fs-townhall' ),
			'search_items'               => __( 'Search Items', 'fs-townhall' ),
			'not_found'                  => __( 'Not Found', 'fs-townhall' ),
			'no_terms'                   => __( 'No items', 'fs-townhall' ),
			'items_list'                 => __( 'Items list', 'fs-townhall' ),
			'items_list_navigation'      => __( 'Items list navigation', 'fs-townhall' ),
		);
		$rewrite = array(
			'slug'						=> __( 'event-period', 'fs-townhall'),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => false,
			'rewrite'					 => $rewrite,
			'query_var'                  => true,
			'show_in_rest'               => true,
		);
		register_taxonomy( 'event_period', array( 'event' ), $args );
		
	}
	
	
}

$ad_cpt = new FS_CPT_AGENDA();
$ad_cpt->init();