<?php if ( !defined('ABSPATH') ) die();
/**
 * Template part for displaying page or post content.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage FS_Townhall
 * @since 1.0
 * @version 1.0
 */
?>
					<div class="page-content">
					<?php while ( have_posts() ) : the_post(); ?>
						
						<?php if ( '' != get_the_post_thumbnail() ) { ?>
						<div class="post-figure">
							<?php the_post_thumbnail('large-hd'); ?>
						</div>
						<?php } ?>
						
						<?php 
							the_content();
							
							wp_link_pages(
								array(
									'before'      => '<nav class="post-nav-links" aria-label="' . esc_attr__( 'Page', 'fs-townhall' ) . '"><span class="label">' . __( 'Pages:', 'fs-townhall' ) . '</span>',
									'after'       => '</nav>',
									'link_before' => '<span class="page-number">',
									'link_after'  => '</span>',
									'aria_current'     => 'page',
        							'next_or_number'   => 'number',
									'separator'        => ' ',
									'nextpagelink'     => __( 'Next page', 'fs-townhall' ),
									'previouspagelink' => __( 'Previous page', 'fs-townhall' ),
        							'pagelink'         => '%',
								)
							); 
						    
							if ( is_single() && get_theme_mod('share_box') == true ) {
								get_template_part( 'template-parts/post', 'share' );
							}
							
							
							if ( comments_open() || get_comments_number() ) {
								comments_template();
							}
						?>
						
					<?php endwhile; ?>
					</div>					