<?php if ( !defined('ABSPATH') ) die();
/**
 *
 * @package WordPress
 * @subpackage FS_Townhall
 * @since 1.0
 * @version 1.0
 */
?>

					<article id="post-<?php the_ID(); ?>" <?php post_class('post-block'); ?>>
						
						
						<div class="post-figure">
							<a href="<?php the_permalink(); ?>" rel="nofollow">
							<?php if ( '' != get_the_post_thumbnail() ) {
								$img_id = get_post_thumbnail_id();
								$img_url = wp_get_attachment_image_src( $img_id, 'screen-md' );
								$img_alt = get_post_meta($img_id, '_wp_attachment_image_alt', true);
							?>
								<img src="<?php echo $img_url[0]; ?>" alt="<?php echo $img_alt; ?>">
							<?php } else { ?>
								<img src="<?php echo FS_THEME_URL . '/img/fallback.png'; ?>" alt="">
							<?php } ?>
							</a>
						</div>
						
						<div class="post-content">
							<header class="post-header">
								<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
								<?php 
									get_template_part('template-parts/event', 'meta'); 
									get_template_part('template-parts/event', 'date'); 
								?>
							</header>
							<div class="post-excerpt">
								<?php the_excerpt(); ?>
							</div>
						</div>
						
					</article>