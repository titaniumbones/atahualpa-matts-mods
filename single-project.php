<?php
/*
Template Name: Project Pages
* Unfortunately this is rather more complex than it needs to be because of 
* atahualpa.  We need to replace the "content_inside_loop with custom code that 
* uses the summarize_posts updated queries.  This is somewhat difficult becaue it's a little hard to see exactly 
* content_inside_loop is.  
*/
?><?php # error_reporting(-1);
list($bfa_ata, $cols, $left_col, $left_col2, $right_col, $right_col2, $bfa_ata['h_blogtitle'], $bfa_ata['h_posttitle']) = bfa_get_options();
get_header(); 
extract($bfa_ata); 
include_once( CCTM_PATH . '/includes/GetPostsQuery.php');


?>
<?php /* If there are any posts: */
if (have_posts()) : $bfa_ata['postcount'] = 0; /* Postcount needed for option "XX first posts full posts, rest excerpts" */ ?>
<?php include 'bfa://content_above_loop'; ?>
<?php while (have_posts()) : the_post(); $bfa_ata['postcount']++; ?>
<?php /* For SINGLE post pages if activated at ATO -> Next/Previous Navigation: */
bfa_next_previous_post_links('Top'); ?>

<!-- This section displays the headline.   -->
<?php /* Post Container starts here */
if ( function_exists('post_class') ) { ?>
  <div <?php if ( is_page() ) { post_class('post'); } else { post_class(); } ?> id="post-<?php the_ID(); ?>">
  <?php } else { ?>
  <div class="<?php echo ( is_page() ? 'page ' : '' ) . 'post" id="post-'; the_ID(); ?>">
    <?php } ?>

<?php /* bfa_post_kicker('<div class="post-kicker">','</div>');
 * 
 *      bfa_post_headline('<div class="post-headline">','</div>');
 * 
 * bfa_post_byline('<div class="post-byline">','</div>'); */ 
      bfa_post_headline('<div class="post-headline">','</div>'); 
        $project = get_post_complete($post->ID);
        //print_r($project);

?>
      <div id="authorlinks">
        <?php 
            $belongs =  get_instructor_list(CCTM::filter($project['belongs_to']), 'raw');
          if( ! empty ($belongs) ) {
            print "<h5>History Department Connections:  " . $belongs . "</h5>";
          }
        ?>
      </div>
<?php
        if (has_post_thumbnail()) {
          the_post_thumbnail( "medium");
        };
          the_content();
          if ($project['book_url']) {
            print '<p><b>Learn More at the <a href="' . $project['book_url'] . '">Project Website</a>.<p>';
          }
?> 
      <div id="terms">
     <?php print get_all_term_lists (get_the_ID(), "long") ;?>

      </div>

<!-- end of the main section -->

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
