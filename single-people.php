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

<?php 
  if (get_custom_field('people_emeritus') == 1) {
        $em = ' Emeritus';
      }
      else {
        $em = '';
      }
  if (get_custom_field('people_onleave') == 1) {
      $ol = ', <i>Currently On Leave</i>';
        }
    else {
      $ol = '';
    }
  $status_line = '<b>' . get_custom_field('people_rank') . $em . $ol . '</b>';
    //  print 
    
  //  printf("<h4>%s</h4>", $status_line);
bfa_post_headline('<div class="post-headline">',$status_line . '</div>'); ?>


<?php bfa_post_byline('<div class="post-byline">','</div>'); 

?>

<!-- Photo and Contact details -->
<table>
  <tr>
    <td width="150">
      <?php  if((get_post_meta($post->ID, "photo", true))) { ?>
      <div id=photo>
        <?php print_custom_field('photo:to_image_tag', 'thumbnail'); 
              ?>
      </div>
      <?php }?>
    </td>
    <td valign=top>
      <?php  if((get_post_meta($post->ID, "office", true)) or (get_post_meta($post->ID, "telephone", true)) or (get_post_meta($post->ID, "email", true))) { ?>
      <div id=contact>
        <?php 
         $campus = get_the_term_list(get_the_ID(), 'campus', '', ', ');
           if (! empty($campus) ) {
             print "        <strong>Campus:</strong> ";
               print $campus . '<br>';
           } ?>
        <strong>Contact</strong></br>
                                                                                                                                                            
        <ul>
          <?php  if((get_post_meta($post->ID, "office", true))) { ?>
          <div id=office>
            <li><em>Office: </em><?php print_custom_field('office'); ?></li>
          </div>
          <?php } ?>
          <?php  if((get_post_meta($post->ID, "office_hours", true))) { ?>
          <div id=office-hours>
            <li><em>Office Hours: </em><?php print_custom_field('office_hours'); ?></li>
          </div>
          <?php } ?>

          <?php  if((get_post_meta($post->ID, "telephone", true))) { ?>
          <div id=telephone>
            <li><em>Tel: </em><?php print_custom_field('telephone'); ?></li>
          </div>
          <?php } ?><?php  if((get_post_meta($post->ID, "email", true))) { ?>
          <div id=email>
            <li><em>Email: </em><a href="mailto:<?php print_custom_field('email'); ?>"><?php print_custom_field('email'); ?></a></li>
          </div>
          <?php } ?>
      </ul></div>
      <?php } ?>
      <?php  if((get_post_meta($post->ID, "blog_url", true)) or (get_post_meta($post->ID, "other_web_url", true))) { ?>
      <div id=other-web>
        <strong>Web</strong>
        <ul>
          <?php  if((get_post_meta($post->ID, "blog_url", true))) { ?>
          <div id=person_blog>
            <li><a href="<?php print_custom_field('blog_url'); ?>"><?php print_custom_field('blog_name'); ?></a></li>
          </div>
          <?php } ?>
          <?php  if((get_post_meta($post->ID, "other_web_url", true))) { ?>
          <div id=facebook>
            <li><a href="<?php print_custom_field('other_web_url'); ?>"><?php print_custom_field('other_web_name'); ?></a></li>
          </div>
          <?php } ?>
      </ul></div>
      <?php } ?>
      <?php  if((get_post_meta($post->ID, "twitter", true)) or (get_post_meta($post->ID, "facebook", true)) or (get_post_meta($post->ID, "academia", true))) { ?>
    </td>
    <td valign=top>
      <div id=socialmedia>
        <strong>Social Media</strong>
        <ul>
          <?php  if((get_post_meta($post->ID, "twitter", true))) { ?>
          <div id=twitter>
            <li><a href="http://twitter.com/<?php print_custom_field('twitter'); ?>">Twitter</a></li>
          </div>
          <?php } ?>
          <?php  if((get_post_meta($post->ID, "facebook", true))) { ?>
          <div id=facebook>
            <li><a href="http://www.facebook.com/<?php print_custom_field('facebook'); ?>">Facebook</a></li>
          </div>
          <?php } ?>
          <?php  if((get_post_meta($post->ID, "academia", true))) { ?>
          <div id=academia>
            <li><a href="http://utoronto.academia.edu/<?php print_custom_field('academia'); ?>">Academia.edu</a></li>
          </div>
          <?php } ?>
      </ul></div>
      <?php } ?>
    </td>
  </tr>


</table>

<!-- Body of Post -->
     <?php bfa_post_bodycopy('<div class="post-bodycopy clearfix">','</div>'); ?>

<!-- Atempts at a dynamic listing of courses/ books -->
<!-- courses    -->
<?php 
  print uot_get_my_advisees(get_the_ID());
  print uot_get_my_courses(get_the_ID());
// would prefer a jquery hide/show function that displays at least the first para of book decription and a link to book page 
  print uot_get_my_books(get_the_ID());
  ?>
<!-- Taxonomic Terms -->
     <?php print get_all_term_lists (get_the_ID(), 'long') ;?>

     <?php if((get_post_meta($post->ID, "publications", true))) { ?>
     <div id=person-publications>
       <strong>Selected Publications:</strong><br />
       <?php print_custom_field('publications'); ?>
    <?php } ?>
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
