<?php if ( !defined('ABSPATH') ) die(); ?>
			
	<div id="site_search" aria-hidden="true">
		
		<p class="h1-like search-title"><?php esc_attr_e( 'Search', 'fs-townhall' ); ?></p>
		
		<div class="row inner">
			<div class="searchbox">
				
				<form role="search" method="get" id="searchform" class="searchform animated-search" action="<?php echo home_url( '/' ); ?>">
				    <input type="search" value="<?php echo get_search_query(); ?>" name="s" id="s" placeholder="<?php esc_attr_e( 'Enter keyword', 'fs-townhall' ); ?>">
				    <label for="s"><?php esc_html_e( 'Search for', 'fs-townhall' ); ?></label>
					<input type="submit" class="action-btn" id="searchsubmit" value="<?php esc_attr_e( 'Search', 'fs-townhall' ); ?>">
			    </form>
				
			</div>
		</div>
	</div>