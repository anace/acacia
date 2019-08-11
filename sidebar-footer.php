<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package acacia
 */

if ( ! ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) ||is_active_sidebar( 'footer-4' ) ) ) {
	return;
}
$acacia_footer_widgets = get_theme_mod( 'footer_widgets', 2);
?>

<aside id="footer-widgets" class="footer-widgets <?php echo 'columns-'.esc_attr($acacia_footer_widgets) ?> widget-area" role="complementary">
	<?php if (is_active_sidebar( 'footer-1' ) ) : ?>
		<div class="footer-widget">
			<?php dynamic_sidebar( 'footer-1' ); ?>
		</div>
	<?php endif; ?>

	<?php if (is_active_sidebar( 'footer-2' ) ) : ?>
		<div class="footer-widget">
			<?php dynamic_sidebar( 'footer-2' ); ?>
		</div>
	<?php endif; ?>
	
	<?php if (is_active_sidebar( 'footer-3' ) ) : ?>
		<div class="footer-widget">
			<?php dynamic_sidebar( 'footer-3' ); ?>
		</div>
	<?php endif; ?>

	<?php if (is_active_sidebar( 'footer-4' ) ) : ?>
		<div class="footer-widget">
			<?php dynamic_sidebar( 'footer-4' ); ?>
		</div>
	<?php endif; ?>
</aside><!-- #secondary -->
