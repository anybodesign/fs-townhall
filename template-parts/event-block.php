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
						
						<?php if ( '' != get_the_post_thumbnail() ) {
							$img_id = get_post_thumbnail_id();
							$img_url = wp_get_attachment_image_src( $img_id, 'screen-md' );
							$img_alt = get_post_meta($img_id, '_wp_attachment_image_alt', true);
						?>
						<div class="post-figure">
							<a href="<?php the_permalink(); ?>" rel="nofollow">
							<img src="<?php echo $img_url[0]; ?>" alt="<?php echo $img_alt; ?>">
							</a>
						</div>
						<?php } ?>
						
						<div class="post-content">
							<header class="post-header">
								<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
								<?php 
									get_template_part('template-parts/event', 'meta'); 
									
									// https://stackoverflow.com/questions/14631947/strtotime-translations
									// https://support.advancedcustomfields.com/forums/topic/extract-and-compare-month-from-two-date-time-picker-fields/ 
									
									$date_start = get_field('event_starting_date');
									$date_end = get_field('event_ending_date');
									setlocale (LC_ALL, 'fr_FR');
									$id1 = intval(strftime("%m", strtotime($date_start))) - 1;
									$id2 = intval(strftime("%m", strtotime($date_end))) - 1;
									$abr_map = array(
										'Janvier',
										'Février',
										'Mars',
										'Avril',
										'Mai',
										'Juin',
										'Juillet',
										'Août',
										'Septembre',
										'Octobre',
										'Novembre',
										'Décembre'
									);
									$translate_fr1 = htmlentities($abr_map[$id1], ENT_COMPAT, 'UTF-8');
									$translate_fr2 = htmlentities($abr_map[$id2], ENT_COMPAT, 'UTF-8');
									
									$month1 = $translate_fr1;
									$month2 = $translate_fr2; 
									
									$date1 = strtotime($date_start);
									$date2 = strtotime($date_end);
									
									$day1 = date('j', $date1);
									//$month1 = date('F', $date1);
									$year1 = date('Y', $date1);
									
									$day2 = date('j', $date2);
									//$month2 = date('F', $date2);
									$year2 = date('Y', $date2);
								?>
								<div class="event-date">
									<div class="the-date">
										<?php if ($date_start) { ?>
										<span class="day"><?php echo $day1; ?></span>
										<span class="month"><?php echo $month1; ?></span>
											<?php if ($date_end) { ?>
											<span> › </span>
											<span class="day"><?php echo $day2; ?></span>
											<span class="month"><?php echo $month2; ?></span>
											<?php } ?>
										<span class="year">
											<?php 
												echo $year1;
												if ( $date_end && $year1 != $year2 ) {	
												echo ' - '.$year2;
											} ?>
										</span>
										<?php } ?>
									</div>
								</div>
								
								
							</header>
							<div class="post-excerpt">
								<?php the_excerpt(); ?>
							</div>
						</div>
						
					</article>