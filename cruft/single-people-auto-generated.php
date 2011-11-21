<?php
/**
 * Sample template for displaying single people posts.
 * Save this file as as single-people.php in your current theme.
 *
 * This sample code was based off of the Starkers Baseline theme: http://starkerstheme.com/
 */

get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	

	<h1><?php the_title(); ?></h1>

		<?php the_content(); ?>

		<?php the_post_thumbnail(); ?>


		<h2>Custom Fields</h2>	
		
		<strong>Twitter Username:</strong> <?php print_custom_field('twitter'); ?><br />
		<strong>Photo:</strong> <?php print_custom_field('photo'); ?><br />
		<strong>Selected Publications:</strong> <?php print_custom_field('publications'); ?><br />
		<strong>Tel:</strong> <?php print_custom_field('telephone'); ?><br />
		<strong>Office :</strong> <?php print_custom_field('office'); ?><br />
		<strong>Blog Address:</strong> <?php print_custom_field('blog_url'); ?><br />
		<strong>Facebook ID:</strong> <?php print_custom_field('facebook'); ?><br />
		<strong>Academia.edu:</strong> <?php print_custom_field('academia'); ?><br />
		<strong>Office Hours:</strong> <?php print_custom_field('office_hours'); ?><br />
		<strong>Blog Name:</strong> <?php print_custom_field('blog_name'); ?><br />
		<strong>Email Address:</strong> <?php print_custom_field('email'); ?><br />
		<strong>Other Web URL:</strong> <?php print_custom_field('other_web_url'); ?><br />
		<strong>Other Web Name:</strong> <?php print_custom_field('other_web_name'); ?><br />
		<strong>Last Name:</strong> <?php print_custom_field('name_last'); ?><br />
		<strong>First Name:</strong> <?php print_custom_field('name_first'); ?><br />




<?php endwhile; // end of the loop. ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
