<?php
/*
Template Name: Taxonomy Archive Page
* Unfortunately this is rather more complex than it needs to be because of the
* atahualpa theme.  We need to replace the "content_inside_loop with custom code that 
* uses the summarize_posts updated queries.  This is somewhat difficult becaue it's a little hard to see exactly 
* what bfa://content_inside_loop is.  
* 
* Basically what this template does is to fetch a set of posts & represent them
*  on the page in a rational way. Currently using summarize_posts from CCTM
*/
?>
<?php  error_reporting(1);
list($bfa_ata, $cols, $left_col, $left_col2, $right_col, $right_col2, $bfa_ata['h_blogtitle'], $bfa_ata['h_posttitle']) = bfa_get_options();
get_header(); 
extract($bfa_ata); 
  // include CCTM get_posts
include_once(CCTM_PATH . '/includes/SummarizePosts.php');
include_once( CCTM_PATH . '/includes/GetPostsQuery.php');
?>

<?php 
  // first identify the term & taxonomy we've arrived at
  $me = get_queried_object();
  /* Now build a summarize-posts query for every important CCT */
  // Start with people
  $Q = new GetPostsQuery();
  $args = array();
  $args['post_type'] = 'book';
  $args['orderby'] = 'book_year';
  $args['order'] = 'DESC';
  $args['post_status'] = 'publish';
  $books = $Q->get_posts($args);

  // atahualpa magic, discard if theme changed
  include 'bfa://content_above_loop'; 
  bfa_post_kicker('<div class="post-kicker">','</div>');
  //printf('<div class="post-headline"><h1>%s<h1></div>', $me->name);
  printf('<div class="post-headline"><h1>%s<h1></div>', "Faculty Publications");
  bfa_post_byline('<div class="post-byline">','</div>'); 
  printf('<div class="post-content">%s</div>',$me->description);

  // check to make sure we have content
  if ( !empty($books) ) {
    print book_summary ($books);
  }
  // give a 'no content' message
  else {
    include 'bfa://content_not_found';
  }
?>

	

	<?php bfa_post_pagination('<p class="post-pagination"><strong>'.__('Pages:','atahualpa').'</strong>','</p>'); ?>

	<?php bfa_post_footer('<div class="post-footer">','</div>'); ?>						

	<?php include 'bfa://content_below_loop'; ?>


<?php # center_content_bottom does not exist
# if ( $bfa_ata['center_content_bottom'] != '' ) include 'bfa://center_content_bottom'; ?>

<?php get_footer(); ?>

