<?php
/*
Template Name: Taxonomy Archive Page
* Unfortunately this is rather more complex than it needs to be because of the
* atahualpa theme.  We need to replace the "content_inside_loop" with custom code that 
* uses the summarize_posts updated queries.  This is somewhat difficult becaue it's a little hard to see exactly 
* what bfa://content_inside_loop is.  
* 
* Basically what this template does is to fetch a set of posts & represent them
*  on the page in a rational way. I've tried two methods -- the first uses 
* Everett's summarize_posts methods, the second uses the builtin get_posts. 
* Neither is exactly beautiful.
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

  //print_r ($me);
  /* Now build a summarize-posts query for every important CCT */
  // Start with people
  $Q = new GetPostsQuery();
  $args = array();
  $args['post_type'] = 'people';
  $args['orderby'] = 'name_last';
  $args['order'] = 'ASC';
  $args['post_status'] = 'publish';
  $args['taxonomy'] = $me->taxonomy;
  $args['taxonomy_term'] = $me->name;
  $args['taxonomy_depth'] = 1;
  $people = $Q->get_posts($args);
  //print_r($args);


  // print $Q->debug();


  $Q = new GetPostsQuery();
  $args = array();
  $args['post_type'] = 'courses';
  $args['orderby'] = 'course_number';
  $args['order'] = 'ASC';
  $args['post_status'] = 'publish';
  $args['taxonomy'] = $me->taxonomy;
  $args['taxonomy_term'] = $me->name;
  $args['taxonomy_depth'] = 3;
  $courses = $Q->get_posts($args);

  $Q = new GetPostsQuery();
  $args = array();
  $args['post_type'] = 'book';
  $args['orderby'] = 'book_author';
  $args['order'] = 'ASC';
  $args['post_status'] = 'publish';
  $args['taxonomy'] = $me->taxonomy;
  $args['taxonomy_term'] = $me->name;
  $args['taxonomy_depth'] = 3;
  $books = $Q->get_posts($args);

  $Q = new GetPostsQuery();
  $args = array();
  $args['post_type'] = 'page';
  //$args['orderby'] = 'name_last';
  //$args['order'] = 'ASC';
  $args['post_status'] = 'publish';
  $args['taxonomy'] = $me->taxonomy;
  $args['taxonomy_term'] = $me->name;
  $args['taxonomy_depth'] = 3;
  $pages = $Q->get_posts($args);

  $Q = new GetPostsQuery();
  $args = array();
  $args['post_type'] = 'post';
  //$args['orderby'] = 'name_last';
  //$args['order'] = 'ASC';
  $args['post_status'] = 'publish';
  $args['taxonomy'] = $me->taxonomy;
  $args['taxonomy_term'] = $me->name;
  $args['taxonomy_depth'] = 3;
  $posts = $Q->get_posts($args);

  //print_r($people);
$faculty = array();
$students = array();
$other_folks = array();
  foreach ($people as $p) {
    if ( (!( strpos($p['people_rank'], 'External') === false)) or 
         (!(strpos($p['people_rank'], 'Visiting') === false )) ) {
      $other_folks[] = $p;
    } elseif ( !( strpos($p['people_rank'], 'Professor') === false)  )  {
      $faculty[] = $p;
    } else {
      //     print_r($p);
      $id=$p['post_id']  ;
      $terms=get_the_terms($id, 'role');
      $slugs= array();
      foreach ($terms as $t) {
        $slugs[] = $t->slug;
      }
      //print "slugs";
      //print_r($slugs);
      if( (in_array('students', $slugs, false)) or  (in_array('masters', $slugs, false)) or  (in_array('phd', $slugs, false) ) ) {
        $students[] = $p;
      } else {
        $other_folks[] = $p;
      }
      //print_r($terms);

}
  }

$full_results = array(
                    array($faculty, "Full-time Faculty", "faculty"),
                    array($students, "Students", "students"),
                    array($other_folks, "Other Folks", "other-people"),
                    array($courses, "Courses", "courses"), 
                    array($books, "Books", "books"),
                    array($pages, "Pages", "pages"),
                    array($posts, "Other", "other")
                    );
  // atahualpa magic, discard if theme hcanged
  include 'bfa://content_above_loop'; 
  bfa_post_kicker('<div class="post-kicker">','</div>');
  // bfa_post_headline('<div class="post-headline">','</div>'); 

  printf('<div class="post-headline"><h1>%s<h1></div>', $me->name);
  bfa_post_byline('<div class="post-byline">','</div>'); 
  printf('<div class="post-content">%s</div>',$me->description);
  print uot_get_parents_and_kids($me);
  // check to make sure we have content
  if (!empty($posts) or !empty($pages) or !empty($books) or !empty($courses) or !empty($people)) {
    //table of contents
    /* print '<p><b>Jump To: </b><ul>';
     * foreach ($full_results as $t){
     *   if (! empty($t[0])) {
     *       printf('<li><a href="#results-%s">%s</a></li>', $t[2], $t[1]);
     *     }
     * }
     * print '</ul></p>'; */
  // actually generate HTML
    print '<div class="uot-columns-search">';
    foreach ($full_results as $t){
      arch_list($t[0], $t[1], $t[2]);
    }
    print '</div>';
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

