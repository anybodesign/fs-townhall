<?php if ( !defined('ABSPATH') ) die();
/**
 * The main template file.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage FS_Townhall
 * @since 1.0
 * @version 1.0
 */ 
	if ( get_theme_mod('blog_sidebar') != true ) {
		$sidebar = false;
	} elseif ( is_search() || is_post_type_archive('event') ) {
		$sidebar = false;
	} else {
		$sidebar = true;
	}	
get_header(); ?>

				<?php get_template_part( 'template-parts/page', 'banner' ); ?>
				
				<div class="page-wrap<?php if ($sidebar) { echo ' has-sidebar'; } ?>">
					
					<div class="page-content">
							
						<?php // The Loop
							if ( have_posts() ) :  
							get_template_part( 'template-parts/post', 'filters' ); 
						?>
							
						<div id="posts_list" class="the-posts" >
							<?php 
								while ( have_posts() ) : the_post();
									get_template_part( 'template-parts/post', 'block' ); 
								endwhile;
							?>
						</div>
						
						<?php get_template_part( 'template-parts/post', 'pagination' ); ?>
						
						<?php
						else:
							get_template_part( 'template-parts/nothing' );
						endif; 
						?>
					</div>
					
					<?php if ($sidebar) { get_sidebar(); } ?>
					
				</div>

<?php get_footer(); ?>