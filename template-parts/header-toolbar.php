<?php if ( !defined('ABSPATH') ) die(); ?>
			
		<?php if ( has_nav_menu( 'toolbar_menu' ) || get_theme_mod('searchbar') || get_theme_mod('contrast') ) : ?>
			
			<div class="site-toolbar<?php if ( get_theme_mod('searchbar') ) { echo ' has-search'; } ?>">
				
				<?php if ( has_nav_menu( 'toolbar_menu' ) ) { ?>
				<nav role="navigation" aria-label="<?php esc_html_e('Toolbar Menu', 'fs-townhall'); ?>">
					<?php wp_nav_menu( array(
						'theme_location'	=> 	'toolbar_menu',
						'menu_class'		=>	'toolbar-menu',
						'container'			=>	false,
						));
					?>
				</nav>
				<?php } ?>
				
				<?php if ( get_theme_mod('searchbar') || get_theme_mod('contrast') ) { ?>
				<div class="toolbar-widgets">
				
					<?php if ( get_theme_mod('searchbar') ) { ?>
						<button id="search_toggle" type="button" aria-controls="site_search" aria-expanded="false">
							<img src="<?php echo FS_THEME_URL. '/img/ui/search.svg'; ?>" alt="<?php esc_attr_e( 'Search', 'fs-townhall' ); ?>">
						</button>
					<?php } ?>
					
					<?php if ( get_theme_mod('contrast') == true ) { ?>
					<div class="contrast-switch">
						<button class="toggle-highcontrast" type="button">
							<img src="<?php echo FS_THEME_URL; ?>/img/ui/contrast-on.svg" alt="">
							<span><?php esc_html_e('High contrast', 'fs-townhall'); ?></span>
						</button>
						<button class="toggle-remove" type="button">
							<img src="<?php echo FS_THEME_URL; ?>/img/ui/contrast-off.svg" alt="">
							<span><?php esc_html_e('Restore contrast', 'fs-townhall'); ?></span>
						</button>
					</div>
					<?php } ?>
					
				</div>
				<?php } ?>
				
			</div>
			
		<?php endif; ?>	