<?php if ( !defined('ABSPATH') ) die();
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package WordPress
 * @subpackage FS_Townhall
 * @since 1.0
 * @version 1.0
 */
get_header(); ?>
					
				<div class="page-wrap">

					<?php 
						get_template_part( 'template-parts/page', 'banner' ); 
					?>
					
					<div class="page-content">
							
						<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'fs-townhall' ); ?></p>
						<?php get_search_form(); ?>		
																			
					</div>	
									
				</div>

<?php get_footer(); ?>