<?php
/*
Template Name: People Template
*/
?>


<?php # error_reporting(-1);
list($bfa_ata, $cols, $left_col, $left_col2, $right_col, $right_col2, $bfa_ata['h_blogtitle'], $bfa_ata['h_posttitle']) = bfa_get_options();
get_header(); 
extract($bfa_ata); 

?>
<?php /* If there are any posts: */
if (have_posts()) : $bfa_ata['postcount'] = 0; /* Postcount needed for option "XX first posts full posts, rest excerpts" */ ?>
<?php include 'bfa://content_above_loop'; ?>
<?php while (have_posts()) : the_post(); $bfa_ata['postcount']++; ?>
<?php /* For SINGLE post pages if activated at ATO -> Next/Previous Navigation: */
bfa_next_previous_post_links('Top'); ?>

<?php /* Post Container starts here */
if ( function_exists('post_class') ) { ?>
  <div <?php if ( is_page() ) { post_class('post'); } else { post_class(); } ?> id="post-<?php the_ID(); ?>">
  <?php } else { ?>
  <div class="<?php echo ( is_page() ? 'page ' : '' ) . 'post" id="post-'; the_ID(); ?>">
    <?php } ?>

<?php bfa_post_kicker('<div class="post-kicker">','</div>'); ?>

<?php bfa_post_headline('<div class="post-headline">','</div>'); ?>

<?php bfa_post_byline('<div class="post-byline">','</div>'); ?>

<table width = "100%">
<?php 
  $post_arguments = array(
    'numberposts'     => -1,
    'offset'          => 0,
    'orderby'         => 'title',
    'order'           => 'ASC',
    'taxonomy'        => 'departmental-role',
    'departmental-role'=> get_the_title(ID),
    'post_type'       => 'people_cctm',
    'post_status'     => 'publish' ); 
  $the_people = get_posts($post_arguments);
  foreach($the_people as $this_post) : setup_postdata($this_post); ?>

    <tr><td width="60">
    <?php if((get_post_meta($this_post->ID, "photo", true))) {
      $image_id = get_custom_field('photo'); 
      print wp_get_attachment_image($image_id, array(75,100));
      }?>  <p>hello</p>
      </td>
      <td>
      <strong><a href="<?php the_permalink(); ?>"><?php echo $this_post->post_title; ?></a></strong>
      <?php $my_excerpt = $this_post->post_excerpt;
        if ($my_excerpt) {
          echo $my_excerpt;
        } else {
      echo $this_post->post_content;
      } ?>
    </td>/<tr>
  <?php endforeach; ?>
</table>

   
     

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
