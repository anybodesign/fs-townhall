<?php if ( !defined('ABSPATH') ) die();
/**
 * @package WordPress
 * @subpackage FS_Townhall
 * @since 1.0
 * @version 1.0
 */
?>
						<?php if ( get_theme_mod('use_ias') == true ) {
							$pages = get_the_posts_pagination();
							if (! empty( $pages) ) {
								
								get_template_part('template-parts/post', 'pagination-spinner');
								get_template_part('template-parts/post', 'pagination-trigger');
								get_template_part('template-parts/post', 'pagination-nomore');
							} 
						} ?>
						
						<div class="pagination" id="posts_nav">
						<?php
							if ( function_exists('wp_pagenavi') ) {
								wp_pagenavi();
							} else {
								the_posts_pagination(array(
									'prev_text'          => __( 'Previous page', 'fs-townhall' ),
									'next_text'          => __( 'Next page', 'fs-townhall' ),
									'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'fs-townhall' ) . ' </span>',
								));
							}
						?>
						</div>
