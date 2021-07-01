<?php if ( !defined('ABSPATH') ) die();
/**
 * @package WordPress
 * @subpackage FS_Townhall
 * @since 1.0
 * @version 1.0
 */
?>
		<?php
			if ( is_page() ) {
				
				$parent = $post->post_parent;
				
				if ( $parent ) {
					$children = wp_list_pages("title_li=&child_of=".$parent."&echo=0");
				} else {
					$children = wp_list_pages("title_li=&child_of=".$post->ID."&echo=0");
				}
				
					if ( $children ) { ?>
					<nav class="sub-pages">
						<ul class="subpages-list">
							<?php echo $children; ?>
						</ul>
					</nav>
					<?php }
					
					else {
						echo fs_page_excerpt();						
					}				
			}
			
			// Blog excerpt
			
			$blog = get_theme_mod('blog_excerpt','');
			if ( $blog && is_home() ) {
				echo esc_html($blog);
			} 
			
			// Agenda excerpt
			
			$agenda = get_theme_mod('agenda_excerpt','');
			if ( $agenda && is_post_type_archive( 'event' ) ) {
				echo esc_html($agenda);
			} 
		?>