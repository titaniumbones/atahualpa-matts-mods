<?php
/*
Template Name: Course Individual Page
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
<?php  if((get_post_meta($post->ID, "exclusions", true))) { ?>
<div id=exclusions>
  <b>Exclusions: </b> <?php print_custom_field('exclusions'); ?>
</div>
<?php } ?>
<?php  if((get_post_meta($post->ID, "prereqs", true))) { ?>
<div id=prerequisites>
  <b>Prerequisites: </b> <?php print_custom_field('prereqs'); ?>
</div>
<?php } ?>
<div id="division">
  <?php 
    if ((get_post_meta($post->ID,'course_division', true))) {
      print "<b>Division(s): </b>";
      $divs = get_custom_field('course_division:to_array');
      $left = count($divs);
      foreach ($divs as $d) {
        print $d;
        $left = $left - 1;
        if ($left > 0) {
          print ",";
        }
        print " ";
      }
    } 
  ?>
</div>

<?php  
   // This is the interesting part of the template, where we interface to the 
   // coursesection CCT.  we will do one query, then sort into 6 categories
   $Q = new GetPostsQuery();
$args = array();
$args['post_type'] = 'coursesection';
$args['orderby'] = 'coursesection_secnum';
$args['meta_key'] = 'coursesection_parent';
$args['meta_value'] = get_the_ID();
$all_sections = $Q->get_posts($args);
  // print_r($all_sections);
  // iterate through the array & sort (not v efficient!)
  if (! empty($all_sections)) {
    $crsnumtext = get_custom_field('course_department:raw') . get_custom_field('course_number:raw') . get_custom_field('course_semcode:raw');
    $fall = array();
    $spring = array();
    $year = array();
    $summer1 = array();
    $summer2 = array();
    $summerfull = array();
  // populate the new arrays
  foreach ($all_sections as $s) {
    if ($s['coursesection_semester']=='F') {
      if ($s['coursesection_summer'] == 0) {
        array_push($fall, $s);
      }
      else array_push($summer1, $s);
    }
    if ($s['coursesection_semester']=='S') {
      if ($s['coursesection_summer'] == 0) {
        array_push($spring, $s);
      }
      else array_push($summer2, $s);
    }
    if ($s['coursesection_semester']=='Y') {
      if ($s['coursesection_summer'] == 0) {
        array_push($year, $s);
      }
      else array_push($summerfull, $s);
    }
  }
  // print out the non-empty listings
  if ((! empty($fall)) or (!empty ($spring)) or (! empty($year))) { 
    print "<h4>Course Offered This Year</h4>";
    print '<p>Course numbers ending in "F" take place in Fall term; in "S" take place in winter term; and those ending in "Y" take place over the full academic year (Fall term plus Winter term). </p>';

    print full_semester_listings($fall, "Fall", $crsnumtext );
    print full_semester_listings($spring, "Spring", $crsnumtext);
    print full_semester_listings($year, "Full-Year", $crsnumtext);
  }
  if ((! empty($summer1)) or (!empty ($summer2)) or (! empty($summerfull))) {
    print "<p><b>In Summer</b></p>>";
    print '<p>Course numbers ending in "F" take place in the first summer term; in "S", in the second summer term; and those ending in "Y" take place over the full two-term summer session. </p>';
    print full_semester_listings($summer1, "Summer Term 1 Instructors: ", $crsnumtext);
    print full_semester_listings($summer2, "Summer Term 2 Instructors: ", $crsnumtext);
    print full_semester_listings($summerfull, "Summer 2-Term Instructors: ", $crsnumtext);
  }
  // refer back to the Calendar.  I need a way to link to the *current* listings!
  // this is difficult b/c A&S doesn't have a robust listings page.
  print '<p><b><i>See the <a href="http://www.artsci.utoronto.ca/current/undergraduate/course/timetable">Arts & Sciences Timetables</a> for full details</i></b><p>';
  }
  else {
    print('<h4><i>Not Offered this Year</i></h4>');
  }
  ?>

<div id="terms">
     <?php 

    print get_all_term_lists (get_the_ID(), 'long') ;?>
</div>

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
