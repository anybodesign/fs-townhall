<?php if ( !defined('ABSPATH') ) die();
/**
 * @package WordPress
 * @subpackage FS_Townhall
 * @since 1.0
 * @version 1.0
 */
 	$cats = get_theme_mod('cat_dropdown');
	$tax = get_theme_mod('tax_filters');
?>
					<?php if ( $cats && ( is_home() || is_category() ) ) { ?>
					<div class="page-filters">
						<div class="inner">
							
							<div class="filter-cat">
								<label for="cat">
									<?php _e('Categories', 'fs-townhall'); ?>
								</label>
								<div class="formfield-select--container">
									<?php
										$args = array(
											'show_option_all' => __( 'All categories', 'fs-townhall' ),
										);
										wp_dropdown_categories( $args ); 
									?>
								</div>
								<script>
									var siteUrl = '<?php esc_url(bloginfo('url')); ?>';
									document.getElementById('cat').onchange = function(){
										if( this.value !== '-1' ){
											window.location=siteUrl +'/?cat='+this.value
										}
									}
								</script>
							</div>
								
						</div>
					</div>	
					<?php } ?>
					
					
					<?php if ( $tax && ( is_post_type_archive('event') || is_tax('event_type') || is_tax('event_period') ) ) { ?>
					<div class="page-filters">
						<div class="inner">
							
							<div class="filter-type">
								<label for="type">
									<?php _e('Event type', 'fs-townhall'); ?>
								</label>
								<div class="formfield-select--container">
									<?php
										$args = array(
											'show_option_all' => __( 'Event type', 'fs-townhall' ),
											'taxonomy' => 'event_type',
											'id' => 'type',
											'value_field' => 'slug',
										);
										wp_dropdown_categories( $args ); 
									?>
								</div>
							</div>
							
							<div class="filter-period">
								<label for="period">
									<?php _e('Period', 'fs-townhall'); ?>
								</label>
								<div class="formfield-select--container">
									<?php
										$periods = array(
											'show_option_all' => __( 'Period', 'fs-townhall' ),
											'taxonomy' => 'event_period',
											'id' => 'period',
											'value_field' => 'slug',
										);
										wp_dropdown_categories( $periods ); 
									?>
								</div>
							</div>
							
							<script>
								var siteUrl = '<?php esc_url(bloginfo('url')); ?>';
								
								document.getElementById('type').onchange = function() {
									if( this.value !== '' ){
										window.location=siteUrl +'/?event_type='+this.value
									}
								}
								document.getElementById('period').onchange = function() {
									if( this.value !== '' ){
										window.location=siteUrl +'/?event_period='+this.value
									}
								}
							</script>
							
							
						</div>
					</div>
					<?php } ?>