<?php
/* trying to incorporate the sample template info from cct-manager */
 # error_reporting(-1);
list($bfa_ata, $cols, $left_col, $left_col2, $right_col, $right_col2, $bfa_ata['h_blogtitle'], $bfa_ata['h_posttitle']) = bfa_get_options();
get_header(); 
extract($bfa_ata); 

?>

<?php /* If there are any posts: */
if (have_posts()) : $bfa_ata['postcount'] = 0; /* Postcount needed for option "XX first posts full posts, rest excerpts" */ ?>

	<?php include 'bfa://content_above_loop'; ?>
	
		<?php include 'bfa://content_inside_loop'; ?>

						
	<?php endwhile; ?>

	<?php include 'bfa://content_below_loop'; ?>

<?php /* END of: If there are any posts */
else : /* If there are no posts: */ ?>

<?php include 'bfa://content_not_found'; ?>

<?php endif; /* END of: If there are no posts */ ?>

<?php # center_content_bottom does not exist
# if ( $bfa_ata['center_content_bottom'] != '' ) include 'bfa://center_content_bottom'; ?>

<?php get_footer(); ?>
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

<?php the_content(); ?>

<?php the_post_thumbnail(); ?>


<h2>Custom Fields</h2>





<?php endwhile; // end of the loop. ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>