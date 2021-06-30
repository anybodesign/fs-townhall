<?php if ( !defined('ABSPATH') ) die(); ?>

	<?php // The Skiplinks ?>
	
	<div class="skiplinks">
		<a href="#site_main"><?php esc_html_e('Go to main content', 'fs-townhall'); ?></a>
		<?php if ( has_nav_menu( 'main_menu' ) ) : ?>
		<a href="#site_nav"><?php esc_html_e('Go to main menu', 'fs-townhall'); ?></a>
		<?php endif; ?>
	</div>