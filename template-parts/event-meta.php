<?php if ( !defined('ABSPATH') ) die();
/**
 * @package WordPress
 * @subpackage FS_Townhall
 * @since 1.0
 * @version 1.0
 */
?>
							<div class="post-meta">
								
								<p class="meta-infos">
									<?php 
										esc_html_e( 'Posted ', 'fs-townhall' );
										esc_html_e( 'on&nbsp;', 'fs-townhall' ); 
										echo the_time( get_option('date_format') ); 
									?>
								</p>
								
							</div>