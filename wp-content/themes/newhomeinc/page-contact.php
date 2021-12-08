<?php
/**
 * Template Name: Contact Page
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package New_Home_Inc
 */

get_header();
?>
	<main id="primary" class="site-main">
		<?php  get_template_part( 'template-parts/components/global/banner/banner-dynamic-title');  ?>
		<?php interior_hero_bg_image('page_banner') ; ?>
		<?php while ( have_posts() ) : the_post();
			get_template_part( 'template-parts/content', 'contact' ); ?>
		<?php endwhile; // End of the loop.?>
	</main><!-- #main -->
<?php
get_footer();
