<?php
/**
 * Sample template for displaying single people_cctm posts.
 * Save this file as as single-people_cctm.php in your current theme.
 *
 * This sample code was based off of the Starkers Baseline theme: http://starkerstheme.com/
 */

get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>


<h1><?php the_title(); ?></h1>
<table><tr><td><strong>Photo:</strong> <?php print_custom_field('photo'); ?><br /></td><td><strong>Twitter Username:</strong> <?php print_custom_field('twitter'); ?><br />

<strong>Selected Publicaitons:</strong> <?php print_custom_field('publications'); ?><br />
</td></tr>
<?php the_content(); ?>

<?php the_post_thumbnail(); ?>



<?php endwhile; // end of the loop. ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>