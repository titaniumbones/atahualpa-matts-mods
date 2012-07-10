<?php
/*
Template Name: Faculty Individual Page
* Unfortunately this is rather more complex than it needs to be because of 
* atahualpa.  We need to replace the "content_inside_loop" with custom code that 
* uses the summarize_posts updated queries.  This is somewhat difficult becaue it's a little hard to see exactly 
* content_inside_loop is.  
*/
?><?php # error_reporting(-1);
list($bfa_ata, $cols, $left_col, $left_col2, $right_col, $right_col2, $bfa_ata['h_blogtitle'], $bfa_ata['h_posttitle']) = bfa_get_options();
get_header(); 
extract($bfa_ata); 
include_once(CCTM_PATH . '/includes/SummarizePosts.php');
include_once( CCTM_PATH . '/includes/GetPostsQuery.php');

?>
<?php /* If there are any posts: */
if (have_posts()) : $bfa_ata['postcount'] = 0; /* Postcount needed for option "XX first posts full posts, rest excerpts" */ ?>
<?php include 'bfa://content_above_loop'; ?>
<?php while (have_posts()) : the_post(); $bfa_ata['postcount']++; ?>
<?php /* For SINGLE post pages if activated at ATO -> Next/Previous Navigation: */
bfa_next_previous_post_links('Top'); ?>

<!-- This section displays the headline.  Consider changing to first name/last name;
     but to do tht I would need to unpack bfa_post_headline -->
<?php /* Post Container starts here */
if ( function_exists('post_class') ) { ?>
  <div <?php if ( is_page() ) { post_class('post'); } else { post_class(); } ?> id="post-<?php the_ID(); ?>">
  <?php } else { ?>
  <div class="<?php echo ( is_page() ? 'page ' : '' ) . 'post" id="post-'; the_ID(); ?>">
    <?php } ?>

<?php bfa_post_kicker('<div class="post-kicker">','</div>'); ?>

<?php bfa_post_headline('<div class="post-headline">','</div>'); ?>


<?php bfa_post_byline('<div class="post-byline">','</div>'); ?>
<!-- THis contains the main info -->
  <?php //the_title('<b>', '</b>'); ?>
<?php bfa_post_bodycopy('<div class="post-bodycopy clearfix">','</div>'); ?>


		<h2>Custom Fields</h2>	
		
     <strong>Parent Course:</strong> <a href="<?php print_custom_field('coursesection_parent:to_link_href','http://yoursite.com/default/page/');?>"><?php print get_the_title(get_custom_field('coursesection_parent:raw')); ?></a><br />
		<strong>Summer Course</strong> <?php print_custom_field('coursesection_summer'); ?><br />
		<strong>Semester</strong> <?php print_custom_field('coursesection_semester'); ?><br />
		<strong>Section</strong> <?php print_custom_field('coursesection_secnum'); ?><br />
		<strong>Instructor(s):</strong> <?php 
$my_array = get_custom_field('coursesection_instructors');
foreach ($my_array as $item) {
    print  '<a href="' . get_permalink($item) . '"> ' . get_the_title($item) . '</a>'; 
}
?><br />
		<strong>Half or Year?</strong> <?php print_custom_field('course_semcode'); ?><br />
		<strong>Day and TIme</strong> <?php print_custom_field('coursesection_daytime'); ?><br />
		<strong>Joint With:</strong> <?php print_custom_field('course_jointwith:to_link', 'Click here'); ?><br />
		<strong>Additional Title</strong> <?php print_custom_field('coursesection_subtitle'); ?><br />
		<strong>Further Description</strong> <?php print_custom_field('coursesection_furtherdesc'); ?><br />
		<strong>Alert Notice</strong> <?php print_custom_field('coursesection_alertnotice'); ?><br />
		<strong>Location (room)</strong> <?php print_custom_field('coursesection_room'); ?><br />



     <?php bfa_post_pagination('<p class="post-pagination"><strong>'.__('Pages:','atahualpa').'</strong>','</p>'); ?>

     <?php bfa_post_footer('<div class="post-footer">','</div>'); ?>

</div><!-- / Post -->
						
     <?php endwhile; ?>

     <?php include 'bfa://content_below_loop'; ?>

     <?php /* END of: If there are any posts */
     else : /* If there are no posts: */ ?>

       <?php include 'bfa://content_not_found'; ?>

     <?php endif; /* END of: If there are no posts */ ?>

     <?php # center_content_bottom does not exist
     # if ( $bfa_ata['center_content_bottom'] != '' ) include 'bfa://center_content_bottom'; ?>

     <?php get_footer(); ?>
